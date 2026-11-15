<?php
/**
 * Title: Customer Testimonials
 * Slug: superlite/testimonials
 * Categories: superlite-sections, testimonials
 * Description: Three-column grid of customer quotes and attributions.
 */
?>
<!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide">
	<!-- wp:group {"className":"superlite-section-header","layout":{"type":"default"}} -->
	<div class="wp-block-group superlite-section-header">
		<!-- wp:paragraph {"className":"superlite-eyebrow"} -->
		<p class="superlite-eyebrow"><?php esc_html_e('Client Stories', 'superlite'); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2} -->
		<h2 class="wp-block-heading"><?php esc_html_e('Trusted by Families & Local Businesses', 'superlite'); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|lg","left":"var:preset|spacing|lg"}}}} -->
	<div class="wp-block-columns">
		<!-- wp:column {"className":"superlite-quote"} -->
		<div class="wp-block-column superlite-quote">
			<!-- wp:paragraph {"className":"superlite-quote__text"} -->
			<p class="superlite-quote__text"><?php esc_html_e('“From our very first phone call to the final walkthrough, they were punctual, transparent, and treated our property with genuine care.”', 'superlite'); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"className":"superlite-quote__author"} -->
			<p class="superlite-quote__author"><?php esc_html_e('— Elena M., Homeowner', 'superlite'); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"className":"superlite-quote"} -->
		<div class="wp-block-column superlite-quote">
			<!-- wp:paragraph {"className":"superlite-quote__text"} -->
			<p class="superlite-quote__text"><?php esc_html_e('“It is rare to find a team that takes this much pride in their craft. They finished right on schedule and the quality speaks for itself.”', 'superlite'); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"className":"superlite-quote__author"} -->
			<p class="superlite-quote__author"><?php esc_html_e('— David & Sarah K., Local Clients', 'superlite'); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"className":"superlite-quote"} -->
		<div class="wp-block-column superlite-quote">
			<!-- wp:paragraph {"className":"superlite-quote__text"} -->
			<p class="superlite-quote__text"><?php esc_html_e('“We have worked with them for over ten years now. Honest pricing, dependable advice, and friendly service every single time.”', 'superlite'); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"className":"superlite-quote__author"} -->
			<p class="superlite-quote__author"><?php esc_html_e('— Marcus T., Small Business Owner', 'superlite'); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
