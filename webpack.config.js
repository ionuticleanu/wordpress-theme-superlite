const fs = require('fs');
const path = require('path');
const { generateThemeCss, THEME_JSON_PATH } = require('./scripts/generate-theme-css');

// Generate src/scss/_global-styles.scss from theme.json before compiling SCSS
generateThemeCss();

// Ensure @wordpress/scripts outputs both standard scripts and ES modules (Interactivity API)
process.env.WP_EXPERIMENTAL_MODULES = process.env.WP_EXPERIMENTAL_MODULES || 'true';
process.env.WP_SOURCE_PATH = process.env.WP_SOURCE_PATH || 'src';

const defaultConfig = require('@wordpress/scripts/config/webpack.config');

const distDir = path.resolve(__dirname, 'dist');
const [scriptConfig, moduleConfig] = Array.isArray(defaultConfig)
	? defaultConfig
	: [defaultConfig, null];

// 1. Configure standard scripts, SCSS, and block editor bundles
const defaultScriptEntry = scriptConfig.entry;
scriptConfig.output = {
	...scriptConfig.output,
	path: distDir,
};
scriptConfig.entry = async () => {
	const blockEntries =
		typeof defaultScriptEntry === 'function'
			? await defaultScriptEntry()
			: defaultScriptEntry;

	const extraEntries = {};
	const globalJs = path.resolve(__dirname, 'src/js/main.js');
	const globalScss = path.resolve(__dirname, 'src/scss/main.scss');

	if (fs.existsSync(globalJs)) {
		extraEntries['js/main'] = globalJs;
	}
	if (fs.existsSync(globalScss)) {
		extraEntries['css/main'] = globalScss;
	}

	return {
		...blockEntries,
		...extraEntries,
	};
};

// Strip empty .js stubs emitted by Webpack for standalone CSS entry points
// and keep src/scss/_global-styles.scss synced when theme.json changes in watch mode
scriptConfig.plugins.push({
	apply(compiler) {
		const { Compilation } = compiler.webpack;
		compiler.hooks.watchRun.tap('SyncThemeJsonCss', () => {
			generateThemeCss();
		});
		compiler.hooks.thisCompilation.tap('RemoveEmptyCssJs', (compilation) => {
			compilation.fileDependencies.add(THEME_JSON_PATH);
			compilation.hooks.processAssets.tap(
				{
					name: 'RemoveEmptyCssJs',
					stage: Compilation.PROCESS_ASSETS_STAGE_OPTIMIZE_INLINE,
				},
				(assets) => {
					Object.keys(assets).forEach((asset) => {
						if (/^css\/.*\.js(\.map)?$/.test(asset)) {
							compilation.deleteAsset(asset);
						}
					});
				}
			);
		});
	},
});

// 2. Configure ES Module bundles (viewScriptModule for @wordpress/interactivity)
if (moduleConfig) {
	moduleConfig.output = {
		...moduleConfig.output,
		path: distDir,
	};
}

module.exports = moduleConfig ? [scriptConfig, moduleConfig] : scriptConfig;
