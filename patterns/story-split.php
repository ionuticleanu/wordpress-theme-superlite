<?php
/**
 * Title: Story Split with Picture & Checklist
 * Slug: superlite/story-split
 * Categories: superlite-sections
 * Description: Two-column section pairing a large replaceable photo with story text and a checkmark list.
 */
$placeholder_wide = esc_url(get_template_directory_uri() . '/assets/images/placeholder-wide.svg');
?>
<!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|xl","left":"var:preset|spacing|xl"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center">
	<!-- wp:column {"verticalAlignment":"center","width":"48%"} -->
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:48%">
		<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
		<figure class="wp-block-image size-large"><img src="<?php echo $placeholder_wide; ?>" alt="<?php esc_attr_e('Our team at work', 'superlite'); ?>"/></figure>
		<!-- /wp:image -->
	</div>
	<!-- /wp:column -->

	<!-- wp:column {"verticalAlignment":"center","width":"52%"} -->
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:52%">
		<!-- wp:paragraph {"className":"superlite-eyebrow"} -->
		<p class="superlite-eyebrow"><?php esc_html_e('Why Choose Us', 'superlite'); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2} -->
		<h2 class="wp-block-heading"><?php esc_html_e('A Personal Commitment You Only Get From a Family Business', 'superlite'); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph -->
		<p><?php esc_html_e('When our family name is on the door, every detail matters. We treat every client like a lifelong neighbor—never cutting corners or rushing a job.', 'superlite'); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:list {"className":"superlite-checklist"} -->
		<ul class="wp-block-list superlite-checklist">
			<!-- wp:list-item -->
			<li><?php esc_html_e('Direct communication with the people actually doing the work', 'superlite'); ?></li>
			<!-- /wp:list-item -->
			<!-- wp:list-item -->
			<li><?php esc_html_e('Upfront written estimates with zero hidden fees or surprise charges', 'superlite'); ?></li>
			<!-- /wp:list-item -->
			<!-- wp:list-item -->
			<li><?php esc_html_e('Carefully vetted materials backed by our satisfaction guarantee', 'superlite'); ?></li>
			<!-- /wp:list-item -->
		</ul>
		<!-- /wp:list -->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->
