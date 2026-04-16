<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'lvl_neva_get_archive_template_map' ) ) {
	function lvl_neva_get_archive_template_map() {
		return array(
			'portfolio' => 'portfolio-archive.php',
			'services'  => 'servises-archive.php',
		);
	}
}

if ( ! function_exists( 'lvl_neva_get_archive_post_type_for_page' ) ) {
	function lvl_neva_get_archive_post_type_for_page( $page_id = 0 ) {
		$page_id = absint( $page_id );

		if ( $page_id < 1 ) {
			return '';
		}

		$page_template = get_page_template_slug( $page_id );

		if ( ! $page_template ) {
			return '';
		}

		foreach ( lvl_neva_get_archive_template_map() as $post_type => $template_name ) {
			if ( $template_name === $page_template ) {
				return $post_type;
			}
		}

		return '';
	}
}

if ( ! function_exists( 'lvl_neva_get_archive_url_for_post_type' ) ) {
	function lvl_neva_get_archive_url_for_post_type( $post_type ) {
		$post_type = sanitize_key( $post_type );

		if ( ! $post_type ) {
			return home_url( '/' );
		}

		$archive_page_id = function_exists( 'lvl_neva_get_archive_page_for_post_type' )
			? lvl_neva_get_archive_page_for_post_type( $post_type )
			: 0;

		if ( $archive_page_id && 'publish' === get_post_status( $archive_page_id ) ) {
			return get_permalink( $archive_page_id );
		}

		$post_type_object = get_post_type_object( $post_type );

		if ( $post_type_object && ! empty( $post_type_object->has_archive ) ) {
			$archive_url = get_post_type_archive_link( $post_type );

			if ( $archive_url ) {
				return $archive_url;
			}
		}

		return home_url( '/' );
	}
}

if ( ! function_exists( 'lvl_neva_get_archive_title_for_post_type' ) ) {
	function lvl_neva_get_archive_title_for_post_type( $post_type ) {
		$post_type = sanitize_key( $post_type );

		if ( ! $post_type ) {
			return '';
		}

		$archive_page_id = function_exists( 'lvl_neva_get_archive_page_for_post_type' )
			? lvl_neva_get_archive_page_for_post_type( $post_type )
			: 0;

		if ( $archive_page_id ) {
			return get_the_title( $archive_page_id );
		}

		$post_type_object = get_post_type_object( $post_type );

		if ( $post_type_object && ! empty( $post_type_object->labels->name ) ) {
			return $post_type_object->labels->name;
		}

		return '';
	}
}

if ( ! function_exists( 'lvl_neva_is_archive_source_page' ) ) {
	function lvl_neva_is_archive_source_page( $post_type = '' ) {
		if ( ! is_page() ) {
			return false;
		}

		$current_post_type = lvl_neva_get_archive_post_type_for_page( get_queried_object_id() );

		if ( '' === $post_type ) {
			return '' !== $current_post_type;
		}

		return $current_post_type === sanitize_key( $post_type );
	}
}

if ( ! function_exists( 'lvl_neva_register_archive_source_rewrite_rules' ) ) {
	function lvl_neva_register_archive_source_rewrite_rules() {
		foreach ( lvl_neva_get_archive_template_map() as $post_type => $template_name ) {
			$archive_page_id = function_exists( 'lvl_neva_get_archive_page_for_post_type' )
				? lvl_neva_get_archive_page_for_post_type( $post_type )
				: 0;

			if ( ! $archive_page_id || 'publish' !== get_post_status( $archive_page_id ) ) {
				continue;
			}

			$page_path = trim( (string) get_page_uri( $archive_page_id ), '/' );

			if ( '' === $page_path ) {
				continue;
			}

			add_rewrite_rule(
				'^' . preg_quote( $page_path, '/' ) . '/page/([0-9]+)/?$',
				'index.php?page_id=' . (int) $archive_page_id . '&paged=$matches[1]',
				'top'
			);
		}
	}
}
add_action( 'init', 'lvl_neva_register_archive_source_rewrite_rules', 20 );

if ( ! function_exists( 'lvl_neva_maybe_flush_archive_source_rewrite_rules' ) ) {
	function lvl_neva_maybe_flush_archive_source_rewrite_rules() {
		$rules_version = '2026-04-15-virtual-archives-v1';

		if ( get_option( 'lvl_neva_archive_source_rules_version' ) === $rules_version ) {
			return;
		}

		lvl_neva_register_archive_source_rewrite_rules();
		flush_rewrite_rules( false );
		update_option( 'lvl_neva_archive_source_rules_version', $rules_version );
	}
}
add_action( 'init', 'lvl_neva_maybe_flush_archive_source_rewrite_rules', 30 );

if ( ! function_exists( 'lvl_neva_use_archive_template_for_source_pages' ) ) {
	function lvl_neva_use_archive_template_for_source_pages( $template ) {
		if ( ! is_page() ) {
			return $template;
		}

		$post_type = lvl_neva_get_archive_post_type_for_page( get_queried_object_id() );

		if ( ! $post_type ) {
			return $template;
		}

		$archive_template = locate_template( 'archive-' . $post_type . '.php' );

		return $archive_template ? $archive_template : $template;
	}
}
add_filter( 'template_include', 'lvl_neva_use_archive_template_for_source_pages', 20 );

if ( ! function_exists( 'lvl_neva_add_virtual_archive_body_classes' ) ) {
	function lvl_neva_add_virtual_archive_body_classes( $classes ) {
		$post_type = lvl_neva_is_archive_source_page() ? lvl_neva_get_archive_post_type_for_page( get_queried_object_id() ) : '';

		if ( ! $post_type ) {
			return $classes;
		}

		$classes[] = 'archive';
		$classes[] = 'post-type-archive';
		$classes[] = 'post-type-archive-' . sanitize_html_class( $post_type );
		$classes[] = 'lvl-neva-virtual-archive';

		return array_values( array_unique( $classes ) );
	}
}
add_filter( 'body_class', 'lvl_neva_add_virtual_archive_body_classes' );
