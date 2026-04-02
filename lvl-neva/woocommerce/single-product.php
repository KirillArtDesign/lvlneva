<?php
defined( 'ABSPATH' ) || exit;

get_header();
?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>


		
		<?php get_template_part( 'template-parts/sections/shop/product-main-section' ); ?>


		
		<?php get_template_part( 'template-parts/sections/shop/product-content-section' ); ?>
		<?php get_template_part( 'template-parts/sections/forms/contact-form3-section' ); ?>
		<?php get_template_part( 'template-parts/sections/shared/faq-section' ); ?>
		<?php get_template_part( 'template-parts/sections/portfolio/portfolio-section' ); ?>
		<?php get_template_part( 'template-parts/sections/blog/main-blog-section' ); ?>

	<?php endwhile; ?>
<?php endif; ?>

<?php
get_footer();
?>
