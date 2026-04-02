<?php
get_header();
?>
<main class="site-main">
	<?php get_template_part( 'template-parts/sections/shared/page-title-section' ); ?>

	<?php if ( get_the_archive_description() ) : ?>
		<div class="archive-header" style="margin-bottom: 24px;">
			<?php the_archive_description( '<div class="post-meta">', '</div>' ); ?>
		</div>
	<?php endif; ?>

	<div class="content-grid">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<article <?php post_class( 'content-card' ); ?>>
					<p class="post-meta"><?php echo esc_html( get_the_date() ); ?></p>
					<h2>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>
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
