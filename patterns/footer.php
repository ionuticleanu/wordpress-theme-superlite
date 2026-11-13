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
<!-- wp:group {"tagName":"footer","layout":{"type":"constrained"}} -->
<footer class="wp-block-group">
	<!-- wp:group {"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
	<div class="wp-block-group">
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
</footer>
<!-- /wp:group -->
