<?php
/**
 * Title: Key Statistics & Milestones
 * Slug: superlite/stats-bar
 * Categories: superlite-sections
 * Description: Four-column statistics row highlighting key numbers, years in business, and customer satisfaction.
 */
?>
<!-- wp:columns {"align":"wide","className":"superlite-stat-grid","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|md","left":"var:preset|spacing|md"}}}} -->
<div class="wp-block-columns alignwide superlite-stat-grid">
	<!-- wp:column {"className":"superlite-stat"} -->
	<div class="wp-block-column superlite-stat">
		<!-- wp:paragraph {"className":"superlite-stat__number"} -->
		<p class="superlite-stat__number"><?php esc_html_e('35+', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:paragraph {"className":"superlite-stat__label"} -->
		<p class="superlite-stat__label"><?php esc_html_e('Years in Business', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column {"className":"superlite-stat"} -->
	<div class="wp-block-column superlite-stat">
		<!-- wp:paragraph {"className":"superlite-stat__number"} -->
		<p class="superlite-stat__number"><?php esc_html_e('2,400+', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:paragraph {"className":"superlite-stat__label"} -->
		<p class="superlite-stat__label"><?php esc_html_e('Projects Completed', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column {"className":"superlite-stat"} -->
	<div class="wp-block-column superlite-stat">
		<!-- wp:paragraph {"className":"superlite-stat__number"} -->
		<p class="superlite-stat__number"><?php esc_html_e('99%', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:paragraph {"className":"superlite-stat__label"} -->
		<p class="superlite-stat__label"><?php esc_html_e('Client Satisfaction', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column {"className":"superlite-stat"} -->
	<div class="wp-block-column superlite-stat">
		<!-- wp:paragraph {"className":"superlite-stat__number"} -->
		<p class="superlite-stat__number"><?php esc_html_e('3rd Gen', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:paragraph {"className":"superlite-stat__label"} -->
		<p class="superlite-stat__label"><?php esc_html_e('Family Leadership', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->
