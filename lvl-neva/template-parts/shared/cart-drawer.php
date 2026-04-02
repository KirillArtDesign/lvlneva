<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="site-cart-drawer" data-cart-drawer>
	<div class="site-cart-drawer__overlay" data-cart-drawer-close></div>

	<div
		class="site-cart-drawer__panel"
		id="site-cart-drawer-panel"
		data-cart-drawer-panel
		aria-hidden="true"
	>
		<div class="div flex-direction-horizontal site-cart-drawer__mobile-head">
			<div class="site-cart-drawer__mobile-title"><?php esc_html_e( 'Корзина', 'lvl-neva' ); ?></div>

			<button
				type="button"
				class="site-cart-drawer__close"
				data-cart-drawer-close
				aria-label="<?php esc_attr_e( 'Закрыть корзину', 'lvl-neva' ); ?>"
			>
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M5 5L15 15M15 5L5 15" stroke="currentColor" stroke-width="1.5"></path>
				</svg>
			</button>
		</div>

		<div class="site-cart-drawer__body">
			<div class="site-cart-drawer__top">
				<div class="site-cart-drawer__title"><?php esc_html_e( 'Корзина', 'lvl-neva' ); ?></div>
			</div>

			<div class="site-cart-drawer__content" data-cart-drawer-content>
				<?php echo lvl_neva_render_cart_drawer_markup(); ?>
			</div>
		</div>
	</div>

	<button
		type="button"
		class="nav-btn site-cart-drawer__desktop-close"
		data-cart-drawer-close
		aria-label="<?php esc_attr_e( 'Закрыть корзину', 'lvl-neva' ); ?>"
	>
		<span class="nav-btn__icon" aria-hidden="true">
			<svg class="nav-btn__icon-svg nav-btn__icon-svg--default" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M6 6L18 18M18 6L6 18" stroke="currentColor" stroke-width="2"></path>
			</svg>
			<svg class="nav-btn__icon-svg nav-btn__icon-svg--hover" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M6 6L18 18M18 6L6 18" stroke="currentColor" stroke-width="2"></path>
			</svg>
		</span>
	</button>
</div>
