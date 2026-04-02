<?php
if ( is_singular( 'post' ) ) {
	get_template_part( 'blog-page' );
	return;
}

if ( is_singular( 'services' ) ) {
	get_template_part( 'service-page' );
	return;
}

if ( is_singular( 'portfolio' ) ) {
	get_template_part( 'portfolio-page' );
	return;
}

get_header();
?>
<main class="site-main">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php get_template_part( 'template-parts/sections/shared/page-title-section' ); ?>
			<article <?php post_class( 'content-card' ); ?>>
				<?php if ( 'post' === get_post_type() ) : ?>
					<p class="post-meta">
						<?php echo esc_html( get_the_date() ); ?>
					</p>
				<?php endif; ?>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>

			<?php the_post_navigation(); ?>
		<?php endwhile; ?>
	<?php endif; ?>
</main>
<?php
get_footer();
