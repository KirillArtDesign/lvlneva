<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cart_item_key = $args['cart_item_key'] ?? '';
$cart_item     = $args['cart_item'] ?? array();
$product       = $cart_item['data'] ?? null;

if ( ! $product instanceof WC_Product ) {
	return;
}

$product_permalink = apply_filters(
	'woocommerce_cart_item_permalink',
	$product->is_visible() ? $product->get_permalink( $cart_item ) : '',
	$cart_item,
	$cart_item_key
);
$product_name      = apply_filters( 'woocommerce_cart_item_name', $product->get_name(), $cart_item, $cart_item_key );
$product_image     = $product->get_image(
	'woocommerce_thumbnail',
	array(
		'class' => 'site-cart-drawer-card__image',
	)
);
$product_quantity  = isset( $cart_item['quantity'] ) ? max( 1, (int) $cart_item['quantity'] ) : 1;
$product_meta      = wc_get_formatted_cart_item_data( $cart_item );
$product_total     = function_exists( 'WC' ) && WC()->cart ? WC()->cart->get_product_subtotal( $product, $product_quantity ) : $product->get_price_html();
?>
<div class="site-cart-drawer-card" data-cart-drawer-item="<?php echo esc_attr( $cart_item_key ); ?>">
	<?php if ( $product_permalink ) : ?>
		<a class="site-cart-drawer-card__media" href="<?php echo esc_url( $product_permalink ); ?>">
			<?php echo wp_kses_post( $product_image ); ?>
		</a>
	<?php else : ?>
		<div class="site-cart-drawer-card__media">
			<?php echo wp_kses_post( $product_image ); ?>
		</div>
	<?php endif; ?>

	<div class="site-cart-drawer-card__content">
		<div class="site-cart-drawer-card__top">
			<?php if ( $product_permalink ) : ?>
				<a class="site-cart-drawer-card__title" href="<?php echo esc_url( $product_permalink ); ?>">
					<?php echo esc_html( wp_strip_all_tags( (string) $product_name ) ); ?>
				</a>
			<?php else : ?>
				<div class="site-cart-drawer-card__title">
					<?php echo esc_html( wp_strip_all_tags( (string) $product_name ) ); ?>
				</div>
			<?php endif; ?>

			<button
				type="button"
				class="site-cart-drawer-card__remove"
				data-cart-drawer-remove="<?php echo esc_attr( $cart_item_key ); ?>"
				aria-label="<?php esc_attr_e( 'Удалить товар из корзины', 'lvl-neva' ); ?>"
			>
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M5 5L15 15M15 5L5 15" stroke="currentColor" stroke-width="1.5"></path>
				</svg>
			</button>
		</div>

		<?php if ( $product_meta ) : ?>
			<div class="site-cart-drawer-card__meta">
				<?php echo wp_kses_post( $product_meta ); ?>
			</div>
		<?php endif; ?>

		<div class="site-cart-drawer-card__bottom">
			<div class="product-purchase__field product-purchase__field--qty site-cart-drawer-card__qty-control" data-cart-drawer-qty-control="<?php echo esc_attr( $cart_item_key ); ?>">
				<button
					class="product-purchase__icon-btn"
					type="button"
					aria-label="<?php esc_attr_e( 'Уменьшить количество', 'lvl-neva' ); ?>"
					data-cart-drawer-qty-decrease
					<?php disabled( $product_quantity <= 1 ); ?>
				>
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M7 12H11H12H13H17" stroke="currentColor" stroke-width="2"></path>
					</svg>
				</button>

				<input
					class="product-purchase__qty-input"
					type="number"
					min="1"
					step="1"
					value="<?php echo esc_attr( $product_quantity ); ?>"
					inputmode="numeric"
					aria-label="<?php esc_attr_e( 'Количество товара', 'lvl-neva' ); ?>"
					data-cart-drawer-qty-input
				>

				<button
					class="product-purchase__icon-btn"
					type="button"
					aria-label="<?php esc_attr_e( 'Увеличить количество', 'lvl-neva' ); ?>"
					data-cart-drawer-qty-increase
				>
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M7 12H11M12 12H11M12 12V11M12 12H13M12 12V13M17 12H13M12 7V11M12 17V13M11 12L12 11M11 12L12 13M12 11L13 12M13 12L12 13" stroke="currentColor" stroke-width="2"></path>
					</svg>
				</button>
			</div>
			<div class="site-cart-drawer-card__price"><?php echo wp_kses_post( $product_total ); ?></div>
		</div>
	</div>
</div>
