<?php

/**
 * Theme-first, database-second boilerplate pages.
 *
 * Serves `pages/<slug>.php` when no published database `page` exists for that route
 * (and `pages/front-page.php` on `/` when no static DB front page is configured).
 * Logged-in editors/admins can promote any fallback page into an editable DB `page`.
 */

/**
 * Resolve and parse a boilerplate page file from `pages/<slug>.php`.
 *
 * @param string $slug Sanitized page slug.
 * @return array{slug: string, title: string, content: string, file: string}|null
 */
function superlite_get_boilerplate_page($slug) {
	$slug = sanitize_title($slug);
	if ($slug === '' || !preg_match('/^[a-z0-9-]+$/', $slug)) {
		return null;
	}

	$file = get_theme_file_path('pages/' . $slug . '.php');
	if (!is_readable($file)) {
		return null;
	}

	$headers = get_file_data($file, [
		'title' => 'Title',
	]);

	ob_start();
	include $file;
	$content = trim(ob_get_clean());

	$title = trim((string) ($headers['title'] ?? ''));
	if ($title === '') {
		$title = ucwords(str_replace('-', ' ', $slug));
	}

	return [
		'slug'    => $slug,
		'title'   => $title,
		'content' => $content,
		'file'    => $file,
	];
}

/**
 * Return the active virtual boilerplate slug for the current request, if any.
 *
 * @param string|null $set Optional slug to store.
 * @return string|null
 */
function superlite_virtual_page_slug($set = null) {
	static $slug = null;
	if ($set !== null) {
		$slug = $set;
	}
	return $slug;
}

/**
 * Return the synthetic post ID used for the active virtual page, if any.
 *
 * @param int|null $set Optional ID to store.
 * @return int|null
 */
function superlite_virtual_page_id($set = null) {
	static $post_id = null;
	if ($set !== null) {
		$post_id = $set;
	}
	return $post_id;
}

/**
 * Build a synthetic WP_Post and populate the main WP_Query so block templates render it cleanly.
 *
 * @param WP_Query $wp_query  Main query instance.
 * @param array    $page_data Parsed boilerplate page array.
 */
function superlite_populate_virtual_page_query($wp_query, $page_data) {
	$synthetic_id = 900000000 + (abs((int) crc32($page_data['slug'])) % 99999999);
	while (WP_Post::get_instance($synthetic_id)) {
		$synthetic_id++;
	}

	$now      = current_time('mysql');
	$now_gmt  = current_time('mysql', true);
	$post_obj = (object) [
		'ID'                    => $synthetic_id,
		'post_author'           => '0',
		'post_date'             => $now,
		'post_date_gmt'         => $now_gmt,
		'post_content'          => $page_data['content'],
		'post_title'            => $page_data['title'],
		'post_excerpt'          => '',
		'post_status'           => 'publish',
		'comment_status'        => 'closed',
		'ping_status'           => 'closed',
		'post_password'         => '',
		'post_name'             => $page_data['slug'] === 'front-page' ? 'home' : $page_data['slug'],
		'to_ping'               => '',
		'pinged'                => '',
		'post_modified'         => $now,
		'post_modified_gmt'     => $now_gmt,
		'post_content_filtered' => '',
		'post_parent'           => 0,
		'guid'                  => home_url($page_data['slug'] === 'front-page' ? '/' : '/' . $page_data['slug'] . '/'),
		'menu_order'            => 0,
		'post_type'             => 'page',
		'post_mime_type'        => '',
		'comment_count'         => '0',
		'filter'                => 'raw',
	];

	wp_cache_set($synthetic_id, $post_obj, 'posts');
	$post = new WP_Post($post_obj);

	$wp_query->posts             = [$post];
	$wp_query->post              = $post;
	$wp_query->queried_object    = $post;
	$wp_query->queried_object_id = $post->ID;
	$wp_query->post_count        = 1;
	$wp_query->found_posts       = 1;
	$wp_query->max_num_pages     = 1;
	$wp_query->is_404            = false;
	$wp_query->is_page           = true;
	$wp_query->is_singular       = true;
	$wp_query->is_home           = false;
	$wp_query->is_archive        = false;
	$wp_query->is_posts_page     = false;

	$GLOBALS['post'] = $post;
	setup_postdata($post);
	status_header(200);

	superlite_virtual_page_slug($page_data['slug']);
	superlite_virtual_page_id($post->ID);
}

/**
 * Intercept 404s for sub-pages that have a matching file in `pages/<slug>.php`.
 *
 * @param bool     $preempt  Whether to short-circuit default 404 handling.
 * @param WP_Query $wp_query Main query instance.
 * @return bool
 */
function superlite_handle_virtual_page($preempt, $wp_query) {
	if ($preempt || is_admin() || !$wp_query->is_main_query()) {
		return $preempt;
	}

	global $wp;
	$slug = trim((string) (($wp->request ?? '') !== '' ? $wp->request : get_query_var('pagename', '')), '/');
	if ($slug === '' || $slug === 'front-page') {
		return $preempt;
	}

	$page_data = superlite_get_boilerplate_page($slug);
	if (!$page_data) {
		return $preempt;
	}

	superlite_populate_virtual_page_query($wp_query, $page_data);
	return true;
}
add_filter('pre_handle_404', 'superlite_handle_virtual_page', 10, 2);

