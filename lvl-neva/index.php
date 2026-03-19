<?php
get_header();
?>
<main class="site-main">
	<div class="content-grid">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<article <?php post_class( 'content-card' ); ?>>
					<h2>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>
					<div class="post-meta">
						<?php echo esc_html( get_the_date() ); ?>
					</div>
					<div class="entry-content">
						<?php the_excerpt(); ?>
					</div>
				</article>
			<?php endwhile; ?>

			<?php the_posts_navigation(); ?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
