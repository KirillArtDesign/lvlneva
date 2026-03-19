<?php
get_header();
?>
<main class="site-main">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<article <?php post_class( 'content-card' ); ?>>
				<h1><?php the_title(); ?></h1>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>
	<?php endif; ?>
</main>
<?php
get_footer();
