<?php
/**
 * Title: About Our Family Business
 */
$placeholder_wide = esc_url(get_template_directory_uri() . '/assets/images/placeholder-wide.svg');
$placeholder_card = esc_url(get_template_directory_uri() . '/assets/images/placeholder-card.svg');
?>
<!-- wp:columns {"verticalAlignment":"center","align":"wide","className":"superlite-hero","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|xl","left":"var:preset|spacing|xl"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center superlite-hero">
	<!-- wp:column {"verticalAlignment":"center","width":"52%"} -->
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:52%">
		<!-- wp:paragraph {"className":"superlite-eyebrow"} -->
		<p class="superlite-eyebrow"><?php esc_html_e('Our Story', 'superlite'); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
		<h2 class="wp-block-heading has-2-xl-font-size"><?php esc_html_e('Built on Hard Work, Honesty, and Community Trust', 'superlite'); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"fontSize":"lg"} -->
		<p class="has-lg-font-size"><?php esc_html_e('What began as a small family workshop has grown into a trusted local business serving multiple generations of clients across our community.', 'superlite'); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph -->
		<p><?php esc_html_e('While our tools and capabilities have evolved over the decades, our core promise remains the same: treat every customer with fairness, communicate openly, and stand proudly behind our work.', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column {"verticalAlignment":"center","width":"48%"} -->
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:48%">
		<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
		<figure class="wp-block-image size-large"><img src="<?php echo $placeholder_wide; ?>" alt="<?php esc_attr_e('Family team photo', 'superlite'); ?>"/></figure>
		<!-- /wp:image -->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->

<?php require get_template_directory() . '/patterns/stats-bar.php'; ?>

<!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide">
	<!-- wp:group {"className":"superlite-section-header","layout":{"type":"default"}} -->
	<div class="wp-block-group superlite-section-header">
		<!-- wp:paragraph {"className":"superlite-eyebrow"} -->
		<p class="superlite-eyebrow"><?php esc_html_e('Meet the Team', 'superlite'); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2} -->
		<h2 class="wp-block-heading"><?php esc_html_e('The People Behind Every Project', 'superlite'); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph -->
		<p><?php esc_html_e('Replace the photos and bios below with your own family members and key team leaders.', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|lg","left":"var:preset|spacing|lg"}}}} -->
	<div class="wp-block-columns">
		<!-- wp:column {"className":"superlite-card"} -->
		<div class="wp-block-column superlite-card">
			<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $placeholder_card; ?>" alt="<?php esc_attr_e('Founder portrait', 'superlite'); ?>"/></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading"><?php esc_html_e('Founder & Senior Advisor', 'superlite'); ?></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p><?php esc_html_e('Over 35 years of hands-on industry experience, overseeing quality standards and mentoring our craftsman team.', 'superlite'); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"className":"superlite-card"} -->
		<div class="wp-block-column superlite-card">
			<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $placeholder_card; ?>" alt="<?php esc_attr_e('Operations lead portrait', 'superlite'); ?>"/></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading"><?php esc_html_e('Operations & Project Lead', 'superlite'); ?></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p><?php esc_html_e('Coordinates scheduling, client consultations, and on-site execution to ensure every project finishes on time.', 'superlite'); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"className":"superlite-card"} -->
		<div class="wp-block-column superlite-card">
			<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $placeholder_card; ?>" alt="<?php esc_attr_e('Customer care lead portrait', 'superlite'); ?>"/></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading"><?php esc_html_e('Client Care & Estimating', 'superlite'); ?></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p><?php esc_html_e('Your primary point of contact for transparent quotes, material selections, and long-term follow-up care.', 'superlite'); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<?php require get_template_directory() . '/patterns/testimonials.php'; ?>
