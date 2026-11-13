<?php

require_once get_template_directory() . '/inc/cleanup.php';
require_once get_template_directory() . '/inc/navigation.php';

// Auto-register all compiled blocks in dist/blocks/
add_action('init', function () {
	$blocks_dir = get_template_directory() . '/dist/blocks';
	if (!is_dir($blocks_dir)) {
		return;
	}

	foreach (glob($blocks_dir . '/*/block.json') as $block_json) {
		register_block_type(dirname($block_json));
	}
});

// Enqueue global theme CSS & JS
add_action('wp_enqueue_scripts', function () {
	$theme_dir = get_template_directory();
	$theme_uri = get_template_directory_uri();

	$css_file = $theme_dir . '/dist/css/main.css';
	if (file_exists($css_file) && filesize($css_file) > 0) {
		wp_enqueue_style(
			'superlite-main',
			$theme_uri . '/dist/css/main.css',
			[],
			filemtime($css_file)
		);
	}

	$js_file  = $theme_dir . '/dist/js/main.js';
	$js_asset = $theme_dir . '/dist/js/main.asset.php';
	if (file_exists($js_file) && filesize($js_file) > 0) {
		$asset = file_exists($js_asset)
			? require $js_asset
			: ['dependencies' => [], 'version' => filemtime($js_file)];

		wp_enqueue_script(
			'superlite-main',
			$theme_uri . '/dist/js/main.js',
			$asset['dependencies'],
			$asset['version'],
			true
		);
	}
});