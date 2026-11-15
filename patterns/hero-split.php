<?php
/**
 * Title: Hero with Picture & Call to Action
 * Slug: superlite/hero-split
 * Categories: superlite-sections, banner
 * Description: Two-column hero section with eyebrow badge, headline, intro text, buttons, and a replaceable picture.
 */
$placeholder_wide = esc_url(get_template_directory_uri() . '/assets/images/placeholder-wide.svg');
?>
<!-- wp:columns {"verticalAlignment":"center","align":"wide","className":"superlite-hero","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|xl","left":"var:preset|spacing|xl"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center superlite-hero">
	<!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%">
		<!-- wp:paragraph {"className":"superlite-eyebrow"} -->
		<p class="superlite-eyebrow"><?php esc_html_e('Family Owned & Operated', 'superlite'); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
		<h2 class="wp-block-heading has-2-xl-font-size"><?php esc_html_e('Dependable Craftsmanship & Honest Service Across Generations', 'superlite'); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"fontSize":"lg"} -->
		<p class="has-lg-font-size"><?php esc_html_e('We combine decades of hands-on experience with personal attention on every project—delivering quality results our neighbors can count on.', 'superlite'); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|lg"}}}} -->
		<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--lg)">
			<!-- wp:button -->
			<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url(home_url('/services/')); ?>"><?php esc_html_e('Explore Our Services', 'superlite'); ?></a></div>
			<!-- /wp:button -->

			<!-- wp:button {"className":"is-style-outline"} -->
			<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Request a Free Quote', 'superlite'); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%">
		<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
		<figure class="wp-block-image size-large"><img src="<?php echo $placeholder_wide; ?>" alt="<?php esc_attr_e('Featured business photo', 'superlite'); ?>"/></figure>
		<!-- /wp:image -->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->
