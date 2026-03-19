<?php
get_header();
?>
<main class="div main-wrapper">
	<section section-dark-theme="" class="section section-cover" id="ies2q7q46_0">
		<div class="div page-cover_component flex-direction-vertical" id="i905smb5f_0">
			<div class="div padding-block-large" id="iiyh304i8_0">
				<h1 class="text heading-style-h1 text-color-black heading-style-h1--is-page-cover" id="ijmxwrbg4_0">Наши работы</h1>
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
								'label' => 'Наши работы',
							),
						),
					)
				);
				?>
			</div>
		</div>
	</section>

	<section class="section section-news background-light-grey" id="ithc4hsyk_0">
		<div class="div padding-global section-news_padding" id="i8g5iq5ti_0">
			<div class="div flex-direction-vertical section_title-gap" id="i0nrf9qpz_0">
				<div class="div flex-direction-horizontal content-tags" role="radiogroup" aria-label="Фильтр проектов">
					<?php foreach ( array( 'Все', 'Реконструкции', 'Конструкции' ) as $index => $tag ) : ?>
						<label class="content-tags__item border-radius">
							<input class="content-tags__input" type="radio" name="project-tag" <?php checked( 0, $index ); ?>>
							<span class="content-tags__button div flex-center-all border-radius">
								<span class="text-style-body content-tags__text"><?php echo esc_html( $tag ); ?></span>
							</span>
						</label>
					<?php endforeach; ?>
				</div>

				<div class="collection" id="ijktx60l9_0">
					<div role="list" class="collection__list grid-2 grid-gap grid-3--is-news-page">
						<?php if ( have_posts() ) : ?>
							<?php while ( have_posts() ) : ?>
								<?php the_post(); ?>
								<?php get_template_part( 'template-parts/cards/project-card', null, array_merge( lvl_neva_map_project_post_to_card( get_post() ), array( 'content_class' => 'project-case-card__content-list' ) ) ); ?>
							<?php endwhile; ?>
						<?php else : ?>
							<?php foreach ( lvl_neva_get_default_project_cards() as $item ) : ?>
								<?php get_template_part( 'template-parts/cards/project-card', null, array_merge( $item, array( 'content_class' => 'project-case-card__content-list' ) ) ); ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
					<?php the_posts_pagination(); ?>
				</div>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/sections/contact-form' ); ?>
</main>
<?php
get_footer();
