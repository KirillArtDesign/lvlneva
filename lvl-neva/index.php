<?php
get_header();
?>
<main class="site-main">
	<?php get_template_part( 'template-parts/sections/shared/page-title-section' ); ?>
	<?php
	get_template_part(
		'template-parts/sections/listing/content-tags-section',
		null,
		array(
			'post_type' => 'post',
			'taxonomy'  => 'category',
		)
	);
	get_template_part(
		'template-parts/sections/content-results-section',
		null,
		array(
			'post_type' => 'post',
			'taxonomy'  => 'category',
		)
	);
	?>
</main>
<?php
get_footer();
