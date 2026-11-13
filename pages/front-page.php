<?php
/**
 * Title: Fresh, Family-Grown Flowers
 */
?>
<!-- wp:paragraph {"fontSize":"lg"} -->
<p class="has-lg-font-size"><?php echo esc_html__('Hand-picked seasonal stems, arranged daily by our family and delivered fresh across town.', 'superlite'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons">
	<!-- wp:button -->
	<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url(home_url('/bouquets/')); ?>"><?php echo esc_html__('Browse Bouquets', 'superlite'); ?></a></div>
	<!-- /wp:button -->

	<!-- wp:button {"className":"is-style-outline"} -->
	<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php echo esc_html__('Order Custom Arrangement', 'superlite'); ?></a></div>
	<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

<!-- wp:separator {"backgroundColor":"border"} -->
<hr class="wp-block-separator has-text-color has-border-color has-alpha-channel-opacity has-border-background-color has-background"/>
<!-- /wp:separator -->

<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__('This Week in Bloom', 'superlite'); ?></h2>
<!-- /wp:heading -->

<!-- wp:columns -->
<div class="wp-block-columns">
	<!-- wp:column {"backgroundColor":"muted","style":{"spacing":{"padding":{"top":"var:preset|spacing|sm","right":"var:preset|spacing|sm","bottom":"var:preset|spacing|sm","left":"var:preset|spacing|sm"}}}} -->
	<div class="wp-block-column has-muted-background-color has-background" style="padding-top:var(--wp--preset--spacing--sm);padding-right:var(--wp--preset--spacing--sm);padding-bottom:var(--wp--preset--spacing--sm);padding-left:var(--wp--preset--spacing--sm)">
		<!-- wp:heading {"level":3} -->
		<h3 class="wp-block-heading"><?php echo esc_html__('Morning Meadow', 'superlite'); ?></h3>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"fontSize":"sm"} -->
		<p class="has-sm-font-size"><?php echo esc_html__('Sunflowers, chamomile, and eucalyptus tied in natural kraft paper.', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column {"backgroundColor":"muted","style":{"spacing":{"padding":{"top":"var:preset|spacing|sm","right":"var:preset|spacing|sm","bottom":"var:preset|spacing|sm","left":"var:preset|spacing|sm"}}}} -->
	<div class="wp-block-column has-muted-background-color has-background" style="padding-top:var(--wp--preset--spacing--sm);padding-right:var(--wp--preset--spacing--sm);padding-bottom:var(--wp--preset--spacing--sm);padding-left:var(--wp--preset--spacing--sm)">
		<!-- wp:heading {"level":3} -->
		<h3 class="wp-block-heading"><?php echo esc_html__('Garden Rose Bundle', 'superlite'); ?></h3>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"fontSize":"sm"} -->
		<p class="has-sm-font-size"><?php echo esc_html__('Fragrant heirloom roses paired with seasonal greenery and ruscus.', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column {"backgroundColor":"muted","style":{"spacing":{"padding":{"top":"var:preset|spacing|sm","right":"var:preset|spacing|sm","bottom":"var:preset|spacing|sm","left":"var:preset|spacing|sm"}}}} -->
	<div class="wp-block-column has-muted-background-color has-background" style="padding-top:var(--wp--preset--spacing--sm);padding-right:var(--wp--preset--spacing--sm);padding-bottom:var(--wp--preset--spacing--sm);padding-left:var(--wp--preset--spacing--sm)">
		<!-- wp:heading {"level":3} -->
		<h3 class="wp-block-heading"><?php echo esc_html__('Table Centerpiece', 'superlite'); ?></h3>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"fontSize":"sm"} -->
		<p class="has-sm-font-size"><?php echo esc_html__('Low ceramic vase arrangement ready for family dinners and celebrations.', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->

<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__('Three Generations of Growing', 'superlite'); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo esc_html__('Every stem we wrap is cut fresh in the morning and conditioned without harsh dyes. Stop by our shop or ask us for same-day local delivery.', 'superlite'); ?></p>
<!-- /wp:paragraph -->
