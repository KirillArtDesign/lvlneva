<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function lvl_neva_has_non_ascii_path( $path ) {
	return 1 === preg_match( '/[^\x20-\x7E]/', (string) $path );
}

function lvl_neva_is_woocommerce_product_import_request() {
	if ( ! is_admin() ) {
		return false;
	}

	$page      = isset( $_REQUEST['page'] ) ? sanitize_key( wp_unslash( $_REQUEST['page'] ) ) : '';
	$post_type = isset( $_REQUEST['post_type'] ) ? sanitize_key( wp_unslash( $_REQUEST['post_type'] ) ) : '';
	$action    = isset( $_REQUEST['action'] ) ? sanitize_key( wp_unslash( $_REQUEST['action'] ) ) : '';

	if ( 'product_importer' === $page && 'product' === $post_type ) {
		return true;
	}

	return wp_doing_ajax() && 'woocommerce_do_ajax_product_import' === $action;
}

function lvl_neva_get_woocommerce_import_temp_dir() {
	return trailingslashit( wp_normalize_path( sys_get_temp_dir() ) ) . 'lvl-neva-woocommerce-imports';
}

function lvl_neva_use_ascii_temp_dir_for_woocommerce_imports( $uploads ) {
	if ( ! lvl_neva_is_woocommerce_product_import_request() || ! lvl_neva_has_non_ascii_path( ABSPATH ) ) {
		return $uploads;
	}

	// WooCommerce normalizes import file paths through parse_url(), which breaks local multibyte paths.
	$temp_dir = lvl_neva_get_woocommerce_import_temp_dir();

	if ( ! is_dir( $temp_dir ) ) {
		wp_mkdir_p( $temp_dir );
	}

	$uploads['basedir'] = $temp_dir;
	$uploads['baseurl'] = content_url( 'uploads/wc-imports-temp' );
	$uploads['path']    = $temp_dir . ( $uploads['subdir'] ?? '' );
	$uploads['url']     = $uploads['baseurl'] . ( $uploads['subdir'] ?? '' );

	return $uploads;
}
add_filter( 'upload_dir', 'lvl_neva_use_ascii_temp_dir_for_woocommerce_imports', 5 );
