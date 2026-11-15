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
 * Resolve WordPress theme.json `var:preset|<type>|<slug>` and `var:custom|<path>` syntax
 * into standard CSS `var(--wp--...)` references.
 */
function resolvePresetValue(value) {
	if (typeof value !== 'string') {
		return value;
	}
	if (value.startsWith('var:preset|')) {
		const [, type, slug] = value.split('|');
		if (type && slug) {
			return `var(--wp--preset--${type}--${slug})`;
		}
	}
	if (value.startsWith('var:custom|')) {
		const parts = value.slice('var:custom|'.length).split('|');
		if (parts.length) {
			return `var(--wp--custom--${parts.join('--')})`;
		}
	}
	return value;
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
			decls.push(`background-color: ${resolvePresetValue(style.color.background)};`);
		}
		if (style.color.text) {
			decls.push(`color: ${resolvePresetValue(style.color.text)};`);
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
				decls.push(`${prop}: ${resolvePresetValue(style.typography[key])};`);
			}
		}
	}

	if (style.border) {
		if (style.border.radius) {
			decls.push(`border-radius: ${resolvePresetValue(style.border.radius)};`);
		}
		if (style.border.color) {
			decls.push(`border-color: ${resolvePresetValue(style.border.color)};`);
		}
		if (style.border.width) {
			decls.push(`border-width: ${resolvePresetValue(style.border.width)};`);
		}
		if (style.border.style) {
			decls.push(`border-style: ${style.border.style};`);
		}
		for (const side of ['top', 'right', 'bottom', 'left']) {
			const sideBorder = style.border[side];
			if (sideBorder && typeof sideBorder === 'object') {
				if (sideBorder.color) {
					decls.push(`border-${side}-color: ${resolvePresetValue(sideBorder.color)};`);
				}
				if (sideBorder.width) {
					decls.push(`border-${side}-width: ${resolvePresetValue(sideBorder.width)};`);
				}
				if (sideBorder.style) {
					decls.push(`border-${side}-style: ${sideBorder.style};`);
				}
			}
		}
	}

	if (style.spacing && style.spacing.padding) {
		const p = style.spacing.padding;
		if (typeof p === 'string') {
			decls.push(`padding: ${resolvePresetValue(p)};`);
		} else {
			for (const side of ['top', 'right', 'bottom', 'left']) {
				if (p[side] !== undefined) {
					decls.push(`padding-${side}: ${resolvePresetValue(p[side])};`);
				}
			}
		}
	}

	if (style.spacing && style.spacing.margin) {
		const m = style.spacing.margin;
		if (typeof m === 'string') {
			decls.push(`margin: ${resolvePresetValue(m)};`);
		} else {
			for (const side of ['top', 'right', 'bottom', 'left']) {
				if (m[side] !== undefined) {
					decls.push(`margin-${side}: ${resolvePresetValue(m[side])};`);
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

function blockNameToSelector(blockName) {
	const specialSelectors = {
		'core/paragraph': ':where(p)',
		'core/heading': ':where(h1, h2, h3, h4, h5, h6)',
		'core/list': ':where(ul, ol)',
	};
	if (specialSelectors[blockName]) {
		return specialSelectors[blockName];
	}
	const [namespace, name] = blockName.split('/');
	if (!name) {
		return `:where(.wp-block-${namespace})`;
	}
	if (namespace === 'core') {
		return `:where(.wp-block-${name})`;
	}
	return `:where(.wp-block-${namespace}-${name})`;
}

function appendElementRules(target, elementsConfig, baseSelectors) {
	for (const [element, config] of Object.entries(elementsConfig || {})) {
		const selector = baseSelectors[element];
		if (!selector) {
			continue;
		}
		target.push(formatRule(selector, styleObjectToDeclarations(config)));
		if (config[':hover']) {
			const hoverSelector = selector.replace(/:where\((.+)\)/, (_, inner) =>
				`:where(${inner
					.split(',')
					.map((s) => `${s.trim()}:hover`)
					.join(', ')})`
			);
			target.push(formatRule(hoverSelector, styleObjectToDeclarations(config[':hover'])));
		}
	}
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
		rootVars.push(`--wp--style--block-gap: ${resolvePresetValue(styles.spacing.blockGap)};`);
	}
	const useRootPadding = Boolean(settings.useRootPaddingAwareAlignments);
	if (useRootPadding && styles.spacing && styles.spacing.padding) {
		for (const side of ['top', 'right', 'bottom', 'left']) {
			const val = styles.spacing.padding[side] || '0px';
			rootVars.push(`--wp--style--root--padding-${side}: ${resolvePresetValue(val)};`);
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
		'/*! purgecss start ignore */',
		formatRule(':root', rootVars),
		'*, ::before, ::after {\n\tbox-sizing: border-box;\n}\n',
	];

	// Body styles (omit padding on body when useRootPaddingAwareAlignments is enabled)
	const bodyStyle = { ...styles };
	if (useRootPadding && bodyStyle.spacing) {
		bodyStyle.spacing = { ...bodyStyle.spacing };
		delete bodyStyle.spacing.padding;
	}
	const bodyDecls = ['margin: 0;', ...styleObjectToDeclarations(bodyStyle)];
	sections.push(formatRule(':where(body)', bodyDecls));

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

	appendElementRules(sections, styles.elements, elementSelectors);

	// Per-block styles from theme.json
	for (const [blockName, blockConfig] of Object.entries(styles.blocks || {})) {
		if (!blockConfig || typeof blockConfig !== 'object') {
			continue;
		}
		const selector = blockNameToSelector(blockName);
		const decls = styleObjectToDeclarations(blockConfig);
		if (blockConfig.spacing?.blockGap !== undefined) {
			decls.push(`--wp--style--block-gap: ${resolvePresetValue(blockConfig.spacing.blockGap)};`);
		}
		sections.push(formatRule(selector, decls));

		if (blockConfig.elements) {
			const innerBase = selector.replace(/^:where\((.+)\)$/, '$1');
			const blockElementSelectors = {
				link: `:where(${innerBase} a)`,
				button: `:where(${innerBase} .wp-element-button, ${innerBase} .wp-block-button__link)`,
				heading: `:where(${innerBase} h1, ${innerBase} h2, ${innerBase} h3, ${innerBase} h4, ${innerBase} h5, ${innerBase} h6)`,
				h1: `:where(${innerBase} h1)`,
				h2: `:where(${innerBase} h2)`,
				h3: `:where(${innerBase} h3)`,
				h4: `:where(${innerBase} h4)`,
				h5: `:where(${innerBase} h5)`,
				h6: `:where(${innerBase} h6)`,
			};
			appendElementRules(sections, blockConfig.elements, blockElementSelectors);
		}
	}

	if (utilityRules.length) {
		sections.push(utilityRules.join('\n'));
	}

	sections.push('/*! purgecss end ignore */\n');

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
