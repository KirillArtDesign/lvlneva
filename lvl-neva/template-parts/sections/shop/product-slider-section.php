<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wc_get_product' ) ) {
	return;
}

$product_slider_context_id       = get_queried_object_id();
$product_slider_selected_raw     = array();
$product_slider_selected_ids     = array();
$product_slider_query            = null;
$product_slider_shop_archive_url = function_exists( 'lvl_neva_get_shop_archive_url' ) ? lvl_neva_get_shop_archive_url() : home_url( '/' );
$product_slider_title            = is_singular( 'services' ) ? 'С услугой приобретают' : 'Каталог';

if ( function_exists( 'get_field' ) && $product_slider_context_id ) {
	$product_slider_selected_raw = get_field( 'catalog_tovary_v_bloke', $product_slider_context_id );
}

if ( $product_slider_selected_raw instanceof WP_Post || $product_slider_selected_raw instanceof WC_Product ) {
	$product_slider_selected_raw = array( $product_slider_selected_raw );
} elseif ( ! is_array( $product_slider_selected_raw ) ) {
	$product_slider_selected_raw = array_filter( array( $product_slider_selected_raw ) );
}

foreach ( $product_slider_selected_raw as $product_slider_item ) {
	$product_slider_post_id = 0;

	if ( $product_slider_item instanceof WC_Product ) {
		$product_slider_post_id = $product_slider_item->get_id();
	} elseif ( $product_slider_item instanceof WP_Post ) {
		$product_slider_post_id = (int) $product_slider_item->ID;
	} elseif ( is_numeric( $product_slider_item ) ) {
		$product_slider_post_id = (int) $product_slider_item;
	}

	if ( ! $product_slider_post_id ) {
		continue;
	}

	$product_slider_post = get_post( $product_slider_post_id );

	if (
		! $product_slider_post instanceof WP_Post
		|| 'product' !== $product_slider_post->post_type
		|| 'publish' !== $product_slider_post->post_status
	) {
		continue;
	}

	$product_slider_selected_ids[] = $product_slider_post_id;
}

$product_slider_selected_ids = array_values( array_unique( $product_slider_selected_ids ) );

if ( ! empty( $product_slider_selected_ids ) ) {
	$product_slider_query = new WP_Query(
		array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'post__in'       => $product_slider_selected_ids,
			'orderby'        => 'post__in',
			'posts_per_page' => count( $product_slider_selected_ids ),
		)
	);
}

if ( ! $product_slider_query instanceof WP_Query || ! $product_slider_query->have_posts() ) {
	$product_slider_query = new WP_Query(
		array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => 5,
			'orderby'        => 'rand',
		)
	);
}

