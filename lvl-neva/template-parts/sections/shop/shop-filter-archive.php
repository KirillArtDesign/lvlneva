<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shop_filter_state   = function_exists( 'lvl_neva_get_shop_filter_state' ) ? lvl_neva_get_shop_filter_state() : array(
	'width'  => array(),
	'height' => array(),
	'length' => array(),
);
$shop_filter_options = function_exists( 'lvl_neva_get_shop_filter_options' ) ? lvl_neva_get_shop_filter_options() : array(
	'width'  => array(),
	'height' => array(),
	'length' => array(),
);
$shop_archive_url    = function_exists( 'lvl_neva_get_shop_archive_url' ) ? lvl_neva_get_shop_archive_url() : home_url( '/' );
?>

<div class="div flex-direction-vertical gap-large catalog-filter-drawer" data-filter-drawer data-shop-filter data-shop-archive-url="<?php echo esc_url( $shop_archive_url ); ?>">
	<!-- Кнопка открытия только для мобильной версии -->
	<button
		type="button"
		class="div background-white border-radius catalog-filter-drawer__trigger"
		data-filter-open
		aria-expanded="false"
		aria-controls="catalog-filter-drawer-panel"
	>
		<div class="catalog-filter-drawer__trigger-text">Открыть фильтр</div>
		<div class="catalog-filter-drawer__trigger-icon">
			<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M4 4L7.6 8.07709V11.1379L9.4 12V8.07709L13 4H4Z" stroke="var(--Black, #010101)" stroke-linejoin="bevel"/>
			</svg>
		</div>
	</button>

	<!-- Затемнение -->
	<div class="catalog-filter-drawer__overlay" data-filter-close></div>

	<!-- Drawer / обычный фильтр -->
	<div
		class="catalog-filter-drawer__panel"
		id="catalog-filter-drawer-panel"
		aria-hidden="true"
	>
		<div class="div flex-direction-horizontal catalog-filter-drawer__mobile-head">
			<div class="catalog-filter-drawer__mobile-title">Фильтр</div>

			<button
				type="button"
				class="catalog-filter-drawer__close"
				data-filter-close
				aria-label="Закрыть фильтр"
			>
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M5 5L15 15M15 5L5 15" stroke="currentColor" stroke-width="1.5"/>
				</svg>
			</button>
		</div>

		<div class="div padding-block-small background-white border-radius flex-direction-vertical gap-large section-left-sticky row-gap2 catalog-filter-drawer__body">
			<!-- Толщина -->
			<div class="div flex-direction-vertical row-gap1">
				<div class="text heading-style-h5">
					<span class="text-block-wrap-div">Толщина:</span>
				</div>

				<div class="div flex-direction-horizontal flex-wrap-gap">
					<?php foreach ( $shop_filter_options['width'] as $width_value ) : ?>
						<label class="size-filter">
							<input
								type="checkbox"
								name="thickness"
								value="<?php echo esc_attr( $width_value ); ?>"
								data-shop-filter-input
								data-shop-filter-key="shop_width"
								<?php checked( in_array( $width_value, $shop_filter_state['width'], true ) ); ?>
							>
							<div class="size-badge text text-style-body"><?php echo esc_html( lvl_neva_get_shop_dimension_label( $width_value ) ); ?></div>
						</label>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Ширина -->
			<div class="div flex-direction-vertical row-gap1">
				<div class="text heading-style-h5">
					<span class="text-block-wrap-div">Ширина:</span>
				</div>

				<div class="div flex-direction-horizontal flex-wrap-gap">
					<?php foreach ( $shop_filter_options['height'] as $height_value ) : ?>
						<label class="size-filter">
							<input
								type="checkbox"
								name="width"
								value="<?php echo esc_attr( $height_value ); ?>"
								data-shop-filter-input
								data-shop-filter-key="shop_height"
								<?php checked( in_array( $height_value, $shop_filter_state['height'], true ) ); ?>
							>
							<div class="size-badge text text-style-body"><?php echo esc_html( lvl_neva_get_shop_dimension_label( $height_value ) ); ?></div>
						</label>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Длина -->
			<div class="div flex-direction-vertical row-gap1">
				<div class="text heading-style-h5">
					<span class="text-block-wrap-div">Длина:</span>
				</div>

				<div class="div flex-direction-horizontal flex-wrap-gap">
					<?php foreach ( $shop_filter_options['length'] as $length_term ) : ?>
						<label class="size-filter">
							<input
								type="checkbox"
								name="length"
								value="<?php echo esc_attr( $length_term->slug ); ?>"
								data-shop-filter-input
								data-shop-filter-key="shop_length"
								<?php checked( in_array( $length_term->slug, $shop_filter_state['length'], true ) ); ?>
							>
							<div class="size-badge text text-style-body"><?php echo esc_html( $length_term->name ); ?></div>
						</label>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
