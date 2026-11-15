<?php
/**
 * Title: Feature Cards with Pictures
 * Slug: superlite/feature-cards
 * Categories: superlite-sections
 * Description: Three-column grid of cards where each card includes a replaceable photo, heading, and description.
 */
$placeholder_card = esc_url(get_template_directory_uri() . '/assets/images/placeholder-card.svg');
?>
<!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide">
	<!-- wp:group {"className":"superlite-section-header","layout":{"type":"default"}} -->
	<div class="wp-block-group superlite-section-header">
		<!-- wp:paragraph {"className":"superlite-eyebrow"} -->
		<p class="superlite-eyebrow"><?php esc_html_e('What We Offer', 'superlite'); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2} -->
		<h2 class="wp-block-heading"><?php esc_html_e('Tailored Solutions Built Around Your Needs', 'superlite'); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph -->
		<p><?php esc_html_e('Replace the photos and descriptions below to showcase your core services, products, or areas of expertise.', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|lg","left":"var:preset|spacing|lg"}}}} -->
	<div class="wp-block-columns">
		<!-- wp:column {"className":"superlite-card"} -->
		<div class="wp-block-column superlite-card">
			<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $placeholder_card; ?>" alt="<?php esc_attr_e('Service 1 photo', 'superlite'); ?>"/></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading"><?php esc_html_e('Custom Consultation & Planning', 'superlite'); ?></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p><?php esc_html_e('We start by listening carefully to your goals, inspecting the details firsthand, and providing a transparent, itemized recommendation.', 'superlite'); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"className":"superlite-card"} -->
		<div class="wp-block-column superlite-card">
			<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $placeholder_card; ?>" alt="<?php esc_attr_e('Service 2 photo', 'superlite'); ?>"/></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading"><?php esc_html_e('Precision Execution & Quality', 'superlite'); ?></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p><?php esc_html_e('Handled directly by our experienced in-house team using proven materials and time-tested techniques that stand up to daily use.', 'superlite'); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"className":"superlite-card"} -->
		<div class="wp-block-column superlite-card">
			<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $placeholder_card; ?>" alt="<?php esc_attr_e('Service 3 photo', 'superlite'); ?>"/></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading"><?php esc_html_e('Ongoing Care & Support', 'superlite'); ?></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p><?php esc_html_e('Our relationship does not end when the job wraps up. We stand behind our work with responsive follow-up and seasonal maintenance.', 'superlite'); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
