<?php

/**
 * Disable WordPress emojis across frontend, admin, feeds, and emails.
 */
function superlite_disable_emojis() {
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_enqueue_scripts', 'wp_enqueue_emoji_styles');
	remove_action('admin_enqueue_scripts', 'wp_enqueue_emoji_styles');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

	add_filter('emoji_svg_url', '__return_false');
	add_filter('tiny_mce_plugins', function ($plugins) {
		return is_array($plugins) ? array_diff($plugins, ['wpemoji']) : [];
	});
}
add_action('init', 'superlite_disable_emojis');

/**
 * Remove classic theme CSS and unnecessary <head> links/oEmbed discovery.
 */
function superlite_cleanup_head() {
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'wp_shortlink_wp_head');
	remove_action('wp_head', 'rest_output_link_wp_head');
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	remove_action('wp_head', 'wp_oembed_add_host_js');

	if (!is_admin()) {
		remove_action('enqueue_block_assets', 'wp_enqueue_classic_theme_styles');
		remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
		remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
	}
}
add_action('init', 'superlite_cleanup_head');

/**
 * Bundle core block CSS into main.css on the frontend instead of separate requests.
 *
 * @param bool $load Whether to load separate block stylesheets.
 * @return bool
 */
function superlite_disable_separate_block_assets($load) {
	return is_admin() ? $load : false;
}
add_filter('should_load_separate_core_block_assets', 'superlite_disable_separate_block_assets');

/**
 * Prevent WordPress from inlining small block stylesheets on the frontend.
 *
 * @param int $limit Inline size limit in bytes.
 * @return int
 */
function superlite_disable_inline_block_styles($limit) {
	return is_admin() ? $limit : 0;
}
add_filter('styles_inline_size_limit', 'superlite_disable_inline_block_styles');

/**
 * Dequeue core block CSS and remove frontend jQuery / oEmbed JS.
 */
function superlite_cleanup_frontend_assets() {
	if (is_admin()) {
		return;
	}

	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');
	wp_deregister_script('jquery');
	wp_deregister_script('wp-embed');
}
add_action('wp_enqueue_scripts', 'superlite_cleanup_frontend_assets', 100);

/**
 * Dequeue and deregister all core `wp-block-*` handles since they are bundled in main.css.
 */
function superlite_dequeue_core_block_styles() {
	if (is_admin()) {
		return;
	}

	$styles = wp_styles();
	foreach (array_keys($styles->registered) as $handle) {
		if (strpos($handle, 'wp-block-') === 0) {
			wp_dequeue_style($handle);
			wp_deregister_style($handle);
		}
	}
}
add_action('wp_enqueue_scripts', 'superlite_dequeue_core_block_styles', 100);
add_action('wp_print_styles', 'superlite_dequeue_core_block_styles', 1);
add_action('wp_print_footer_scripts', 'superlite_dequeue_core_block_styles', 1);
