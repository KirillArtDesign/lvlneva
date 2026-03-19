<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/theme-data.php';

function lvl_neva_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
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
			'footer'  => __( 'Footer Menu', 'lvl-neva' ),
		)
	);
}
add_action( 'after_setup_theme', 'lvl_neva_setup' );

function lvl_neva_enqueue_assets() {
	$css_dir       = trailingslashit( get_template_directory() ) . 'assets/css/';
	$css_uri       = trailingslashit( get_template_directory_uri() ) . 'assets/css/';
	$font_dir      = trailingslashit( get_template_directory() ) . 'assets/fonts/';
	$font_uri      = trailingslashit( get_template_directory_uri() ) . 'assets/fonts/';
	$js_dir        = trailingslashit( get_template_directory() ) . 'assets/js/';
	$js_uri        = trailingslashit( get_template_directory_uri() ) . 'assets/js/';
	$css_priority  = array(
		'main.css',
		'tt_default_styles.css',
		'tokens.css',
		'ms_site_default.css',
		'styles-inline.css',
		'shared-design-styles.css',
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
	$previous_css  = '';
	$previous_js   = 'jquery';

	foreach ( $css_priority as $file_name ) {
		$file_path = $css_dir . $file_name;

		if ( ! file_exists( $file_path ) ) {
			continue;
		}

		$handle = 'lvl-neva-css-' . sanitize_title( pathinfo( $file_name, PATHINFO_FILENAME ) );

		wp_enqueue_style(
			$handle,
			$css_uri . $file_name,
			$previous_css ? array( $previous_css ) : array(),
			(string) filemtime( $file_path )
		);

		$previous_css = $handle;
	}

	if ( file_exists( $font_dir . 'font-bebas-neue.css' ) ) {
		wp_enqueue_style(
			'lvl-neva-font-bebas',
			$font_uri . 'font-bebas-neue.css',
			$previous_css ? array( $previous_css ) : array(),
			(string) filemtime( $font_dir . 'font-bebas-neue.css' )
		);
		$previous_css = 'lvl-neva-font-bebas';
	}

	wp_enqueue_style(
		'lvl-neva-google-fonts',
		'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter+Tight:ital,wght@0,100..900;1,100..900&display=swap',
		$previous_css ? array( $previous_css ) : array(),
		null
	);

	$previous_css = 'lvl-neva-google-fonts';

	wp_enqueue_style(
		'lvl-neva-swiper-css',
		'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css',
		array( $previous_css ),
		'12',
	);

	wp_enqueue_script( 'jquery' );

	wp_enqueue_script(
		'lvl-neva-swiper',
		'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js',
		array(),
		'12',
		true
	);

	wp_script_add_data( 'lvl-neva-swiper', 'strategy', 'defer' );

	foreach ( $js_priority as $file_name ) {
		$file_path = $js_dir . $file_name;

		if ( ! file_exists( $file_path ) ) {
			continue;
		}

		$handle       = 'lvl-neva-js-' . sanitize_title( pathinfo( $file_name, PATHINFO_FILENAME ) );
		$dependencies = $previous_js ? array( $previous_js ) : array();

		if ( 'app.js' === $file_name ) {
			$dependencies[] = 'lvl-neva-swiper';
		}

		wp_enqueue_script(
			$handle,
			$js_uri . $file_name,
			$dependencies,
			(string) filemtime( $file_path ),
			true
		);

		wp_script_add_data( $handle, 'strategy', 'defer' );

		$previous_js = $handle;
	}
}
add_action( 'wp_enqueue_scripts', 'lvl_neva_enqueue_assets' );

function lvl_neva_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' !== $relation_type ) {
		return $urls;
	}

	$urls[] = 'https://fonts.googleapis.com';
	$urls[] = array(
		'href'        => 'https://fonts.gstatic.com',
		'crossorigin' => 'anonymous',
	);

	return $urls;
}
add_filter( 'wp_resource_hints', 'lvl_neva_resource_hints', 10, 2 );

function lvl_neva_get_data_do_json() {
	static $data_do_json = null;

	if ( null !== $data_do_json ) {
		return $data_do_json;
	}

	$source_path = get_template_directory() . '/html/lvl neva - исходник/index.html';

	if ( ! file_exists( $source_path ) ) {
		$data_do_json = '';
		return $data_do_json;
	}

	$source_html = file_get_contents( $source_path );

	if ( false === $source_html ) {
		$data_do_json = '';
		return $data_do_json;
	}

	if ( preg_match( '#<script type="application/json" id="data_do_json">\s*(.*?)\s*</script>#s', $source_html, $matches ) ) {
		$data_do_json = trim( $matches[1] );
	} else {
		$data_do_json = '';
	}

	return $data_do_json;
}

function lvl_neva_print_data_do_json() {
	$data_do_json = lvl_neva_get_data_do_json();

	if ( '' === $data_do_json ) {
		return;
	}

	printf(
		'<script type="application/json" id="data_do_json">%s</script>' . "\n",
		str_replace( '</script>', '<\/script>', $data_do_json )
	);
}
add_action( 'wp_footer', 'lvl_neva_print_data_do_json', 5 );
