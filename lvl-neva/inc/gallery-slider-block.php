<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'lvl_neva_get_gallery_slider_images' ) ) {
	function lvl_neva_get_gallery_slider_images( $attributes ) {
		$raw_images = isset( $attributes['images'] ) && is_array( $attributes['images'] )
			? $attributes['images']
			: array();
		$images     = array();

		foreach ( $raw_images as $raw_image ) {
			if ( ! is_array( $raw_image ) ) {
				continue;
			}

			$image_id    = isset( $raw_image['id'] ) ? absint( $raw_image['id'] ) : 0;
			$image_url   = '';
			$image_alt   = '';
			$image_title = '';

			if ( $image_id > 0 ) {
				$image_url   = (string) wp_get_attachment_image_url( $image_id, 'full' );
				$image_alt   = (string) get_post_meta( $image_id, '_wp_attachment_image_alt', true );
				$image_title = (string) get_the_title( $image_id );

				if ( '' === $image_alt ) {
					$image_alt = $image_title;
				}
			}

			if ( '' === $image_url && ! empty( $raw_image['url'] ) ) {
				$image_url = esc_url_raw( (string) $raw_image['url'] );
			}

			if ( '' === $image_alt && ! empty( $raw_image['alt'] ) ) {
				$image_alt = sanitize_text_field( (string) $raw_image['alt'] );
			}

			if ( '' === $image_title && ! empty( $raw_image['title'] ) ) {
				$image_title = sanitize_text_field( (string) $raw_image['title'] );
			}

			if ( '' === $image_url ) {
				continue;
			}

			$images[] = array(
				'id'    => $image_id,
				'url'   => $image_url,
				'alt'   => $image_alt,
				'title' => $image_title,
			);
		}

		return $images;
	}
}

if ( ! function_exists( 'lvl_neva_get_gallery_slider_nav_button' ) ) {
	function lvl_neva_get_gallery_slider_nav_button( $direction, $slider_id, $is_disabled = false ) {
		$direction = 'prev' === $direction ? 'prev' : 'next';
		$icon_path = 'prev' === $direction
			? 'M12.0898 6.71289L7.72363 10.999H18.5V12.999H7.72363L12.0898 17.2852L10.6885 18.7129L5.5 13.6182V10.3799L10.6885 5.28516L12.0898 6.71289Z'
			: 'M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z';
		$aria_label = 'prev' === $direction
			? __( 'Предыдущий слайд', 'lvl-neva' )
			: __( 'Следующий слайд', 'lvl-neva' );
		$button_classes = 'link-block border-radius button-iconic_component text-color-brand background-light-grey';

		if ( $is_disabled ) {
			$button_classes .= ' swiper-button-disabled';
		}

		ob_start();
		?>
<a
	href=""
	data-action-element=""
	button-iconic-hover-animation=""
	equipment-slider="<?php echo esc_attr( $direction ); ?>"
	class="<?php echo esc_attr( $button_classes ); ?>"
	tabindex="<?php echo esc_attr( $is_disabled ? '-1' : '0' ); ?>"
	role="button"
	aria-label="<?php echo esc_attr( $aria_label ); ?>"
	aria-controls="<?php echo esc_attr( $slider_id ); ?>"
	aria-disabled="<?php echo esc_attr( $is_disabled ? 'true' : 'false' ); ?>"
>
	<div class="div flex-direction-vertical">
		<div class="div clip-content border-radius button-iconic__top background-brand text-color-white">
			<div class="div size-full-percentage flex-center-all">
				<div class="embed icon_component flex-center-all opacity">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="<?php echo esc_attr( $icon_path ); ?>" fill="currentColor"></path>
					</svg>
				</div>
			</div>
		</div>
		<div class="div button-iconic__bottom">
			<div class="div size-full-percentage flex-center-all">
				<div class="embed icon_component flex-center-all">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="<?php echo esc_attr( $icon_path ); ?>" fill="currentColor"></path>
					</svg>
				</div>
			</div>
		</div>
	</div>
</a>
		<?php

		return trim( (string) ob_get_clean() );
	}
}

