<?php
get_header();
?>

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php get_template_part( 'template-parts/sections/shared/page-title-section' ); ?>
			<section class="section section-services-page background-light-grey">
				<div class="div padding-global size-height-auto-tablet services-page_padding">
					<div class="div flex-direction-horizontal size-width-full equipment-article">
						<article <?php post_class( 'div flex-direction-vertical size-width-full page-default__card' ); ?>>
							<div class="div flex-direction-horizontal size-width-full equipment-article__top">
								<div class="div flex-direction-vertical size-width-full equipment-article__content">
									<div class="div flex-direction-vertical size-width-full equipment-article__section">
										<div class="equipment-article__text page-default__content">
											<?php the_content(); ?>
										</div>
									</div>
								</div>
							</div>
						</article>
					</div>
				</div>
			</section>
		<?php endwhile; ?>
	<?php endif; ?>

<?php
get_footer();