/**
 * Serve `pages/front-page.php` on `/` when no published static DB front page is configured.
 */
function superlite_handle_virtual_front_page() {
	if (is_admin() || !is_main_query() || !is_front_page() || !is_home()) {
		return;
	}

	if (get_option('show_on_front') === 'page') {
		$front_id = (int) get_option('page_on_front');
		if ($front_id > 0 && get_post_status($front_id) === 'publish') {
			return;
		}
	}

	$page_data = superlite_get_boilerplate_page('front-page');
	if (!$page_data) {
		return;
	}

	global $wp_query;
	superlite_populate_virtual_page_query($wp_query, $page_data);
}
add_action('wp', 'superlite_handle_virtual_front_page');

/**
 * Add `home` body class when rendering the virtual front page.
 *
 * @param string[] $classes Existing body classes.
 * @return string[]
 */
function superlite_virtual_front_page_body_class($classes) {
	if (superlite_virtual_page_slug() === 'front-page' && !in_array('home', $classes, true)) {
		$classes[] = 'home';
	}
	return $classes;
}
add_filter('body_class', 'superlite_virtual_front_page_body_class');

/**
 * Build the nonce-protected URL to promote a virtual boilerplate page into a DB page.
 *
 * @param string $slug Boilerplate page slug.
 * @return string
 */
function superlite_get_promote_page_url($slug) {
	return wp_nonce_url(
		admin_url('admin-post.php?action=superlite_create_page&slug=' . rawurlencode($slug)),
		'superlite_create_page_' . $slug
	);
}

/**
 * Point edit links for virtual pages to the promote-to-DB action.
 *
 * @param string $link    Default edit URL.
 * @param int    $post_id Post ID.
 * @return string
 */
function superlite_virtual_edit_post_link($link, $post_id) {
	$virtual_id = superlite_virtual_page_id();
	$slug       = superlite_virtual_page_slug();
	if ($virtual_id && $slug && (int) $post_id === $virtual_id) {
		return current_user_can('publish_pages') ? superlite_get_promote_page_url($slug) : '';
	}
	return $link;
}
add_filter('get_edit_post_link', 'superlite_virtual_edit_post_link', 10, 2);

/**
 * Add an admin-bar shortcut to promote the current theme-file page into an editable DB page.
 *
 * @param WP_Admin_Bar $wp_admin_bar Admin bar instance.
 */
function superlite_virtual_page_admin_bar($wp_admin_bar) {
	$slug = superlite_virtual_page_slug();
	if (!$slug || is_admin() || !current_user_can('publish_pages')) {
		return;
	}

	$wp_admin_bar->add_node([
		'id'    => 'superlite-edit-boilerplate-page',
		'title' => esc_html__('Edit Page (Save to DB)', 'superlite'),
		'href'  => superlite_get_promote_page_url($slug),
	]);
}
add_action('admin_bar_menu', 'superlite_virtual_page_admin_bar', 80);

/**
 * Create a database `page` from `pages/<slug>.php` and open it in the Block Editor.
 */
function superlite_handle_create_page_from_boilerplate() {
	$slug = isset($_GET['slug']) ? sanitize_title(wp_unslash($_GET['slug'])) : '';
	if ($slug === '' || !current_user_can('publish_pages')) {
		wp_die(esc_html__('You do not have permission to create this page.', 'superlite'), 403);
	}

	check_admin_referer('superlite_create_page_' . $slug);

	$page_data = superlite_get_boilerplate_page($slug);
	if (!$page_data) {
		wp_die(esc_html__('Boilerplate page file not found.', 'superlite'), 404);
	}

	$db_slug  = $slug === 'front-page' ? 'home' : $slug;
	$existing = null;

	if ($slug === 'front-page' && get_option('show_on_front') === 'page') {
		$front_id = (int) get_option('page_on_front');
		if ($front_id > 0 && get_post_status($front_id) !== 'trash') {
			$existing = get_post($front_id);
		}
	}

	if (!$existing instanceof WP_Post) {
		$existing = get_page_by_path($db_slug, OBJECT, 'page');
	}

	if ($existing instanceof WP_Post && $existing->post_status !== 'trash') {
		$post_id = $existing->ID;
	} else {
		$post_id = wp_insert_post([
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $page_data['title'],
			'post_name'    => $db_slug,
			'post_content' => wp_slash($page_data['content']),
		], true);

		if (is_wp_error($post_id)) {
			wp_die(esc_html($post_id->get_error_message()), 500);
		}
	}

	if ($slug === 'front-page') {
		update_option('show_on_front', 'page');
		update_option('page_on_front', $post_id);
	}

	wp_safe_redirect(admin_url('post.php?post=' . $post_id . '&action=edit'));
	exit;
}
add_action('admin_post_superlite_create_page', 'superlite_handle_create_page_from_boilerplate');
