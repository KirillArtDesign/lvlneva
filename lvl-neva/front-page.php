<?php
get_header();
?>
<main class="site-main">
	<section class="hero-block">
		<p class="post-meta"><?php esc_html_e( 'LVL Neva Theme', 'lvl-neva' ); ?></p>
		<h1><?php bloginfo( 'name' ); ?></h1>
		<p><?php bloginfo( 'description' ); ?></p>
	</section>

	<div class="content-grid" style="margin-top: 24px;">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<article <?php post_class( 'content-card' ); ?>>
					<?php the_content(); ?>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<section class="content-card">
				<p><?php esc_html_e( 'Create a page and assign it as the homepage to start building the site.', 'lvl-neva' ); ?></p>
			</section>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
