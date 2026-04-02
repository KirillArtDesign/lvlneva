<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'lvl_neva_render_equipment_image_block' ) ) {
	function lvl_neva_render_equipment_image_block( $attributes ) {
		$image_id  = isset( $attributes['imageId'] ) ? absint( $attributes['imageId'] ) : 0;
		$image_url = '';
		$image_alt = '';

		if ( $image_id ) {
			$image_url = (string) wp_get_attachment_image_url( $image_id, 'full' );
			$image_alt = (string) get_post_meta( $image_id, '_wp_attachment_image_alt', true );

			if ( '' === $image_alt ) {
				$image_alt = (string) get_the_title( $image_id );
			}
		}

		if ( '' === $image_url && ! empty( $attributes['imageUrl'] ) ) {
			$image_url = esc_url_raw( (string) $attributes['imageUrl'] );
		}

		if ( '' === $image_alt && ! empty( $attributes['imageAlt'] ) ) {
			$image_alt = sanitize_text_field( (string) $attributes['imageAlt'] );
		}

		if ( '' === $image_url ) {
			return '';
		}

		return sprintf(
			'<img class="equipment-article__image border-radius" src="%1$s" alt="%2$s">',
			esc_url( $image_url ),
			esc_attr( $image_alt )
		);
	}
}

if ( ! function_exists( 'lvl_neva_register_equipment_image_block' ) ) {
	function lvl_neva_register_equipment_image_block() {
		$theme_directory     = get_template_directory();
		$theme_directory_uri = get_template_directory_uri();
		$editor_script_path  = $theme_directory . '/assets/js/editor-image-block.js';
		$editor_style_path   = $theme_directory . '/assets/css/editor-image-block.css';

		if ( file_exists( $editor_script_path ) ) {
			wp_register_script(
				'lvl-neva-editor-image-block',
				$theme_directory_uri . '/assets/js/editor-image-block.js',
				array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
				(string) filemtime( $editor_script_path ),
				true
			);
		}

		if ( file_exists( $editor_style_path ) ) {
			wp_register_style(
				'lvl-neva-editor-image-block',
				$theme_directory_uri . '/assets/css/editor-image-block.css',
				array( 'wp-edit-blocks' ),
				(string) filemtime( $editor_style_path )
			);
		}

		register_block_type(
			'lvl-neva/equipment-image',
			array(
				'api_version'     => 2,
				'render_callback' => 'lvl_neva_render_equipment_image_block',
				'editor_script'   => 'lvl-neva-editor-image-block',
				'editor_style'    => 'lvl-neva-editor-image-block',
				'attributes'      => array(
					'imageId'  => array(
						'type'    => 'number',
						'default' => 0,
					),
					'imageUrl' => array(
						'type'    => 'string',
						'default' => '',
					),
					'imageAlt' => array(
						'type'    => 'string',
						'default' => '',
					),
				),
			)
		);
	}
}
add_action( 'init', 'lvl_neva_register_equipment_image_block' );
