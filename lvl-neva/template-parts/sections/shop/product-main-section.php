<?php
defined( 'ABSPATH' ) || exit;

$product = wc_get_product( get_the_ID() );

if ( ! $product instanceof WC_Product ) {
	return;
}

$product_id                 = $product->get_id();
$product_title              = $product->get_name();
$product_permalink          = get_permalink( $product_id );
$product_price_html         = $product->get_price_html();
$product_is_purchasable     = $product->is_purchasable() && $product->is_in_stock();
$product_gallery_image_ids  = array();
$product_main_image_id      = (int) $product->get_image_id();
$product_gallery_image_ids  = array_merge( $product_gallery_image_ids, $product_main_image_id ? array( $product_main_image_id ) : array(), $product->get_gallery_image_ids() );
$product_gallery_image_ids  = array_values( array_unique( array_filter( array_map( 'intval', $product_gallery_image_ids ) ) ) );
$product_gallery_images     = array();
$product_characteristics    = function_exists( 'get_field' ) ? get_field( 'harakteristiki_tovara', $product_id ) : array();
$additional_services_raw    = function_exists( 'get_field' ) ? get_field( 'dopolnitelnye_uslugi_s_pokupkoj', $product_id ) : array();
$additional_services        = array();
$variation_attribute_name   = '';
$variation_attribute_input  = '';
$variation_attribute_key    = '';
$variation_options          = array();
$variation_map              = array();
$selected_option            = '';
$selected_variation_id      = 0;

if ( empty( $product_gallery_image_ids ) ) {
	$product_gallery_images[] = array(
		'full_url'  => wc_placeholder_img_src(),
		'thumb_url' => wc_placeholder_img_src( 'woocommerce_thumbnail' ),
		'alt'       => $product_title,
		'title'     => $product_title,
	);
} else {
	foreach ( $product_gallery_image_ids as $image_id ) {
		$full_url = wp_get_attachment_image_url( $image_id, 'large' );

		if ( ! $full_url ) {
			continue;
		}

		$thumb_url = wp_get_attachment_image_url( $image_id, 'thumbnail' );
		$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
		$image_alt = $image_alt ? $image_alt : $product_title;
		$image_obj = get_post( $image_id );

		$product_gallery_images[] = array(
			'full_url'  => $full_url,
			'thumb_url' => $thumb_url ? $thumb_url : $full_url,
			'alt'       => $image_alt,
			'title'     => $image_obj instanceof WP_Post ? $image_obj->post_title : $product_title,
		);
	}
}

if ( ! is_array( $product_characteristics ) ) {
	$product_characteristics = array();
}

if ( $additional_services_raw instanceof WP_Post ) {
	$additional_services_raw = array( $additional_services_raw );
} elseif ( ! is_array( $additional_services_raw ) ) {
	$additional_services_raw = array_filter( array( $additional_services_raw ) );
}

foreach ( $additional_services_raw as $service_item ) {
	$service_post = null;

	if ( $service_item instanceof WP_Post ) {
		$service_post = $service_item;
	} elseif ( is_numeric( $service_item ) ) {
		$service_post = get_post( (int) $service_item );
	}

	if (
		$service_post instanceof WP_Post
		&& 'services' === $service_post->post_type
		&& 'publish' === $service_post->post_status
	) {
		$additional_services[ $service_post->ID ] = $service_post;
	}
}

