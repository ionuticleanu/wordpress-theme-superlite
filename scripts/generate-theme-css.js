const fs = require('fs');
const path = require('path');

const ROOT_DIR = path.resolve(__dirname, '..');
const THEME_JSON_PATH = path.join(ROOT_DIR, 'theme.json');
const OUTPUT_PATH = path.join(ROOT_DIR, 'src/scss/_global-styles.scss');

/**
 * Convert a CSS length in px or rem to rem for fluid clamp() calculation.
 * Returns null if the unit is not px/rem.
 */
function toRem(value) {
	if (typeof value !== 'string') {
		return null;
	}
	const match = value.trim().match(/^(-?\d*\.?\d+)(px|rem)$/);
	if (!match) {
		return null;
	}
	const num = parseFloat(match[1]);
	return match[2] === 'px' ? num / 16 : num;
}

/**
 * Compute a WordPress-style fluid clamp() value for a fontSize entry.
 */
function resolveFontSize(entry) {
	if (!entry.fluid) {
		return entry.size;
	}
	if (typeof entry.fluid === 'object' && entry.fluid.min && entry.fluid.max) {
		const minRem = toRem(entry.fluid.min);
		const maxRem = toRem(entry.fluid.max);
		if (minRem !== null && maxRem !== null && maxRem > minRem) {
			// WordPress default fluid viewport range: 320px (20rem) to 1600px (100rem)
			const slope = (maxRem - minRem) / (100 - 20);
			const intercept = minRem - slope * 20;
			const vw = +(slope * 100).toFixed(4);
			const rem = +intercept.toFixed(4);
			const preferred = `calc(${rem}rem + ${vw}vw)`;
			return `clamp(${entry.fluid.min}, ${preferred}, ${entry.fluid.max})`;
		}
		return `clamp(${entry.fluid.min}, ${entry.size}, ${entry.fluid.max})`;
	}
	return entry.size;
}

/**
 * Map a theme.json style object (color, typography, spacing, border) to CSS declarations.
 */
function styleObjectToDeclarations(style = {}) {
	const decls = [];

	if (style.color) {
		if (style.color.background) {
			decls.push(`background-color: ${style.color.background};`);
		}
		if (style.color.text) {
			decls.push(`color: ${style.color.text};`);
		}
	}

	if (style.typography) {
		const map = {
			fontFamily: 'font-family',
			fontSize: 'font-size',
			fontWeight: 'font-weight',
			fontStyle: 'font-style',
			lineHeight: 'line-height',
			letterSpacing: 'letter-spacing',
			textDecoration: 'text-decoration',
			textTransform: 'text-transform',
		};
		for (const [key, prop] of Object.entries(map)) {
			if (style.typography[key] !== undefined) {
				decls.push(`${prop}: ${style.typography[key]};`);
			}
		}
	}

	if (style.border) {
		if (style.border.radius) {
			decls.push(`border-radius: ${style.border.radius};`);
		}
		if (style.border.color) {
			decls.push(`border-color: ${style.border.color};`);
		}
		if (style.border.width) {
			decls.push(`border-width: ${style.border.width};`);
		}
		if (style.border.style) {
			decls.push(`border-style: ${style.border.style};`);
		}
	}

	if (style.spacing && style.spacing.padding) {
		const p = style.spacing.padding;
		if (typeof p === 'string') {
			decls.push(`padding: ${p};`);
		} else {
			for (const side of ['top', 'right', 'bottom', 'left']) {
				if (p[side] !== undefined) {
					decls.push(`padding-${side}: ${p[side]};`);
				}
			}
		}
	}

	if (style.spacing && style.spacing.margin) {
		const m = style.spacing.margin;
		if (typeof m === 'string') {
			decls.push(`margin: ${m};`);
		} else {
			for (const side of ['top', 'right', 'bottom', 'left']) {
				if (m[side] !== undefined) {
					decls.push(`margin-${side}: ${m[side]};`);
				}
			}
		}
	}

	return decls;
}

