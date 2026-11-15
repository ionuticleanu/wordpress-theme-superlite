document.addEventListener('DOMContentLoaded', () => {
	const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	if (prefersReducedMotion) {
		return;
	}

	// 1. Material 3 interactive pointer ripple on all buttons
	document.addEventListener('pointerdown', (event) => {
		const button = event.target.closest('.wp-element-button, .wp-block-button__link');
		if (!button) {
			return;
		}

		const rect = button.getBoundingClientRect();
		const size = Math.max(rect.width, rect.height) * 1.4;
		const x = event.clientX - rect.left;
		const y = event.clientY - rect.top;

		const ripple = document.createElement('span');
		ripple.className = 'm3-ripple';
		ripple.style.width = `${size}px`;
		ripple.style.height = `${size}px`;
		ripple.style.left = `${x}px`;
		ripple.style.top = `${y}px`;

		button.appendChild(ripple);
		ripple.addEventListener('animationend', () => {
			ripple.remove();
		});
	});

	// 2. Interactive 3D tilt & radial spotlight glow on cards
	const cards = document.querySelectorAll('.superlite-card, .superlite-stat, .superlite-quote');
	cards.forEach((card) => {
		card.addEventListener('pointermove', (event) => {
			const rect = card.getBoundingClientRect();
			const x = event.clientX - rect.left;
			const y = event.clientY - rect.top;
			const centerX = rect.width / 2;
			const centerY = rect.height / 2;

			const rotateX = ((y - centerY) / centerY) * -3.5;
			const rotateY = ((x - centerX) / centerX) * 3.5;

			card.style.setProperty('--spot-x', `${x}px`);
			card.style.setProperty('--spot-y', `${y}px`);
			card.style.setProperty('--card-rx', `${rotateX.toFixed(2)}deg`);
			card.style.setProperty('--card-ry', `${rotateY.toFixed(2)}deg`);
		});

		card.addEventListener('pointerleave', () => {
			card.style.setProperty('--card-rx', '0deg');
			card.style.setProperty('--card-ry', '0deg');
		});
	});

	// 3. Smooth count-up animation for statistics numbers (e.g. "2,400+", "99%", "35+")
	const animateStatCounter = (el) => {
		if (el.dataset.counted === 'true') {
			return;
		}
		const rawText = el.textContent.trim();
		const match = rawText.match(/^([^\d]*)(\d[\d,]*)(.*)$/);
		if (!match) {
			return;
		}

		el.dataset.counted = 'true';
		const prefix = match[1];
		const numericPart = match[2];
		const suffix = match[3];
		const hasCommas = numericPart.includes(',');
		const target = parseInt(numericPart.replace(/,/g, ''), 10);

		if (Number.isNaN(target) || target <= 0) {
			return;
		}

		const duration = 1300;
		const startTime = performance.now();

		const formatNum = (val) => {
			const rounded = Math.round(val);
			return hasCommas ? rounded.toLocaleString('en-US') : String(rounded);
		};

		const step = (now) => {
			const progress = Math.min((now - startTime) / duration, 1);
			// Cubic ease-out
			const eased = 1 - Math.pow(1 - progress, 3);
			el.textContent = `${prefix}${formatNum(target * eased)}${suffix}`;

			if (progress < 1) {
				window.requestAnimationFrame(step);
			} else {
				el.textContent = rawText;
			}
		};

		window.requestAnimationFrame(step);
	};

	// 4. Scroll-reveal animations & staggered columns/checklists
	const targets = document.querySelectorAll(
		'main .wp-block-post-title, main .wp-block-post-content > *, main .wp-block-post-template > li'
	);
	if (!targets.length) {
		return;
	}

	const animateItem = (el, animationClass) => {
		el.classList.remove('superlite-reveal-pending');
		el.classList.add('animate__animated', animationClass);
	};

	const staggerColumns = (container) => {
		const cols = container.classList.contains('wp-block-columns')
			? container.querySelectorAll(':scope > .wp-block-column')
			: container.querySelectorAll('.wp-block-columns > .wp-block-column');
		cols.forEach((col, index) => {
			col.style.setProperty('--animate-delay', `${index * 100}ms`);
			col.style.animationDelay = `${index * 100}ms`;
			col.classList.add('animate__animated', 'animate__fadeInUp');
		});

		const checklistItems = container.querySelectorAll('ul.superlite-checklist li');
		checklistItems.forEach((item, index) => {
			item.style.animationDelay = `${150 + index * 110}ms`;
			item.classList.add('animate__animated', 'animate__fadeInLeft');
		});

		container.querySelectorAll('.superlite-stat__number').forEach(animateStatCounter);
	};

	const triggerAnimation = (el) => {
		if (el.classList.contains('wp-block-columns') || el.querySelector('.wp-block-columns')) {
			el.classList.remove('superlite-reveal-pending');
			animateItem(el, 'animate__fadeIn');
			staggerColumns(el);
			return;
		}
		const animationClass = el.matches('.wp-block-post-title, h1, h2, h3')
			? 'animate__fadeInUp'
			: 'animate__fadeIn';
		animateItem(el, animationClass);
	};

	const viewportBottom = window.innerHeight * 0.95;

	if (!('IntersectionObserver' in window)) {
		targets.forEach(triggerAnimation);
		return;
	}

	const observer = new IntersectionObserver(
		(entries) => {
			entries.forEach((entry) => {
				if (!entry.isIntersecting) {
					return;
				}
				triggerAnimation(entry.target);
				observer.unobserve(entry.target);
			});
		},
		{ threshold: 0.1 }
	);

	targets.forEach((el) => {
		const rect = el.getBoundingClientRect();
		if (rect.top <= viewportBottom) {
			triggerAnimation(el);
		} else {
			el.classList.add('superlite-reveal-pending');
			observer.observe(el);
		}
	});
});