if ( ! $product_slider_query->have_posts() ) {
	return;
}
?>
<section class="section section-full-screen section-equipments section--u-irwudmunb" id="irwudmunb_0">
	<div class="div padding-global size-height-auto-tablet section-equipments_padding section-full-screen" id="i1plcpzdj_0">
		<div class="div grid-4 grid-4--is-equipments-layout size-height-full size-height-auto-tablet" id="itwohodob_0">
			<h2 class="text heading-style-h4 text-color-grey text--u-ihdpdjstl">
				<?php echo esc_html( $product_slider_title ); ?>
			</h2>

			<div class="div section-equipments_slider-wrapper div--u-i08l6t9q5 size-height-full size-height-auto-tablet clip-content" id="i08l6t9q5_0">
				<div class="collection size-height-full swiper size-height-auto-tablet" data-tt-widget-version="1" equipments-slider="container" id="iqtnpqe5r_0">
					<div aria-live="polite" class="collection__list size-height-full size-height-auto-tablet swiper-wrapper section-equipments_cards-flex" id="it4tph928_0" role="list" style="cursor: grab">
						<?php while ( $product_slider_query->have_posts() ) : ?>
							<?php
							$product_slider_query->the_post();
							$product_slider_product = wc_get_product( get_the_ID() );

							if ( ! $product_slider_product instanceof WC_Product ) {
								continue;
							}

							get_template_part(
								'template-parts/cards/product-slider-card',
								null,
								array(
									'product' => $product_slider_product,
								)
							);
							?>
						<?php endwhile; ?>
					</div>
				</div>
			</div>

			<div class="div show-on-desktop layer-left z-index-top show-on-desktop--is-equipments-slider-buttons">
				<div class="div">
					<div class="div slider-buttons_component" id="iz6t651tk_0">
						<div class="div flex-direction-horizontal" id="idijeb8sy_0">
							<a aria-controls="it4tph928_0" aria-disabled="false" aria-label="Previous slide" button-iconic-hover-animation="" class="link-block link-block--u-iigo3gnpy border-radius button-iconic_component text-color-brand background-white" data-action-element="" equipments-slider="prev" href="#" id="iigo3gnpy_0" role="button" tabindex="0">
								<div class="div flex-direction-vertical" id="ic6arp6e1_0">
									<div class="div div--u-i9ekafbym clip-content border-radius button-iconic__top background-brand text-color-white" id="i9ekafbym_0">
										<div class="div size-full-percentage flex-center-all" id="i09cjmyfj_0">
											<div class="embed icon_component embed--u-i0ydq3xjl flex-center-all opacity" id="i0ydq3xjl_0">
												<svg fill="none" height="24" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
													<path d="M12.0898 6.71289L7.72363 10.999H18.5V12.999H7.72363L12.0898 17.2852L10.6885 18.7129L5.5 13.6182V10.3799L10.6885 5.28516L12.0898 6.71289Z" fill="currentColor"></path>
												</svg>
											</div>
										</div>
									</div>
									<div class="div div--u-i9ipmrni7 button-iconic__bottom" id="i9ipmrni7_0">
										<div class="div size-full-percentage flex-center-all" id="i5peipexg_0">
											<div class="embed icon_component embed--u-i600v39mo flex-center-all" id="i600v39mo_0">
												<svg fill="none" height="24" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
													<path d="M12.0898 6.71289L7.72363 10.999H18.5V12.999H7.72363L12.0898 17.2852L10.6885 18.7129L5.5 13.6182V10.3799L10.6885 5.28516L12.0898 6.71289Z" fill="currentColor"></path>
												</svg>
											</div>
										</div>
									</div>
								</div>
							</a>

							<a aria-controls="it4tph928_0" aria-disabled="false" aria-label="Next slide" button-iconic-hover-animation="" class="link-block link-block--u-iwsuicknx border-radius button-iconic_component text-color-white background-brand" data-action-element="" equipments-slider="next" href="#" id="iwsuicknx_0" role="button" tabindex="0">
								<div class="div flex-direction-vertical" id="it0wslrqr_0">
									<div class="div div--u-i42430wfu clip-content border-radius button-iconic__top background-brand text-color-white" id="i42430wfu_0">
										<div class="div size-full-percentage flex-center-all" id="i9pf9e9ee_0">
											<div class="embed icon_component embed--u-i2z2160jq flex-center-all opacity" id="i2z2160jq_0">
												<svg fill="none" height="24" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
													<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
												</svg>
											</div>
										</div>
									</div>
									<div class="div div--u-idhlvqjcz button-iconic__bottom" id="idhlvqjcz_0">
										<div class="div size-full-percentage flex-center-all" id="ikdbz5xdw_0">
											<div class="embed icon_component embed--u-igww5j4kx flex-center-all" id="igww5j4kx_0">
												<svg fill="none" height="24" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
													<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
												</svg>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="div flex-direction-horizontal flex-align-bottom div--u-iltmzvhq2 flex-align-bottom--is-equipment-button grid-2-tablet" id="iltmzvhq2_0">
				<div class="div div--u-iw325u2iw tablet-col-right" id="iw325u2iw_0">
					<div class="card-wrapper border-radius" data-original-height="126.65625">
						<a class="button-large_component hero-corner-roll-btn hero-corner-roll-btn--brand hero-corner-roll-btn--h100" data-action-element="" gsap-elements-scroll-animation="" id="i8o80ox3i_0" href="<?php echo esc_url( $product_slider_shop_archive_url ); ?>">
							<span class="hero-corner-roll-btn__label" data-label="Смотреть весь каталог">
								<span class="hero-corner-roll-btn__label-text">Смотреть весь каталог</span>
							</span>
							<span class="hero-corner-roll-btn__icon-slot" aria-hidden="true">
								<span class="hero-corner-roll-btn__icon-roll">
									<svg class="hero-corner-roll-btn__icon hero-corner-roll-btn__icon--default" fill="none" height="24" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
										<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
									</svg>
									<svg class="hero-corner-roll-btn__icon hero-corner-roll-btn__icon--hover" fill="none" height="24" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
										<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
									</svg>
								</span>
							</span>
						</a>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>
<?php wp_reset_postdata(); ?>
