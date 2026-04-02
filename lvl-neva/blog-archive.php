<?php
/**
 * Template Name: Архив блога
 */

get_header();
?>

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
	'template-parts/sections/listing/blog-list-section'
);
?>


<?php
get_footer();
?>
