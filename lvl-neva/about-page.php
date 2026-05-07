<?php
/**
 * Template Name: Страница о компании
 */

get_header();
?>

    <?php get_template_part( 'template-parts/sections/about/about-section' ); ?>
    <?php get_template_part( 'template-parts/sections/about/sertificate-slider-section' ); ?>
    <?php get_template_part( 'template-parts/sections/about/production-section' ); ?>
    <?php get_template_part( 'template-parts/sections/portfolio/portfolio-section' ); ?>
    <?php get_template_part( 'template-parts/sections/about/contact-form-section' ); ?>
    <?php get_template_part( 'template-parts/sections/about/review-section' ); ?>

<?php
get_footer();
