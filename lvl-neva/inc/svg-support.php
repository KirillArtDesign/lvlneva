<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function lvl_neva_allow_svg_upload_mimes( $mimes ) {
	$mimes['svg']  = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';

	return $mimes;
}
add_filter( 'upload_mimes', 'lvl_neva_allow_svg_upload_mimes' );

function lvl_neva_fix_svg_filetype_and_ext( $data, $file, $filename, $mimes ) {
	$filetype = wp_check_filetype( $filename, $mimes );

	if ( 'svg' === $filetype['ext'] || 'svgz' === $filetype['ext'] ) {
		$data['ext']  = $filetype['ext'];
		$data['type'] = 'image/svg+xml';
	}

	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'lvl_neva_fix_svg_filetype_and_ext', 10, 4 );
