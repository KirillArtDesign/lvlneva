<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>

		<?php get_template_part( 'template-parts/sections/shared/page-title-section' ); ?>
		<?php get_template_part( 'template-parts/sections/portfolio/portfolio-main-section' ); ?>
		<?php get_template_part( 'template-parts/sections/portfolio/portfolio-content-section' ); ?>
        <?php get_template_part( 'template-parts/sections/portfolio/portfolio-servises-section' ); ?>

        
		<?php get_template_part( 'template-parts/sections/portfolio/portfolio-section' ); ?>
		<?php get_template_part( 'template-parts/sections/blog/main-blog-section' ); ?>

	<?php endwhile; ?>
<?php endif; ?>

<?php
get_footer();
