<?php
get_header();
?>
<main class="div main-wrapper">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<section section-dark-theme="" class="section section-cover" id="ies2q7q46_0">
				<div class="div page-cover_component flex-direction-vertical" id="i905smb5f_0">
					<div class="div padding-block-large" id="iiyh304i8_0">
						<h1 class="text heading-style-h1 text-color-black heading-style-h1--is-page-cover" id="ijmxwrbg4_0"><?php the_title(); ?></h1>
						<?php
						get_template_part(
							'template-parts/components/breadcrumbs',
							null,
							array(
								'items' => array(
									array(
										'label' => 'Главная',
										'url'   => home_url( '/' ),
									),
									array(
										'label' => get_the_title(),
									),
								),
							)
						);
						?>
					</div>
				</div>
			</section>

			<section class="section">
				<div class="div flex-direction-vertical grid-gap size-width-full art-conteiner">
					<div class="div flex-direction-horizontal size-width-full equipment-article">
						<div class="div flex-direction-vertical size-width-full border-radius equipment-article__card">
							<div class="div flex-direction-horizontal size-width-full equipment-article__top">
								<div class="div flex-direction-vertical size-width-full equipment-article__content">
									<div class="div flex-direction-vertical size-width-full equipment-article__section">
										<?php the_content(); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php endwhile; ?>
	<?php endif; ?>
</main>
<?php
get_footer();
