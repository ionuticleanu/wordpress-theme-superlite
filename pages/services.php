<?php
/**
 * Title: Our Services
 */
$placeholder_card = esc_url(get_template_directory_uri() . '/assets/images/placeholder-card.svg');
$placeholder_wide = esc_url(get_template_directory_uri() . '/assets/images/placeholder-wide.svg');
?>
<!-- wp:columns {"verticalAlignment":"center","align":"wide","className":"superlite-hero","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|xl","left":"var:preset|spacing|xl"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center superlite-hero">
	<!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%">
		<!-- wp:paragraph {"className":"superlite-eyebrow"} -->
		<p class="superlite-eyebrow"><?php esc_html_e('Services & Solutions', 'superlite'); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2,"fontSize":"2xl"} -->
		<h2 class="wp-block-heading has-2-xl-font-size"><?php esc_html_e('Practical, Dependable Solutions Tailored to Your Goals', 'superlite'); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"fontSize":"lg"} -->
		<p class="has-lg-font-size"><?php esc_html_e('Every project starts with a conversation. Browse our core service packages below, or contact us for a custom recommendation.', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%">
		<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
		<figure class="wp-block-image size-large"><img src="<?php echo $placeholder_wide; ?>" alt="<?php esc_attr_e('Services overview photo', 'superlite'); ?>"/></figure>
		<!-- /wp:image -->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->

<?php require get_template_directory() . '/patterns/feature-cards.php'; ?>

<!-- wp:columns {"align":"wide","className":"superlite-stat-grid","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|md","left":"var:preset|spacing|md"}}}} -->
<div class="wp-block-columns alignwide superlite-stat-grid">
	<!-- wp:column {"className":"superlite-stat"} -->
	<div class="wp-block-column superlite-stat">
		<!-- wp:paragraph {"className":"superlite-stat__number"} -->
		<p class="superlite-stat__number"><?php esc_html_e('100%', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:paragraph {"className":"superlite-stat__label"} -->
		<p class="superlite-stat__label"><?php esc_html_e('Written Price Transparency', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column {"className":"superlite-stat"} -->
	<div class="wp-block-column superlite-stat">
		<!-- wp:paragraph {"className":"superlite-stat__number"} -->
		<p class="superlite-stat__number"><?php esc_html_e('24 hr', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:paragraph {"className":"superlite-stat__label"} -->
		<p class="superlite-stat__label"><?php esc_html_e('Quote Turnaround', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column {"className":"superlite-stat"} -->
	<div class="wp-block-column superlite-stat">
		<!-- wp:paragraph {"className":"superlite-stat__number"} -->
		<p class="superlite-stat__number"><?php esc_html_e('5-Star', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:paragraph {"className":"superlite-stat__label"} -->
		<p class="superlite-stat__label"><?php esc_html_e('Local Reputation', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->

<?php require get_template_directory() . '/patterns/cta-banner.php'; ?>
