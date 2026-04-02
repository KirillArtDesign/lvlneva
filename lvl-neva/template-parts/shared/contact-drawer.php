<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="site-contact-drawer" data-contact-drawer>
	<div class="site-contact-drawer__overlay" data-contact-drawer-close></div>

	<div
		class="site-contact-drawer__panel"
		id="site-contact-drawer-panel"
		data-contact-drawer-panel
		aria-hidden="true"
	>
		<div class="div flex-direction-horizontal site-contact-drawer__mobile-head">
			<div class="site-contact-drawer__mobile-title"><?php esc_html_e( 'Связаться с нами', 'lvl-neva' ); ?></div>

			<button
				type="button"
				class="site-contact-drawer__close"
				data-contact-drawer-close
				aria-label="<?php esc_attr_e( 'Закрыть форму заявки', 'lvl-neva' ); ?>"
			>
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M5 5L15 15M15 5L5 15" stroke="currentColor" stroke-width="1.5"></path>
				</svg>
			</button>
		</div>

		<div class="site-contact-drawer__body">
			<div class="site-contact-drawer__content">
				<?php echo function_exists( 'lvl_neva_render_contact_drawer_form_markup' ) ? lvl_neva_render_contact_drawer_form_markup() : ''; ?>
			</div>
		</div>
	</div>

	<button
		type="button"
		class="nav-btn site-contact-drawer__desktop-close"
		data-contact-drawer-close
		aria-label="<?php esc_attr_e( 'Закрыть форму заявки', 'lvl-neva' ); ?>"
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