if ( $product->is_type( 'variable' ) ) {
	$variation_attributes = $product->get_variation_attributes();

	if ( ! empty( $variation_attributes ) ) {
		if ( isset( $variation_attributes['pa_dlinna'] ) ) {
			$variation_attribute_name = 'pa_dlinna';
		} elseif ( isset( $variation_attributes['attribute_pa_dlinna'] ) ) {
			$variation_attribute_name = 'attribute_pa_dlinna';
		} else {
			$variation_attribute_name = array_key_first( $variation_attributes );
		}

		$variation_attribute_key   = 0 === strpos( $variation_attribute_name, 'attribute_' ) ? substr( $variation_attribute_name, 10 ) : $variation_attribute_name;
		$variation_attribute_input = 'attribute_' . $variation_attribute_key;
		$default_option            = $product->get_variation_default_attribute( $variation_attribute_key );

		foreach ( $product->get_available_variations() as $available_variation ) {
			$variation_option = $available_variation['attributes'][ $variation_attribute_input ] ?? '';

			if ( '' === $variation_option ) {
				$variation_option = $available_variation['attributes'][ $variation_attribute_name ] ?? '';
			}

			if ( '' === $variation_option ) {
				continue;
			}

			$variation_object = wc_get_product( $available_variation['variation_id'] );

			if ( ! $variation_object instanceof WC_Product_Variation ) {
				continue;
			}

			$variation_map[ $variation_option ] = array(
				'variation_id'   => (int) $variation_object->get_id(),
				'price_html'     => $variation_object->get_price_html(),
				'is_purchasable' => $variation_object->is_purchasable() && $variation_object->is_in_stock(),
			);
		}

		foreach ( $variation_attributes[ $variation_attribute_name ] as $variation_option ) {
			if ( ! isset( $variation_map[ $variation_option ] ) ) {
				continue;
			}

			$variation_label = $variation_option;

			if ( taxonomy_exists( $variation_attribute_key ) ) {
				$variation_term = get_term_by( 'slug', $variation_option, $variation_attribute_key );

				if ( $variation_term instanceof WP_Term ) {
					$variation_label = $variation_term->name;
				}
			}

			$variation_options[ $variation_option ] = $variation_label;

			if (
				'' === $selected_option
				&& $default_option
				&& $default_option === $variation_option
				&& ! empty( $variation_map[ $variation_option ]['is_purchasable'] )
			) {
				$selected_option = $variation_option;
			}

			if ( '' === $selected_option && ! empty( $variation_map[ $variation_option ]['is_purchasable'] ) ) {
				$selected_option = $variation_option;
			}
		}

		if ( '' === $selected_option && ! empty( $variation_options ) ) {
			$selected_option = array_key_first( $variation_options );
		}

		if ( $selected_option && isset( $variation_map[ $selected_option ] ) ) {
			$product_price_html     = $variation_map[ $selected_option ]['price_html'];
			$product_is_purchasable = ! empty( $variation_map[ $selected_option ]['is_purchasable'] );
			$selected_variation_id  = (int) $variation_map[ $selected_option ]['variation_id'];
		} else {
			$product_is_purchasable = false;
		}
	}
}
?>
<section class="section section-cover">
	<div class="div page-cover_component page-cover--empty"></div>
</section>

