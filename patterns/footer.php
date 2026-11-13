<?php
/**
 * Title: Footer
 * Slug: superlite/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 * Inserter: no
 */

$copyright_year = wp_date('Y');
$site_name      = get_bloginfo('name');
$author_name    = wp_get_theme()->get('Author');
$author_url     = wp_get_theme()->get('AuthorURI');
?>
<!-- wp:group {"className":"site-footer","layout":{"type":"constrained"}} -->
<div class="wp-block-group site-footer">
	<!-- wp:group {"align":"wide","className":"site-footer__main","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
	<div class="wp-block-group alignwide site-footer__main">
		<!-- wp:group {"className":"site-footer__brand","layout":{"type":"flex","orientation":"vertical"}} -->
		<div class="wp-block-group site-footer__brand">
			<!-- wp:site-title {"level":0} /-->
			<!-- wp:site-tagline /-->
		</div>
		<!-- /wp:group -->

		<!-- wp:navigation {"menuSlug":"footer","overlayMenu":"never","className":"site-footer__nav","layout":{"type":"flex","flexWrap":"wrap"}} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"align":"wide","className":"site-footer__bottom","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
	<div class="wp-block-group alignwide site-footer__bottom">
		<!-- wp:paragraph {"fontSize":"sm"} -->
		<p class="has-sm-font-size">&copy; <?php echo esc_html($copyright_year); ?> <?php echo esc_html($site_name); ?></p>
		<!-- /wp:paragraph -->
		<?php if ($author_name) : ?>
			<!-- wp:paragraph {"fontSize":"sm"} -->
			<p class="has-sm-font-size">
				<?php
				if ($author_url) {
					printf(
						/* translators: %s: Theme author link. */
						esc_html__('By %s', 'superlite'),
						'<a href="' . esc_url($author_url) . '">' . esc_html($author_name) . '</a>'
					);
				} else {
					printf(
						/* translators: %s: Theme author name. */
						esc_html__('By %s', 'superlite'),
						esc_html($author_name)
					);
				}
				?>
			</p>
			<!-- /wp:paragraph -->
		<?php endif; ?>
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
