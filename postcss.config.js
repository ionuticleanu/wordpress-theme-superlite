const purgeCSSPlugin = require('@fullhuman/postcss-purgecss');

const isProduction = process.env.NODE_ENV === 'production';

module.exports = {
	plugins: [
		require('@tailwindcss/postcss'),
		require('autoprefixer'),
		...(isProduction
			? [
					purgeCSSPlugin({
						content: [
							'./templates/**/*.html',
							'./parts/**/*.html',
							'./patterns/**/*.php',
							'./menus/**/*.html',
							'./inc/**/*.php',
							'./functions.php',
							'./src/**/*.{js,jsx,ts,tsx,php,html}',
						],
						defaultExtractor: (content) =>
							content.match(/[\w-/:]+(?<!:)/g) || [],
						safelist: {
							standard: [
								'html',
								'body',
								'alignwide',
								'alignfull',
								'alignleft',
								'alignright',
								'aligncenter',
								'has-global-padding',
								'screen-reader-text',
								'wp-site-blocks',
								'wp-element-button',
							],
							deep: [
								/^is-layout-/,
								/^is-menu-/,
								/^has-child/,
								/^open-on-/,
								/^wp-block-navigation/,
								/^wp-block-page-list/,
								/^wp-block-home-link/,
								/^wp-block-group/,
								/^wp-block-query/,
								/^wp-block-post-/,
								/^wp-block-button/,
								/^wp-block-heading/,
								/^wp-block-paragraph/,
								/^wp-block-list/,
								/^wp-block-image/,
								/^wp-block-quote/,
								/^wp-block-columns/,
								/^wp-block-column/,
								/^wp-block-separator/,
							],
						},
					}),
					require('cssnano')({
						preset: [
							'default',
							{
								discardComments: {
									removeAll: true,
								},
							},
						],
					}),
			  ]
			: []),
	],
};
