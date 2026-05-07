<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$product = $args['product'] ?? null;

if ( ! $product instanceof WC_Product ) {
	return;
}

$product_id                = $product->get_id();
$product_title             = $product->get_name();
$product_permalink         = get_permalink( $product_id );
$product_description       = $product->get_short_description();
$product_description       = $product_description ? $product_description : get_the_excerpt( $product_id );
$product_description       = wp_trim_words( wp_strip_all_tags( $product_description ), 20, '...' );
$product_image_id          = $product->get_image_id();
$product_image_url         = $product_image_id ? wp_get_attachment_image_url( $product_image_id, 'large' ) : '';
$product_image_alt         = $product_image_id ? get_post_meta( $product_image_id, '_wp_attachment_image_alt', true ) : '';
$product_image_html        = $product_image_id
	? wp_get_attachment_image(
		$product_image_id,
		'large',
		false,
		array(
			'class'    => 'image__img equipments-card-adaptive__image',
			'alt'      => $product_image_alt,
			'loading'  => 'lazy',
			'decoding' => 'async',
			'sizes'    => '(max-width: 767px) 100vw, (max-width: 991px) 44vw, 32vw',
		)
	)
	: '';
$product_price_html        = $product->get_price_html();
$product_is_purchasable    = $product->is_purchasable() && $product->is_in_stock();
$style_attribute           = $product_image_url ? sprintf( '--equipments-card-photo: url(%s);', esc_url( $product_image_url ) ) : '';
$variation_attribute_name  = '';
$variation_attribute_input_name = '';
$variation_attribute_key   = '';
$variation_attribute_label = '';
$variation_options         = array();
$variation_map             = array();
$selected_option           = '';
$selected_variation_id     = 0;
$shop_filter_state         = function_exists( 'lvl_neva_get_shop_filter_state' )
	? lvl_neva_get_shop_filter_state()
	: array(
		'length' => array(),
	);

