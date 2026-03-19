<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="div flex-direction-vertical gap-large catalog-filter-drawer" data-filter-drawer>
	<button type="button" class="div background-white border-radius catalog-filter-drawer__trigger" data-filter-open aria-expanded="false" aria-controls="catalog-filter-drawer-panel">
		<div class="catalog-filter-drawer__trigger-text"><?php esc_html_e( 'Открыть фильтр', 'lvl-neva' ); ?></div>
		<div class="catalog-filter-drawer__trigger-icon">
			<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M4 4L7.6 8.07709V11.1379L9.4 12V8.07709L13 4H4Z" stroke="var(--Black, #010101)" stroke-linejoin="bevel"/>
			</svg>
		</div>
	</button>
	<div class="catalog-filter-drawer__overlay" data-filter-close></div>
	<div class="catalog-filter-drawer__panel" id="catalog-filter-drawer-panel" aria-hidden="true">
		<div class="div flex-direction-horizontal catalog-filter-drawer__mobile-head">
			<div class="catalog-filter-drawer__mobile-title"><?php esc_html_e( 'Фильтр', 'lvl-neva' ); ?></div>
			<button type="button" class="catalog-filter-drawer__close" data-filter-close aria-label="<?php esc_attr_e( 'Закрыть фильтр', 'lvl-neva' ); ?>">
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M5 5L15 15M15 5L5 15" stroke="currentColor" stroke-width="1.5"/>
				</svg>
			</button>
		</div>
		<div class="div padding-block-small background-white border-radius flex-direction-vertical gap-large section-left-sticky row-gap2 catalog-filter-drawer__body">
			<div class="div flex-direction-vertical row-gap1">
				<div class="text heading-style-h5"><span class="text-block-wrap-div"><?php esc_html_e( 'Толщина:', 'lvl-neva' ); ?></span></div>
				<div class="div flex-direction-horizontal flex-wrap-gap">
					<?php foreach ( array( '45мм', '51мм', '63мм', '75мм', '90мм' ) as $size ) : ?>
						<label class="size-filter"><input type="checkbox"><div class="size-badge text text-style-body"><?php echo esc_html( $size ); ?></div></label>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="div flex-direction-vertical row-gap1">
				<div class="text heading-style-h5"><span class="text-block-wrap-div"><?php esc_html_e( 'Ширина:', 'lvl-neva' ); ?></span></div>
				<div class="div flex-direction-horizontal flex-wrap-gap">
					<?php foreach ( array( '150мм', '200мм', '240мм', '300мм', '400мм' ) as $size ) : ?>
						<label class="size-filter"><input type="checkbox"><div class="size-badge text text-style-body"><?php echo esc_html( $size ); ?></div></label>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="div flex-direction-vertical row-gap1">
				<div class="text heading-style-h5"><span class="text-block-wrap-div"><?php esc_html_e( 'Длина:', 'lvl-neva' ); ?></span></div>
				<div class="div flex-direction-horizontal flex-wrap-gap">
					<?php foreach ( array( '1м', '2м', '3м', '4.5м', '6м', '6.5м', '7м', '8м', '9м', '10м', '12м', '13.5м' ) as $size ) : ?>
						<label class="size-filter"><input type="checkbox"><div class="size-badge text text-style-body"><?php echo esc_html( $size ); ?></div></label>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
