<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'lvl_neva_get_video_player_source_data' ) ) {
	function lvl_neva_get_video_player_source_data( $video_url ) {
		$video_url = esc_url_raw( trim( (string) $video_url ) );

		if ( ! $video_url ) {
			return array();
		}

		$parsed_url = wp_parse_url( $video_url );

		if ( false === $parsed_url ) {
			return array();
		}

		$path = strtolower( (string) ( $parsed_url['path'] ?? '' ) );

		if ( preg_match( '/\.(mp4|webm|ogg|ogv|m4v|mov)$/i', $path ) ) {
			return array(
				'type' => 'video',
				'src'  => $video_url,
			);
		}

		$embed_url = lvl_neva_get_youtube_embed_url( $video_url );

		if ( '' === $embed_url ) {
			$embed_url = lvl_neva_get_rutube_embed_url( $video_url );
		}

		if ( '' === $embed_url ) {
			$embed_url = lvl_neva_get_vk_video_embed_url( $video_url );
		}

		if ( '' === $embed_url ) {
			return array();
		}

		return array(
			'type' => 'iframe',
			'src'  => $embed_url,
		);
	}
}

if ( ! function_exists( 'lvl_neva_render_video_player_block' ) ) {
	function lvl_neva_render_video_player_block( $attributes ) {
		$video_url = isset( $attributes['videoUrl'] ) ? (string) $attributes['videoUrl'] : '';
		$source    = lvl_neva_get_video_player_source_data( $video_url );

		if ( empty( $source['src'] ) || empty( $source['type'] ) ) {
			return '';
		}

		$preview_id  = isset( $attributes['previewId'] ) ? absint( $attributes['previewId'] ) : 0;
		$preview_url = '';
		$preview_alt = '';

		if ( $preview_id ) {
			$preview_url = (string) wp_get_attachment_image_url( $preview_id, 'full' );
			$preview_alt = (string) get_post_meta( $preview_id, '_wp_attachment_image_alt', true );

			if ( '' === $preview_alt ) {
				$preview_alt = (string) get_the_title( $preview_id );
			}
		}

		if ( '' === $preview_url && ! empty( $attributes['previewUrl'] ) ) {
			$preview_url = esc_url_raw( (string) $attributes['previewUrl'] );
		}

		if ( '' === $preview_alt && ! empty( $attributes['previewAlt'] ) ) {
			$preview_alt = sanitize_text_field( (string) $attributes['previewAlt'] );
		}

		$wrapper_attributes = get_block_wrapper_attributes(
			array(
				'class'           => 'div flex-direction-vertical size-width-full video-player-block',
				'data-video-type' => $source['type'],
				'data-video-src'  => $source['src'],
			)
		);

		ob_start();
		?>
<div <?php echo $wrapper_attributes; ?>>
	<div class="div video-player-block__frame border-radius">
		<div class="image size-full-percentage video-player-block__preview-wrap">
			<?php if ( $preview_url ) : ?>
				<img
					src="<?php echo esc_url( $preview_url ); ?>"
					alt="<?php echo esc_attr( $preview_alt ); ?>"
					title=""
					class="image__img video-player-block__preview"
				>
			<?php endif; ?>
		</div>

		<button
			type="button"
			class="video-player-block__play border-radius"
			aria-label="<?php echo esc_attr__( 'Воспроизвести видео', 'lvl-neva' ); ?>"
		>
			<svg width="2.4rem" height="2.4rem" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M18.4473 11.1055V12.8945L8.44727 17.8945L7 17V7L8.44727 6.10547L18.4473 11.1055Z" stroke="var(--Primary, #31572C)" stroke-width="2" stroke-linejoin="bevel"/>
			</svg>
		</button>

		<div class="video-player-block__embed-wrap"></div>
	</div>
</div>
		<?php

		return (string) ob_get_clean();
	}
}

if ( ! function_exists( 'lvl_neva_register_video_player_block' ) ) {
	function lvl_neva_register_video_player_block() {
		$theme_directory     = get_template_directory();
		$theme_directory_uri = get_template_directory_uri();
		$editor_script_path  = $theme_directory . '/assets/js/editor-video-block.js';
		$editor_style_path   = $theme_directory . '/assets/css/editor-video-block.css';

		if ( file_exists( $editor_script_path ) ) {
			wp_register_script(
				'lvl-neva-editor-video-block',
				$theme_directory_uri . '/assets/js/editor-video-block.js',
				array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
				(string) filemtime( $editor_script_path ),
				true
			);
		}

		if ( file_exists( $editor_style_path ) ) {
			wp_register_style(
				'lvl-neva-editor-video-block',
				$theme_directory_uri . '/assets/css/editor-video-block.css',
				array( 'wp-edit-blocks' ),
				(string) filemtime( $editor_style_path )
			);
		}

		register_block_type(
			'lvl-neva/video-player',
			array(
				'api_version'     => 2,
				'render_callback' => 'lvl_neva_render_video_player_block',
				'editor_script'   => 'lvl-neva-editor-video-block',
				'editor_style'    => 'lvl-neva-editor-video-block',
				'attributes'      => array(
					'videoUrl'   => array(
						'type'    => 'string',
						'default' => '',
					),
					'previewId'  => array(
						'type'    => 'number',
						'default' => 0,
					),
					'previewUrl' => array(
						'type'    => 'string',
						'default' => '',
					),
					'previewAlt' => array(
						'type'    => 'string',
						'default' => '',
					),
				),
			)
		);
	}
}
add_action( 'init', 'lvl_neva_register_video_player_block' );
