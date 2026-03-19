<?php
get_header();
?>
<main class="site-main">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<article <?php post_class( 'content-card' ); ?>>
				<p class="post-meta">
					<?php echo esc_html( get_the_date() ); ?>
				</p>
				<h1><?php the_title(); ?></h1>
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
