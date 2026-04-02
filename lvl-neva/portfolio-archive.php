<?php
/**
 * Template Name: Архив наших работ
 */

get_header();
?>

<?php get_template_part( 'template-parts/sections/shared/page-title-section' ); ?>
<?php
get_template_part(
	'template-parts/sections/listing/content-tags-section',
	null,
	array(
		'post_type' => 'portfolio',
		'taxonomy'  => 'project-type',
	)
);
get_template_part(
	'template-parts/sections/listing/portfolio-list-section'
);
?>


<?php
get_footer();
