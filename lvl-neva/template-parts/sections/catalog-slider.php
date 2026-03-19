<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args,
	array(
		'title' => 'Каталог',
		'count' => 3,
		'items' => array(),
	)
);

$items = ! empty( $args['items'] ) ? $args['items'] : lvl_neva_get_product_items( (int) $args['count'] );
?>
<section class="section section-full-screen section-equipments section--u-irwudmunb" id="irwudmunb_0">
	<div class="div padding-global size-height-auto-tablet section-equipments_padding section-full-screen" id="i1plcpzdj_0">
		<div class="div grid-4 grid-4--is-equipments-layout size-height-full size-height-auto-tablet" id="itwohodob_0">
			<h2 class="text heading-style-h4 text-color-grey text--u-ihdpdjstl"><?php echo esc_html( $args['title'] ); ?></h2>
			<div class="div section-equipments_slider-wrapper div--u-i08l6t9q5 size-height-full size-height-auto-tablet clip-content" id="i08l6t9q5_0">
				<div class="collection size-height-full swiper size-height-auto-tablet" equipments-slider="container">
					<div class="collection__list size-height-full size-height-auto-tablet swiper-wrapper section-equipments_cards-flex" role="list">
						<?php foreach ( $items as $item ) : ?>
							<div class="collection__item size-height-full size-height-auto-tablet swiper-slide" role="group">
								<?php get_template_part( 'template-parts/cards/product-card', null, array_merge( $item, array( 'variant' => 'slider' ) ) ); ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="div show-on-desktop layer-left z-index-top show-on-desktop--is-equipments-slider-buttons">
				<div class="div slider-buttons_component" id="iz6t651tk_0">
					<div class="div flex-direction-horizontal" id="idijeb8sy_0">
						<a class="link-block border-radius button-iconic_component text-color-brand background-white" equipments-slider="prev" href="#" role="button">
							<div class="div flex-center-all" style="padding:1rem;">
								<svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
									<path d="M12.0898 6.71289L7.72363 10.999H18.5V12.999H7.72363L12.0898 17.2852L10.6885 18.7129L5.5 13.6182V10.3799L10.6885 5.28516L12.0898 6.71289Z" fill="currentColor"></path>
								</svg>
							</div>
						</a>
						<a class="link-block border-radius button-iconic_component text-color-white background-brand" equipments-slider="next" href="#" role="button">
							<div class="div flex-center-all" style="padding:1rem;">
								<svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
									<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
								</svg>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