<section class="section section-equipment padding-global" id="iwg68smvj_0" style="padding-bottom: 8rem;">
	<div class="div flex-direction-horizontal grid-gap flex-direction-horizontal--is-equipment-page equipment-page-layout-5-7" id="is19dw1j9_0">
		<div class="div equipment-page_slider_component" id="ioqrul9l1_0">
			<div class="div flex-direction-vertical equipment-page_slider_gap sticky sticky-padding" id="iqubkmwvf_0">
				<div class="div equipment-page_slider_preview background-white border-radius" id="ifb6j466j_0">
					<div equipment-slider="preview" class="div swiper" id="i06j0v493_0">
						<div class="div swiper-wrapper flex-direction-horizontal" id="izf9dxyzp_0" aria-live="polite">
							<?php foreach ( $product_gallery_images as $image_index => $product_gallery_image ) : ?>
								<div class="div swiper-slide<?php echo 0 === $image_index ? ' swiper-slide-active' : ''; ?>">
									<div class="div equipment-page_slider_img-wrapper">
										<div class="image size-full-percentage">
											<img
												src="<?php echo esc_url( $product_gallery_image['full_url'] ); ?>"
												alt="<?php echo esc_attr( $product_gallery_image['alt'] ); ?>"
												title="<?php echo esc_attr( $product_gallery_image['title'] ); ?>"
												class="image__img"
											>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="div flex-align-bottom flex-direction-horizontal layer-bottom z-index-top" id="ip0ooszxf_0">
						<div class="div padding-block-medium" id="i4p0t9k7d_0">
							<div class="div flex-direction-vertical" id="irf71f5m8_0">
								<div class="div slider-buttons_component" id="i0mmu9zpp_0">
									<div class="div space-between flex-direction-horizontal" id="iwqjyst4i_0">
										<a
											href=""
											data-action-element=""
											button-iconic-hover-animation=""
											equipment-slider="prev"
											class="link-block link-block--u-irkzwq2oj border-radius button-iconic_component text-color-brand background-light-grey swiper-button-disabled"
											id="irkzwq2oj_0"
											tabindex="-1"
											role="button"
											aria-label="Previous slide"
											aria-controls="izf9dxyzp_0"
											aria-disabled="true"
										>
											<div class="div flex-direction-vertical" id="iyedi1vaq_0">
												<div class="div div--u-iptql8tbi clip-content border-radius button-iconic__top background-brand text-color-white" id="iptql8tbi_0">
													<div class="div size-full-percentage flex-center-all" id="iss28kos8_0">
														<div class="embed icon_component embed--u-ipi1n9jo5 flex-center-all opacity" id="ipi1n9jo5_0">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M12.0898 6.71289L7.72363 10.999H18.5V12.999H7.72363L12.0898 17.2852L10.6885 18.7129L5.5 13.6182V10.3799L10.6885 5.28516L12.0898 6.71289Z" fill="currentColor"></path>
															</svg>
														</div>
													</div>
												</div>
												<div class="div div--u-itgfue11b button-iconic__bottom" id="itgfue11b_0">
													<div class="div size-full-percentage flex-center-all" id="i8a6jrkdf_0">
														<div class="embed icon_component embed--u-iaephav1f flex-center-all" id="iaephav1f_0">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M12.0898 6.71289L7.72363 10.999H18.5V12.999H7.72363L12.0898 17.2852L10.6885 18.7129L5.5 13.6182V10.3799L10.6885 5.28516L12.0898 6.71289Z" fill="currentColor"></path>
															</svg>
														</div>
													</div>
												</div>
											</div>
										</a>
										<a
											href=""
											data-action-element=""
											button-iconic-hover-animation=""
											equipment-slider="next"
											class="link-block link-block--u-icwi5o7ce border-radius button-iconic_component text-color-brand background-light-grey"
											id="icwi5o7ce_0"
											tabindex="0"
											role="button"
											aria-label="Next slide"
											aria-controls="izf9dxyzp_0"
											aria-disabled="false"
										>
											<div class="div flex-direction-vertical" id="ic6wg18ks_0">
												<div class="div div--u-iv9l4zuv3 clip-content border-radius button-iconic__top background-brand text-color-white" id="iv9l4zuv3_0">
													<div class="div size-full-percentage flex-center-all" id="is4qdp0s4_0">
														<div class="embed icon_component embed--u-iyahqvl6w flex-center-all opacity" id="iyahqvl6w_0">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
															</svg>
														</div>
													</div>
												</div>
												<div class="div div--u-itae9id5i button-iconic__bottom" id="itae9id5i_0">
													<div class="div size-full-percentage flex-center-all" id="ie4yj27ek_0">
														<div class="embed icon_component embed--u-iwfan7i4e flex-center-all" id="iwfan7i4e_0">
															<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
					</div>
				</div>
				<div class="div equipment-page_thumbs" id="i36ut8pcx_0">
					<div class="div flex-direction-horizontal flex-center size-width-auto equipment-page_thumbs-gap" id="i1aoxzzxh_0">
						<?php foreach ( $product_gallery_images as $image_index => $product_gallery_image ) : ?>
							<div
								role="button"
								class="link-block equipment-page_slider_thumb<?php echo 0 === $image_index ? ' active' : ''; ?>"
								data-index="<?php echo esc_attr( $image_index ); ?>"
							>
								<div class="image size-full-percentage">
									<img
										src="<?php echo esc_url( $product_gallery_image['thumb_url'] ); ?>"
										alt="<?php echo esc_attr( $product_gallery_image['alt'] ); ?>"
										title="<?php echo esc_attr( $product_gallery_image['title'] ); ?>"
										class="image__img"
									>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="div flex-direction-vertical grid-gap div--u-iy6idvb8v" id="iy6idvb8v_0">
			<div class="div background-white border-radius equipment-page_title_component" id="ibea6xlo1_0">
				<div class="div size-width-auto padding-block-large padding-block-large--is-equipment-title" id="iymzrx04j_0">
					<div class="div flex-direction-vertical equipment-page_title_gap" id="izq8h9fkr_0">
						<div class="div">
							<h2 page-title="" class="text heading-style-product">
								<?php echo esc_html( $product_title ); ?>
							</h2>
							<?php lvl_neva_render_breadcrumbs(); ?>
						</div>

						<div class="div flex-direction-vertical size-width-full tech-specs">
							<?php foreach ( $product_characteristics as $product_characteristic ) : ?>
								<?php
								$spec_label = isset( $product_characteristic['nazvanie_harakteristiki'] ) ? trim( (string) $product_characteristic['nazvanie_harakteristiki'] ) : '';
								$spec_value = isset( $product_characteristic['znachenie_harakteristiki'] ) ? trim( (string) $product_characteristic['znachenie_harakteristiki'] ) : '';

								if ( '' === $spec_label || '' === $spec_value ) {
									continue;
								}
								?>
								<div class="div flex-direction-horizontal size-width-full tech-specs__row">
									<div class="text-style-body tech-specs__label"><?php echo esc_html( $spec_label ); ?></div>
									<div class="equipment-page_tech-line-wrapper tech-specs__line">
										<div class="line_horizontal size-width-full"></div>
									</div>
									<div class="text-style-body tech-specs__value"><?php echo esc_html( $spec_value ); ?></div>
								</div>
							<?php endforeach; ?>
						</div>

						<form
							class="div flex-direction-vertical size-width-full product-purchase"
							method="post"
							action="<?php echo esc_url( $product_permalink ); ?>"
							data-product-main-purchase
							<?php if ( ! empty( $variation_map ) ) : ?>
								data-variation-map="<?php echo esc_attr( wp_json_encode( $variation_map ) ); ?>"
							<?php endif; ?>
						>
							<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product_id ); ?>">

							<?php if ( ! empty( $variation_map ) && $variation_attribute_input ) : ?>
								<input type="hidden" name="product_id" value="<?php echo esc_attr( $product_id ); ?>">
								<input type="hidden" name="variation_id" value="<?php echo esc_attr( $selected_variation_id ); ?>" data-product-main-variation-id>
								<input type="hidden" name="<?php echo esc_attr( $variation_attribute_input ); ?>" value="<?php echo esc_attr( $selected_option ); ?>" data-product-main-attribute-input>
							<?php endif; ?>

							<div class="product-purchase__price" data-product-main-price><?php echo wp_kses_post( $product_price_html ); ?></div>

							<div class="div flex-direction-vertical size-width-full product-purchase__controls">
								<?php if ( ! empty( $variation_options ) ) : ?>
									<div class="div flex-direction-horizontal size-width-full product-purchase__lengths" role="radiogroup" aria-label="Выбор длины">
										<?php foreach ( $variation_options as $variation_value => $variation_label ) : ?>
											<label class="product-purchase__length-option">
												<input
													class="product-purchase__length-input"
													type="radio"
													name="product-main-option-<?php echo esc_attr( $product_id ); ?>"
													value="<?php echo esc_attr( $variation_value ); ?>"
													<?php checked( $selected_option, $variation_value ); ?>
													data-product-main-option
												>
												<span class="product-purchase__length-btn"><?php echo esc_html( $variation_label ); ?></span>
											</label>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>

								<div class="div flex-direction-horizontal size-width-full product-purchase__actions">
									<div class="product-purchase__field product-purchase__field--qty" data-qty-control>
										<button class="product-purchase__icon-btn" type="button" aria-label="Уменьшить количество" data-qty-decrease>
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M7 12H11H12H13H17" stroke="currentColor" stroke-width="2" />
											</svg>
										</button>
										<input
											class="product-purchase__qty-input"
											type="number"
											name="quantity"
											min="1"
											step="1"
											value="1"
											inputmode="numeric"
											aria-label="Количество"
											data-qty-input
										>
										<button class="product-purchase__icon-btn" type="button" aria-label="Увеличить количество" data-qty-increase>
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M7 12H11M12 12H11M12 12V11M12 12H13M12 12V13M17 12H13M12 7V11M12 17V13M11 12L12 11M11 12L12 13M12 11L13 12M13 12L12 13" stroke="currentColor" stroke-width="2" />
											</svg>
										</button>
									</div>

									<?php if ( ! empty( $additional_services ) ) : ?>
										<div class="product-purchase__select-wrap">
											<select
												class="product-purchase__field product-purchase__field--service product-purchase__select"
												name="lvl_neva_additional_service"
												aria-label="Дополнительная услуга"
											>
												<option value="">Добавить услугу</option>
												<?php foreach ( $additional_services as $service_post ) : ?>
													<option value="<?php echo esc_attr( $service_post->ID ); ?>">
														<?php echo esc_html( get_the_title( $service_post ) ); ?>
													</option>
												<?php endforeach; ?>
											</select>
											<span class="product-purchase__field-icon" aria-hidden="true">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M7.61245 7.48999L11.1225 11H12H12.8775L16.3875 7.48999" stroke="currentColor" stroke-width="2" />
													<path d="M7.61245 13L11.1225 16.51H12H12.8775L16.3875 13" stroke="currentColor" stroke-width="2" />
												</svg>
											</span>
										</div>
									<?php endif; ?>

									<button class="nav-btn text-style-body product-purchase__submit" type="submit" data-product-main-submit <?php disabled( ! $product_is_purchasable ); ?>>
										<span class="nav-btn__label" data-label="Заказать">
											<span class="nav-btn__label-text">Заказать</span>
										</span>
										<span class="nav-btn__icon" aria-hidden="true">
											<svg class="nav-btn__icon-svg nav-btn__icon-svg--default" fill="none" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
												<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
											</svg>
											<svg class="nav-btn__icon-svg nav-btn__icon-svg--hover" fill="none" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
												<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
											</svg>
										</span>
									</button>
								</div>
							</div>
						</form>

					</div>
				</div>
			</div>
