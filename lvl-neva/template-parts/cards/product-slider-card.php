<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$product = $args['product'] ?? null;

if ( ! $product instanceof WC_Product ) {
	return;
}

$product_id                     = $product->get_id();
$product_title                  = $product->get_name();
$product_permalink              = get_permalink( $product_id );
$product_description            = $product->get_short_description();
$product_description            = $product_description ? $product_description : get_the_excerpt( $product_id );
$product_description            = wp_trim_words( wp_strip_all_tags( $product_description ), 20, '...' );
$product_image_id               = $product->get_image_id();
$product_image_url              = $product_image_id ? wp_get_attachment_image_url( $product_image_id, 'large' ) : '';
$product_image_alt              = $product_image_id ? get_post_meta( $product_image_id, '_wp_attachment_image_alt', true ) : '';
$product_price_html             = $product->get_price_html();
$product_is_purchasable         = $product->is_purchasable() && $product->is_in_stock();
$variation_attribute_name       = '';
$variation_attribute_input_name = '';
$variation_attribute_key        = '';
$variation_attribute_label      = '';
$variation_options              = array();
$variation_map                  = array();
$selected_option                = '';
$selected_variation_id          = 0;

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

		$variation_attribute_key        = 0 === strpos( $variation_attribute_name, 'attribute_' ) ? substr( $variation_attribute_name, 10 ) : $variation_attribute_name;
		$variation_attribute_input_name = 'attribute_' . $variation_attribute_key;
		$variation_attribute_label      = wc_attribute_label( $variation_attribute_key );
		$default_option                 = $product->get_variation_default_attribute( $variation_attribute_key );

		foreach ( $product->get_available_variations() as $available_variation ) {
			$variation_option = $available_variation['attributes'][ $variation_attribute_input_name ] ?? '';

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
<div class="collection__item size-height-full size-height-auto-tablet swiper-slide" role="group">
	<div
		class="div equipments-card_component background-white border-radius size-height-full product-slider-card"
		data-product-slider-card=""
		<?php if ( ! empty( $variation_map ) ) : ?>
			data-variation-map="<?php echo esc_attr( wp_json_encode( $variation_map ) ); ?>"
		<?php endif; ?>
	>
		<form class="product-slider-card__form size-height-full" method="post">
			<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product_id ); ?>">
			<input type="hidden" name="quantity" value="1">

			<?php if ( ! empty( $variation_map ) && $variation_attribute_input_name ) : ?>
				<input type="hidden" name="product_id" value="<?php echo esc_attr( $product_id ); ?>">
				<input type="hidden" name="variation_id" value="<?php echo esc_attr( $selected_variation_id ); ?>">
				<input type="hidden" name="<?php echo esc_attr( $variation_attribute_input_name ); ?>" value="<?php echo esc_attr( $selected_option ); ?>" data-product-card-attribute-input>
			<?php endif; ?>

			<div class="div flex-direction-horizontal grid-4--is-equipment background-white size-height-full">
				<div class="div equipments-card_img-wrapper flex-center-all" style="position:absolute;height:100%;">
					<div class="image equipments-card_img size-width-auto size-height-full equipments-card_img--is-main">
						<?php if ( $product_image_url ) : ?>
							<img class="image__img" src="<?php echo esc_url( $product_image_url ); ?>" alt="<?php echo esc_attr( $product_image_alt ); ?>">
						<?php endif; ?>
					</div>
				</div>

				<div class="div padding-block-xlarge">
					<div class="div flex-direction-vertical size-height-full flex-justify-left">
						<h3 class="text heading-style-h3">
							<a href="<?php echo esc_url( $product_permalink ); ?>" style="color:inherit;text-decoration:none;" aria-label="<?php echo esc_attr( $product_title ); ?>">
								<span class="text-block-wrap-div"><?php echo esc_html( $product_title ); ?></span>
							</a>
						</h3>

						<div class="div equipments-card_spacer"></div>

						<div class="div flex-align-center flex-direction-horizontal link-iconic_gap">
							<div class="text text-style-body">
								<span class="text-block-wrap-div text-color-grey"><?php echo esc_html( $product_description ); ?></span>
							</div>
						</div>

						<div class="div equipments-card_spacer equipment_card_spacer__show-mobile"></div>

						<div class="div flex-direction-horizontal size-height-full flex-align-center">
							<div class="div show-on-desktop hide">
								<div class="div slider-buttons_component">
									<div class="div flex-direction-horizontal">
										<a class="link-block border-radius button-iconic_component text-color-brand background-light-grey" href="#">
											<div class="div flex-direction-horizontal flex-align-center flex-center">
												<div class="embed icon_component flex-center-all">
													<svg fill="none" viewBox="0 0 24 24" width="24" height="24">
														<path d="M12.0898 6.71289L7.72363 10.999H18.5V12.999H7.72363L12.0898 17.2852L10.6885 18.7129L5.5 13.6182V10.3799L10.6885 5.28516L12.0898 6.71289Z" fill="currentColor"></path>
													</svg>
												</div>
											</div>
										</a>

										<a class="link-block border-radius button-iconic_component text-color-brand background-light-grey" href="#">
											<div class="div flex-direction-horizontal flex-align-center flex-center">
												<div class="embed icon_component flex-center-all">
													<svg fill="none" viewBox="0 0 24 24" width="24" height="24">
														<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
													</svg>
												</div>
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>

						<div class="div equipments-card_spacer"></div>

						<div class="div flex-direction-vertical">
							<div class="text heading-style-h5 text-color-brand" data-product-card-price>
								<?php echo wp_kses_post( $product_price_html ); ?>
							</div>

							<?php if ( ! empty( $variation_options ) ) : ?>
								<div class="div equipments-card_spacer"></div>

								<div class="text text-style-body text-color-grey">
									<?php echo esc_html( $variation_attribute_label ? $variation_attribute_label : 'Доступно в размерах' ); ?>
								</div>

								<div class="div flex-direction-horizontal flex-wrap-gap">
									<?php foreach ( $variation_options as $variation_value => $variation_label ) : ?>
										<label class="size-filter">
											<input
												type="radio"
												name="product-slider-card-option-<?php echo esc_attr( $product_id ); ?>"
												value="<?php echo esc_attr( $variation_value ); ?>"
												<?php checked( $selected_option, $variation_value ); ?>
												data-product-card-option
											>
											<span class="size-badge text text-style-body"><?php echo esc_html( $variation_label ); ?></span>
										</label>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<div class="div equipments-card_spacer"></div>

							<button class="nav-btn text-style-body product-purchase__submit-slider" type="submit" data-product-card-submit data-product-main-submit <?php disabled( ! $product_is_purchasable ); ?>>
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
				</div>

			</div>
		</form>
	</div>
</div>
