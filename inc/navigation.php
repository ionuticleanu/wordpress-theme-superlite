<?php

/**
 * Resolve root-relative `url` attributes inside parsed navigation inner blocks
 * against `home_url()` so file-based menus work in subdirectory installs.
 *
 * @param array $blocks Parsed block arrays.
 * @return array
 */
function superlite_resolve_menu_urls($blocks) {
	foreach ($blocks as &$block) {
		$url = $block['attrs']['url'] ?? '';
		if (is_string($url) && strpos($url, '/') === 0 && strpos($url, '//') !== 0) {
			$block['attrs']['url'] = home_url($url);
		}
		if (!empty($block['innerBlocks'])) {
			$block['innerBlocks'] = superlite_resolve_menu_urls($block['innerBlocks']);
		}
	}
	return $blocks;
}

/**
 * Resolve `menuSlug` on `core/navigation` blocks to a `wp_navigation` post ID,
 * or fall back to a theme-file menu definition in `menus/<slug>.html`.
 *
 * @param array $parsed_block Parsed block array.
 * @return array
 */
function superlite_resolve_navigation_slug($parsed_block) {
	if (($parsed_block['blockName'] ?? '') !== 'core/navigation') {
		return $parsed_block;
	}

	if (!empty($parsed_block['attrs']['ref']) || empty($parsed_block['attrs']['menuSlug'])) {
		return $parsed_block;
	}

	$slug = sanitize_title($parsed_block['attrs']['menuSlug']);
	if ($slug === '') {
		return $parsed_block;
	}

	$nav_post = get_page_by_path($slug, OBJECT, 'wp_navigation');
	if ($nav_post instanceof WP_Post) {
		$parsed_block['attrs']['ref'] = $nav_post->ID;
		return $parsed_block;
	}

	$menu_file = get_template_directory() . '/menus/' . $slug . '.html';
	if (is_readable($menu_file)) {
		$contents = file_get_contents($menu_file);
		if ($contents !== false) {
			$parsed = parse_blocks("<!-- wp:navigation -->\n" . $contents . "\n<!-- /wp:navigation -->");
			if (!empty($parsed[0]['innerBlocks'])) {
				$parsed_block['innerBlocks']  = superlite_resolve_menu_urls($parsed[0]['innerBlocks']);
				$parsed_block['innerContent'] = $parsed[0]['innerContent'];
			}
		}
	}

	return $parsed_block;
}
add_filter('render_block_data', 'superlite_resolve_navigation_slug');
