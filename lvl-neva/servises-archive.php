<?php
/**
 * Template Name: Архив услуг
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<?php get_template_part( 'template-parts/sections/shared/page-title-section' ); ?>
<?php get_template_part( 'template-parts/sections/servises/servises-list-section' ); ?>

<?php
get_footer();
