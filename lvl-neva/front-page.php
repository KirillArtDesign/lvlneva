<?php
/**
 * Template Name: Главная страница
 */

get_header();
?>

	<?php get_template_part( 'template-parts/sections/front-page/main-section-front' ); ?>
	<?php get_template_part( 'template-parts/sections/front-page/about-section-front' ); ?>
	<?php get_template_part( 'template-parts/sections/front-page/services-section-front' ); ?>
	<?php get_template_part( 'template-parts/sections/shop/product-slider-section' ); ?>
	<?php get_template_part( 'template-parts/sections/front-page/production-section-front' ); ?>
	<?php get_template_part( 'template-parts/sections/forms/contact-form2-section' ); ?>
	<?php get_template_part( 'template-parts/sections/blog/main-blog-section' ); ?>
	

<?php
get_footer();
?>
