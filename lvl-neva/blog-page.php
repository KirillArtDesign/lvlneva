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
		<?php get_template_part( 'template-parts/sections/blog/blog-cover' ); ?>
        
		<?php get_template_part( 'template-parts/sections/blog/blog-content' ); ?>
		<?php get_template_part( 'template-parts/sections/blog/blog-servises' ); ?>

		<?php get_template_part( 'template-parts/sections/blog/main-blog-section' ); ?>

	<?php endwhile; ?>
<?php endif; ?>

<?php
get_footer();
