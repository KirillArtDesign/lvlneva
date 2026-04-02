<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="site-search-drawer" data-search-drawer>
	<div class="site-search-drawer__overlay" data-search-drawer-close></div>

	<div
		class="site-search-drawer__panel"
		id="site-search-drawer-panel"
		data-search-drawer-panel
		aria-hidden="true"
	>
		<div class="div flex-direction-horizontal site-search-drawer__mobile-head">
			<div class="site-search-drawer__mobile-title"><?php esc_html_e( 'Поиск', 'lvl-neva' ); ?></div>

			<button
				type="button"
				class="site-search-drawer__close"
				data-search-drawer-close
				aria-label="<?php esc_attr_e( 'Закрыть поиск', 'lvl-neva' ); ?>"
			>
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M5 5L15 15M15 5L5 15" stroke="currentColor" stroke-width="1.5"></path>
				</svg>
			</button>
		</div>

		<div class="site-search-drawer__body">
			<div class="site-search-drawer__top">
				<div class="site-search-drawer__search-wrap">
					<input
						type="search"
						class="site-search-drawer__input"
						data-search-drawer-input
						placeholder="<?php esc_attr_e( 'Поиск по сайту', 'lvl-neva' ); ?>"
						autocomplete="off"
					>
				</div>
			</div>

			<div class="site-search-drawer__results" data-search-drawer-results>
				<?php echo lvl_neva_get_search_drawer_empty_markup(); ?>
			</div>
		</div>
	</div>

	<button
		type="button"
		class="nav-btn site-search-drawer__desktop-close"
		data-search-drawer-close
		aria-label="<?php esc_attr_e( 'Закрыть поиск', 'lvl-neva' ); ?>"
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
