<?php
get_header();

$service_cards          = lvl_neva_get_service_items( array( 'count' => 6 ) );
$service_cards_fallback = array_merge( $service_cards, lvl_neva_get_default_service_cards() );
$primary_cards          = array_slice( $service_cards_fallback, 0, 3 );
$secondary_cards        = array_slice( $service_cards_fallback, 3, 3 );
?>
<main class="div main-wrapper">
	<section section-dark-theme="" class="section section-cover" id="ies2q7q46_0">
		<div class="div page-cover_component flex-direction-vertical" id="i905smb5f_0">
			<div class="div padding-block-large" id="iiyh304i8_0">
				<h1 class="text heading-style-h1 text-color-black heading-style-h1--is-page-cover" id="ijmxwrbg4_0">Услуги</h1>
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
								'label' => 'Услуги',
							),
						),
					)
				);
				?>
			</div>
		</div>
	</section>

	<section class="section section-full-screen section-services-page" id="services-primary">
		<div class="div padding-global size-height-auto-tablet size-height-full services-page_padding">
			<div class="div grid-4 services-card_component--height-full grid-4--is-services-layout" id="iuccyujov_0">
				<h2 class="text heading-style-h4 text-color-grey text--u-irj2o420v">Основные услуги</h2>
				<div class="collection collection--u-i2lj9rvhv size-height-full">
					<div role="list" class="collection__list grid-2 size-height-full grid-2--is-services-page">
						<?php foreach ( $primary_cards as $item ) : ?>
							<?php get_template_part( 'template-parts/cards/service-card', null, array_merge( $item, array( 'variant' => 'page' ) ) ); ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="section section-full-screen section-services-page background-light-grey" id="services-secondary">
		<div class="div padding-global size-height-auto-tablet size-height-full services-page_padding">
			<div class="div grid-4 services-card_component--height-full grid-4--is-services-layout" id="iuccyujov_1">
				<h2 class="text heading-style-h4 text-color-grey text--u-irj2o420v">Дополнительные услуги</h2>
				<div class="collection collection--u-i2lj9rvhv size-height-full">
					<div role="list" class="collection__list grid-2 size-height-full grid-2--is-services-page">
						<?php foreach ( $secondary_cards as $item ) : ?>
							<?php get_template_part( 'template-parts/cards/service-card', null, array_merge( $item, array( 'variant' => 'page' ) ) ); ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/sections/contact-form' ); ?>
</main>
<?php
get_footer();