if ( ! function_exists( 'lvl_neva_render_gallery_slider_block' ) ) {
	function lvl_neva_render_gallery_slider_block( $attributes ) {
		$images = lvl_neva_get_gallery_slider_images( $attributes );

		if ( empty( $images ) ) {
			return '';
		}

		$slider_id = ! empty( $attributes['sliderId'] )
			? sanitize_html_class( (string) $attributes['sliderId'] )
			: ( function_exists( 'wp_unique_id' ) ? wp_unique_id( 'lvl-neva-gallery-slider-' ) : uniqid( 'lvl-neva-gallery-slider-' ) );
		$has_nav   = count( $images ) > 1;

		$wrapper_attributes = get_block_wrapper_attributes(
			array(
				'class' => 'div flex-direction-vertical grid-gap equipment-page_slider_component lvl-neva-gallery-slider-block',
			)
		);

		ob_start();
		?>
<div <?php echo $wrapper_attributes; ?>>
	<div class="div flex-direction-vertical equipment-page_slider_gap">
		<div class="div equipment-page_slider_preview background-white border-radius">
			<div equipment-slider="preview" class="div swiper">
				<div class="div swiper-wrapper flex-direction-horizontal" id="<?php echo esc_attr( $slider_id ); ?>" aria-live="polite">
					<?php foreach ( $images as $image ) : ?>
						<div class="div swiper-slide">
							<div class="div equipment-page_slider_img-wrapper">
								<div class="image size-full-percentage">
									<img
										src="<?php echo esc_url( $image['url'] ); ?>"
										alt="<?php echo esc_attr( $image['alt'] ); ?>"
										title="<?php echo esc_attr( $image['title'] ); ?>"
										class="image__img"
									>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
			</div>

			<?php if ( $has_nav ) : ?>
				<div class="div flex-align-bottom flex-direction-horizontal layer-bottom z-index-top">
					<div class="div padding-block-medium">
						<div class="div flex-direction-vertical">
							<div class="div slider-buttons_component">
								<div class="div space-between flex-direction-horizontal">
									<?php echo lvl_neva_get_gallery_slider_nav_button( 'prev', $slider_id, true ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									<?php echo lvl_neva_get_gallery_slider_nav_button( 'next', $slider_id, false ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( $has_nav ) : ?>
			<div class="div equipment-page_thumbs">
				<div class="div flex-direction-horizontal flex-center size-width-auto equipment-page_thumbs-gap">
					<?php foreach ( $images as $index => $image ) : ?>
						<div
							role="button"
							class="link-block equipment-page_slider_thumb<?php echo 0 === $index ? ' active' : ''; ?>"
							data-index="<?php echo esc_attr( $index ); ?>"
						>
							<div class="image size-full-percentage">
								<img
									src="<?php echo esc_url( $image['url'] ); ?>"
									alt="<?php echo esc_attr( $image['alt'] ); ?>"
									title="<?php echo esc_attr( $image['title'] ); ?>"
									class="image__img"
								>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
		<?php

		return (string) ob_get_clean();
	}
}

if ( ! function_exists( 'lvl_neva_register_gallery_slider_block' ) ) {
	function lvl_neva_register_gallery_slider_block() {
		$theme_directory     = get_template_directory();
		$theme_directory_uri = get_template_directory_uri();
		$editor_script_path  = $theme_directory . '/assets/js/editor-gallery-slider-block.js';
		$editor_style_path   = $theme_directory . '/assets/css/editor-gallery-slider-block.css';

		if ( file_exists( $editor_script_path ) ) {
			wp_register_script(
				'lvl-neva-editor-gallery-slider-block',
				$theme_directory_uri . '/assets/js/editor-gallery-slider-block.js',
				array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
				(string) filemtime( $editor_script_path ),
				true
			);
		}

		if ( file_exists( $editor_style_path ) ) {
			wp_register_style(
				'lvl-neva-editor-gallery-slider-block',
				$theme_directory_uri . '/assets/css/editor-gallery-slider-block.css',
				array( 'wp-edit-blocks' ),
				(string) filemtime( $editor_style_path )
			);
		}

		register_block_type(
			'lvl-neva/gallery-slider',
			array(
				'api_version'     => 2,
				'render_callback' => 'lvl_neva_render_gallery_slider_block',
				'editor_script'   => 'lvl-neva-editor-gallery-slider-block',
				'editor_style'    => 'lvl-neva-editor-gallery-slider-block',
				'attributes'      => array(
					'sliderId' => array(
						'type'    => 'string',
						'default' => '',
					),
					'images'   => array(
						'type'    => 'array',
						'default' => array(),
					),
				),
			)
		);
	}
}
add_action( 'init', 'lvl_neva_register_gallery_slider_block' );