if ( $product->is_type( 'variable' ) ) {
	$variation_attributes = $product->get_variation_attributes();

	if ( ! empty( $variation_attributes ) ) {
		if ( isset( $variation_attributes['pa_dlina'] ) ) {
			$variation_attribute_name = 'pa_dlina';
		} elseif ( isset( $variation_attributes['attribute_pa_dlina'] ) ) {
			$variation_attribute_name = 'attribute_pa_dlina';
		} else {
			$variation_attribute_name = array_key_first( $variation_attributes );
		}

		$variation_attribute_key        = 0 === strpos( $variation_attribute_name, 'attribute_' ) ? substr( $variation_attribute_name, 10 ) : $variation_attribute_name;
		$variation_attribute_input_name = 'attribute_' . $variation_attribute_key;
		$variation_attribute_label = wc_attribute_label( $variation_attribute_key );
		$default_option            = $product->get_variation_default_attribute( $variation_attribute_key );

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

		if (
			1 === count( $shop_filter_state['length'] )
			&& isset( $variation_map[ $shop_filter_state['length'][0] ] )
			&& isset( $variation_options[ $shop_filter_state['length'][0] ] )
		) {
			$selected_option = $shop_filter_state['length'][0];
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

<div class="collection__item size-height-auto-tablet" role="group">
	<div
		class="div equipments-card_component background-white border-radius equipments-card-adaptive product-archive-card"
		data-product-archive-card=""
		<?php if ( ! empty( $variation_map ) ) : ?>
			data-variation-map="<?php echo esc_attr( wp_json_encode( $variation_map ) ); ?>"
		<?php endif; ?>
		<?php if ( $style_attribute ) : ?>
			style="<?php echo esc_attr( $style_attribute ); ?>"
		<?php endif; ?>
	>
		<form class="product-archive-card__form" method="post">
			<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product_id ); ?>">
			<input type="hidden" name="quantity" value="1">

			<?php if ( ! empty( $variation_map ) && $variation_attribute_input_name ) : ?>
				<input type="hidden" name="product_id" value="<?php echo esc_attr( $product_id ); ?>">
				<input type="hidden" name="variation_id" value="<?php echo esc_attr( $selected_variation_id ); ?>">
				<input type="hidden" name="<?php echo esc_attr( $variation_attribute_input_name ); ?>" value="<?php echo esc_attr( $selected_option ); ?>" data-product-card-attribute-input>
			<?php endif; ?>

			<div class="div flex-direction-horizontal background-white equipments-card-adaptive__layout">
				<div class="div padding-block-xlarge equipments-card-adaptive__content">
					<div class="div flex-direction-vertical size-height-full equipments-card-adaptive__content-inner">
						<div class="div flex-direction-vertical equipments-card-adaptive__top">
							<h3 class="text heading-style-h3 equipments-card-adaptive__title">
								<a href="<?php echo esc_url( $product_permalink ); ?>" class="nav-btn product-archive-card__title-link" aria-label="<?php echo esc_attr( $product_title ); ?>">
									<span class="nav-btn__label" data-label="<?php echo esc_attr( $product_title ); ?>">
										<span class="nav-btn__label-text"><?php echo esc_html( $product_title ); ?></span>
									</span>
								</a>
							</h3>

							<div class="text text-style-body text-color-grey equipments-card-adaptive__description">
								<span class="text-block-wrap-div"><?php echo esc_html( $product_description ); ?></span>
							</div>
						</div>

						<div class="div flex-direction-vertical equipments-card-adaptive__bottom">
							<div class="text heading-style-h5 text-color-brand equipments-card-adaptive__price" data-product-card-price>
								<?php echo wp_kses_post( $product_price_html ); ?>
							</div>

							<?php if ( ! empty( $variation_options ) ) : ?>
								<div class="div flex-direction-vertical equipments-card-adaptive__sizes-block">
									<div class="text text-style-body text-color-grey equipments-card-adaptive__sizes-title">
										<?php echo esc_html( $variation_attribute_label ? $variation_attribute_label : 'Варианты' ); ?>
									</div>

									<div class="div flex-direction-horizontal size-width-full product-purchase__lengths equipments-card-adaptive__sizes" role="radiogroup" aria-label="<?php echo esc_attr( $variation_attribute_label ? $variation_attribute_label : 'Варианты товара' ); ?>">
										<?php foreach ( $variation_options as $variation_value => $variation_label ) : ?>
											<label class="product-purchase__length-option">
												<input
													class="product-purchase__length-input"
													type="radio"
													name="product-card-option-<?php echo esc_attr( $product_id ); ?>"
													value="<?php echo esc_attr( $variation_value ); ?>"
													<?php checked( $selected_option, $variation_value ); ?>
													data-product-card-option
												>
												<span class="product-purchase__length-btn">
													<?php echo esc_html( $variation_label ); ?>
												</span>
											</label>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>

							<div class="div product-archive-card__submit-wrap product-archive-card__submit-wrap--mobile">
								<button class="nav-btn text-style-body product-purchase__submit" type="submit" data-product-card-submit data-default-label="В корзину" data-added-label="В корзине" <?php disabled( ! $product_is_purchasable ); ?>>
									<span class="nav-btn__label" data-label="В корзину">
										<span class="nav-btn__label-text">В корзину</span>
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

				<div class="div equipments-card-adaptive__media">
					<div class="equipments-card-adaptive__media-fade"></div>
					<?php if ( $product_image_html ) : ?>
						<?php echo $product_image_html; ?>
					<?php endif; ?>
				</div>
			</div>

			<div class="product-archive-card__submit-wrap product-archive-card__submit-wrap--desktop">
				<button class="nav-btn text-style-body product-purchase__submit" type="submit" data-product-card-submit data-default-label="В корзину" data-added-label="В корзине" <?php disabled( ! $product_is_purchasable ); ?>>
					<span class="nav-btn__label" data-label="В корзину">
						<span class="nav-btn__label-text">В корзину</span>
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
		</form>
	</div>
</div>
