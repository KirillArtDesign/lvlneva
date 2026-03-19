<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function lvl_neva_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'lvl-neva' ),
		)
	);
}
add_action( 'after_setup_theme', 'lvl_neva_setup' );

function lvl_neva_enqueue_assets() {
	$theme_version = wp_get_theme()->get( 'Version' );
	$css_dir       = trailingslashit( get_template_directory() ) . 'assets/css/';
	$css_uri       = trailingslashit( get_template_directory_uri() ) . 'assets/css/';
	$js_dir        = trailingslashit( get_template_directory() ) . 'assets/js/';
	$js_uri        = trailingslashit( get_template_directory_uri() ) . 'assets/js/';
	$css_priority  = array(
		'main.css',
		'tt_default_styles.css',
		'tokens.css',
		'ms_site_default.css',
		'styles-inline.css',
		'shared-design-styles.css',
		'swiper-bundle.min.css',
	);
	$js_priority   = array(
		'do.jquery.js',
		'do.lodash-es.js',
		'do.resizeController.js',
		'do.section.js',
		'do.getCurrentProps.js',
		'do.jquery.inputmask.js',
		'do.tt_animation.js',
		'do.tt_collection_v1.js',
		'do.tt_form.js',
		'do.tt_link_universal.js',
		'do.tt_modal.js',
		'do.tt_video.js',
		'do.js',
		'app.js',
	);
	$queued_css    = array();
	$queued_js     = array();
	$previous_css  = 'lvl-neva-style';
	$previous_js   = '';

	wp_enqueue_style( 'lvl-neva-style', get_stylesheet_uri(), array(), $theme_version );

	foreach ( $css_priority as $file_name ) {
		$file_path = $css_dir . $file_name;

		if ( ! file_exists( $file_path ) ) {
			continue;
		}

		$handle = 'lvl-neva-css-' . sanitize_title( pathinfo( $file_name, PATHINFO_FILENAME ) );

		wp_enqueue_style(
			$handle,
			$css_uri . $file_name,
			array( $previous_css ),
			(string) filemtime( $file_path )
		);

		$previous_css = $handle;
		$queued_css[] = $file_name;
	}

	$all_css_files = glob( $css_dir . '*.css' );

	if ( false !== $all_css_files ) {
		natsort( $all_css_files );

		foreach ( $all_css_files as $file_path ) {
			$file_name = basename( $file_path );

			if ( in_array( $file_name, $queued_css, true ) ) {
				continue;
			}

			$handle = 'lvl-neva-css-' . sanitize_title( pathinfo( $file_name, PATHINFO_FILENAME ) );

			wp_enqueue_style(
				$handle,
				$css_uri . $file_name,
				array( $previous_css ),
				(string) filemtime( $file_path )
			);

			$previous_css = $handle;
		}
	}

	foreach ( $js_priority as $file_name ) {
		$file_path = $js_dir . $file_name;

		if ( ! file_exists( $file_path ) ) {
			continue;
		}

		$handle       = 'lvl-neva-js-' . sanitize_title( pathinfo( $file_name, PATHINFO_FILENAME ) );
		$dependencies = $previous_js ? array( $previous_js ) : array();

		wp_enqueue_script(
			$handle,
			$js_uri . $file_name,
			$dependencies,
			(string) filemtime( $file_path ),
			true
		);

		$previous_js = $handle;
		$queued_js[] = $file_name;
	}

	$all_js_files = glob( $js_dir . '*.js' );

	if ( false !== $all_js_files ) {
		natsort( $all_js_files );

		foreach ( $all_js_files as $file_path ) {
			$file_name = basename( $file_path );

			if ( in_array( $file_name, $queued_js, true ) ) {
				continue;
			}

			$handle       = 'lvl-neva-js-' . sanitize_title( pathinfo( $file_name, PATHINFO_FILENAME ) );
			$dependencies = $previous_js ? array( $previous_js ) : array();

			wp_enqueue_script(
				$handle,
				$js_uri . $file_name,
				$dependencies,
				(string) filemtime( $file_path ),
				true
			);

			$previous_js = $handle;
		}
	}
}
add_action( 'wp_enqueue_scripts', 'lvl_neva_enqueue_assets' );