function formatRule(selector, decls) {
	if (!decls.length) {
		return '';
	}
	return `${selector} {\n\t${decls.join('\n\t')}\n}\n`;
}

function generateThemeCss() {
	const raw = fs.readFileSync(THEME_JSON_PATH, 'utf8');
	const theme = JSON.parse(raw);
	const settings = theme.settings || {};
	const styles = theme.styles || {};

	const rootVars = [];
	const utilityRules = [];

	// Layout variables
	if (settings.layout) {
		if (settings.layout.contentSize) {
			rootVars.push(`--wp--style--global--content-size: ${settings.layout.contentSize};`);
		}
		if (settings.layout.wideSize) {
			rootVars.push(`--wp--style--global--wide-size: ${settings.layout.wideSize};`);
		}
	}

	// Block gap & root padding variables
	if (styles.spacing && styles.spacing.blockGap) {
		rootVars.push(`--wp--style--block-gap: ${styles.spacing.blockGap};`);
	}
	const useRootPadding = Boolean(settings.useRootPaddingAwareAlignments);
	if (useRootPadding && styles.spacing && styles.spacing.padding) {
		for (const side of ['top', 'right', 'bottom', 'left']) {
			const val = styles.spacing.padding[side] || '0px';
			rootVars.push(`--wp--style--root--padding-${side}: ${val};`);
		}
	}

	// Color palette
	for (const entry of settings.color?.palette || []) {
		rootVars.push(`--wp--preset--color--${entry.slug}: ${entry.color};`);
		utilityRules.push(
			`.has-${entry.slug}-color { color: var(--wp--preset--color--${entry.slug}) !important; }`,
			`.has-${entry.slug}-background-color { background-color: var(--wp--preset--color--${entry.slug}) !important; }`,
			`.has-${entry.slug}-border-color { border-color: var(--wp--preset--color--${entry.slug}) !important; }`
		);
	}

	// Font families
	for (const entry of settings.typography?.fontFamilies || []) {
		rootVars.push(`--wp--preset--font-family--${entry.slug}: ${entry.fontFamily};`);
		utilityRules.push(
			`.has-${entry.slug}-font-family { font-family: var(--wp--preset--font-family--${entry.slug}) !important; }`
		);
	}

	// Font sizes
	for (const entry of settings.typography?.fontSizes || []) {
		rootVars.push(`--wp--preset--font-size--${entry.slug}: ${resolveFontSize(entry)};`);
		utilityRules.push(
			`.has-${entry.slug}-font-size { font-size: var(--wp--preset--font-size--${entry.slug}) !important; }`
		);
	}

	// Spacing sizes
	for (const entry of settings.spacing?.spacingSizes || []) {
		rootVars.push(`--wp--preset--spacing--${entry.slug}: ${entry.size};`);
	}

	const sections = [
		'/* Auto-generated from theme.json by scripts/generate-theme-css.js. Do not edit directly. */',
		formatRule(':root', rootVars),
	];

	// Body styles (omit padding on body when useRootPaddingAwareAlignments is enabled)
	const bodyStyle = { ...styles };
	if (useRootPadding && bodyStyle.spacing) {
		bodyStyle.spacing = { ...bodyStyle.spacing };
		delete bodyStyle.spacing.padding;
	}
	const bodyDecls = ['margin: 0;', ...styleObjectToDeclarations(bodyStyle)];
	sections.push(formatRule('body', bodyDecls));

	// Root padding & layout rules
	if (useRootPadding) {
		sections.push(
			[
				'.has-global-padding {',
				'\tpadding-right: var(--wp--style--root--padding-right, 0px);',
				'\tpadding-left: var(--wp--style--root--padding-left, 0px);',
				'}',
				'.has-global-padding > .alignfull {',
				'\tmargin-right: calc(var(--wp--style--root--padding-right, 0px) * -1);',
				'\tmargin-left: calc(var(--wp--style--root--padding-left, 0px) * -1);',
				'}',
				'.has-global-padding :where(.has-global-padding:not(.wp-block-block)) > .alignfull {',
				'\tmargin-right: 0;',
				'\tmargin-left: 0;',
				'}',
			].join('\n')
		);
	}

	sections.push(
		[
			':where(.is-layout-constrained) > :where(:not(.alignleft):not(.alignright):not(.alignfull)) {',
			'\tmax-width: var(--wp--style--global--content-size);',
			'\tmargin-left: auto !important;',
			'\tmargin-right: auto !important;',
			'}',
			':where(.is-layout-constrained) > .alignwide {',
			'\tmax-width: var(--wp--style--global--wide-size);',
			'}',
			':where(.is-layout-flow) > * + *,',
			':where(.is-layout-constrained) > * + * {',
			'\tmargin-block-start: var(--wp--style--block-gap);',
			'\tmargin-block-end: 0;',
			'}',
			':where(.is-layout-flex) {',
			'\tdisplay: flex;',
			'\tflex-wrap: wrap;',
			'\talign-items: center;',
			'\tgap: var(--wp--style--block-gap);',
			'}',
			':where(.is-layout-flex).is-nowrap { flex-wrap: nowrap; }',
			':where(.is-layout-flex).is-vertical { flex-direction: column; align-items: stretch; }',
			':where(.is-layout-flex).is-content-justification-left { justify-content: flex-start; }',
			':where(.is-layout-flex).is-content-justification-center { justify-content: center; }',
			':where(.is-layout-flex).is-content-justification-right { justify-content: flex-end; }',
			':where(.is-layout-flex).is-content-justification-space-between { justify-content: space-between; }',
			':where(.is-layout-grid) {',
			'\tdisplay: grid;',
			'\tgap: var(--wp--style--block-gap);',
			'}',
			'/*! purgecss ignore */',
			'img:is([sizes="auto" i],[sizes^="auto," i]) { contain-intrinsic-size: 3000px 1500px; }',
			'.alignleft { float: left; margin-inline-start: 0; margin-inline-end: 2em; }',
			'.alignright { float: right; margin-inline-start: 2em; margin-inline-end: 0; }',
			'.aligncenter { clear: both; margin-inline-start: auto; margin-inline-end: auto; }',
		].join('\n')
	);

	// Element styles
	const elementSelectors = {
		link: ':where(body a)',
		button: ':where(.wp-element-button, .wp-block-button__link)',
		heading: ':where(h1, h2, h3, h4, h5, h6)',
		h1: ':where(h1)',
		h2: ':where(h2)',
		h3: ':where(h3)',
		h4: ':where(h4)',
		h5: ':where(h5)',
		h6: ':where(h6)',
	};

	for (const [element, config] of Object.entries(styles.elements || {})) {
		const selector = elementSelectors[element];
		if (!selector) {
			continue;
		}
		sections.push(formatRule(selector, styleObjectToDeclarations(config)));
		if (config[':hover']) {
			const hoverSelector = selector.replace(/:where\((.+)\)/, (_, inner) =>
				`:where(${inner
					.split(',')
					.map((s) => `${s.trim()}:hover`)
					.join(', ')})`
			);
			sections.push(formatRule(hoverSelector, styleObjectToDeclarations(config[':hover'])));
		}
	}

	if (utilityRules.length) {
		sections.push(utilityRules.join('\n') + '\n');
	}

	const output = sections.filter(Boolean).join('\n');
	fs.mkdirSync(path.dirname(OUTPUT_PATH), { recursive: true });

	// Only write if content changed to avoid infinite watch loops in Webpack dev mode
	const existing = fs.existsSync(OUTPUT_PATH) ? fs.readFileSync(OUTPUT_PATH, 'utf8') : null;
	if (existing !== output) {
		fs.writeFileSync(OUTPUT_PATH, output, 'utf8');
	}
}

if (require.main === module) {
	generateThemeCss();
}

module.exports = {
	generateThemeCss,
	THEME_JSON_PATH,
};
