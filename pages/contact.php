<?php
/**
 * Title: Contact Us
 */
$placeholder_wide = esc_url(get_template_directory_uri() . '/assets/images/placeholder-wide.svg');
?>
<!-- wp:paragraph {"align":"wide","fontSize":"lg"} -->
<p class="alignwide has-lg-font-size"><?php esc_html_e('Have a question, need advice, or want to request an estimate? Reach out by phone, email, or visit us in person—we respond promptly to every inquiry.', 'superlite'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|lg","left":"var:preset|spacing|lg"}}}} -->
<div class="wp-block-columns alignwide">
	<!-- wp:column {"className":"superlite-card"} -->
	<div class="wp-block-column superlite-card">
		<!-- wp:paragraph {"className":"superlite-eyebrow"} -->
		<p class="superlite-eyebrow"><?php esc_html_e('Location', 'superlite'); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":3} -->
		<h3 class="wp-block-heading"><?php esc_html_e('Visit Our Office', 'superlite'); ?></h3>
		<!-- /wp:heading -->

		<!-- wp:paragraph -->
		<p>123 Main Street<br>Your City, ST 12345</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column {"className":"superlite-card"} -->
	<div class="wp-block-column superlite-card">
		<!-- wp:paragraph {"className":"superlite-eyebrow"} -->
		<p class="superlite-eyebrow"><?php esc_html_e('Hours', 'superlite'); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":3} -->
		<h3 class="wp-block-heading"><?php esc_html_e('Business Hours', 'superlite'); ?></h3>
		<!-- /wp:heading -->

		<!-- wp:paragraph -->
		<p><?php esc_html_e('Monday – Friday: 8:30 AM – 6:00 PM', 'superlite'); ?><br><?php esc_html_e('Saturday: 9:00 AM – 2:00 PM', 'superlite'); ?><br><?php esc_html_e('Sunday: Closed', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column {"className":"superlite-card"} -->
	<div class="wp-block-column superlite-card">
		<!-- wp:paragraph {"className":"superlite-eyebrow"} -->
		<p class="superlite-eyebrow"><?php esc_html_e('Direct Contact', 'superlite'); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":3} -->
		<h3 class="wp-block-heading"><?php esc_html_e('Phone & Email', 'superlite'); ?></h3>
		<!-- /wp:heading -->

		<!-- wp:paragraph -->
		<p><?php esc_html_e('Phone: (555) 019-2834', 'superlite'); ?><br><?php esc_html_e('Email: hello@example.com', 'superlite'); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->

<!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|xl","left":"var:preset|spacing|xl"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center">
	<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
		<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
		<figure class="wp-block-image size-large"><img src="<?php echo $placeholder_wide; ?>" alt="<?php esc_attr_e('Storefront or map photo', 'superlite'); ?>"/></figure>
		<!-- /wp:image -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
		<!-- wp:paragraph {"className":"superlite-eyebrow"} -->
		<p class="superlite-eyebrow"><?php esc_html_e('What to Expect', 'superlite'); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2} -->
		<h2 class="wp-block-heading"><?php esc_html_e('Simple, Stress-Free Consultations', 'superlite'); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:list {"className":"superlite-checklist"} -->
		<ul class="wp-block-list superlite-checklist">
			<!-- wp:list-item -->
			<li><?php esc_html_e('Quick response within one business day', 'superlite'); ?></li>
			<!-- /wp:list-item -->
			<!-- wp:list-item -->
			<li><?php esc_html_e('Clear project timeline and written estimate before work begins', 'superlite'); ?></li>
			<!-- /wp:list-item -->
			<!-- wp:list-item -->
			<li><?php esc_html_e('Friendly advice with zero high-pressure sales tactics', 'superlite'); ?></li>
			<!-- /wp:list-item -->
		</ul>
		<!-- /wp:list -->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->
