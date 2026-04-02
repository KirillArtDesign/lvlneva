<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/breadcrumbs.php';
require_once get_template_directory() . '/inc/article-content.php';
require_once get_template_directory() . '/inc/listing-pagination.php';
require_once get_template_directory() . '/inc/content-filter.php';
require_once get_template_directory() . '/inc/shop-filter.php';
require_once get_template_directory() . '/inc/search-drawer.php';
require_once get_template_directory() . '/inc/cart-drawer.php';
require_once get_template_directory() . '/inc/contact-form.php';
require_once get_template_directory() . '/inc/contact-drawer.php';
require_once get_template_directory() . '/inc/image-block.php';
require_once get_template_directory() . '/inc/video-block.php';

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
			'primary'       => __( 'Primary Menu', 'lvl-neva' ),
			'footer_menu_1' => __( 'Footer Menu 1', 'lvl-neva' ),
			'footer_menu_2' => __( 'Footer Menu 2', 'lvl-neva' ),
		)
	);
}
add_action( 'after_setup_theme', 'lvl_neva_setup' );

function lvl_neva_register_block_category( $block_categories ) {
	$lvl_neva_category = array(
		'slug'  => 'lvl-neva',
		'title' => 'Блоки lvl-neva',
	);

	$block_categories = array_filter(
		$block_categories,
		static function ( $category ) {
			return ! isset( $category['slug'] ) || 'lvl-neva' !== $category['slug'];
		}
	);

	array_unshift( $block_categories, $lvl_neva_category );

	return $block_categories;
}
add_filter( 'block_categories_all', 'lvl_neva_register_block_category' );

function lvl_neva_filter_woocommerce_styles( $styles ) {
	if ( isset( $styles['woocommerce-layout'] ) ) {
		unset( $styles['woocommerce-layout'] );
	}

	return $styles;
}
add_filter( 'woocommerce_enqueue_styles', 'lvl_neva_filter_woocommerce_styles' );

function lvl_neva_dequeue_woocommerce_layout_style() {
	wp_dequeue_style( 'woocommerce-layout' );
	wp_deregister_style( 'woocommerce-layout' );
}
add_action( 'wp_enqueue_scripts', 'lvl_neva_dequeue_woocommerce_layout_style', 100 );

function lvl_neva_get_product_additional_services( $product_id ) {
	if ( ! function_exists( 'get_field' ) ) {
		return array();
	}

	$services_raw = get_field( 'dopolnitelnye_uslugi_s_pokupkoj', $product_id );
	$services     = array();

	if ( $services_raw instanceof WP_Post ) {
		$services_raw = array( $services_raw );
	} elseif ( ! is_array( $services_raw ) ) {
		$services_raw = array_filter( array( $services_raw ) );
	}

	foreach ( $services_raw as $service_item ) {
		$service_post = null;

		if ( $service_item instanceof WP_Post ) {
			$service_post = $service_item;
		} elseif ( is_numeric( $service_item ) ) {
			$service_post = get_post( (int) $service_item );
		}

		if (
			$service_post instanceof WP_Post
			&& 'services' === $service_post->post_type
			&& 'publish' === $service_post->post_status
		) {
			$services[ $service_post->ID ] = $service_post;
		}
	}

	return $services;
}

function lvl_neva_add_additional_service_to_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
	if ( empty( $_POST['lvl_neva_additional_service'] ) ) {
		return $cart_item_data;
	}

	$selected_service_id = absint( wp_unslash( $_POST['lvl_neva_additional_service'] ) );

	if ( ! $selected_service_id ) {
		return $cart_item_data;
	}

	$allowed_services = lvl_neva_get_product_additional_services( $product_id );

	if ( empty( $allowed_services[ $selected_service_id ] ) ) {
		return $cart_item_data;
	}

	$cart_item_data['lvl_neva_additional_service_id']    = $selected_service_id;
	$cart_item_data['lvl_neva_additional_service_title'] = get_the_title( $selected_service_id );

	return $cart_item_data;
}
add_filter( 'woocommerce_add_cart_item_data', 'lvl_neva_add_additional_service_to_cart_item_data', 10, 3 );

function lvl_neva_render_additional_service_in_cart( $item_data, $cart_item ) {
	if ( empty( $cart_item['lvl_neva_additional_service_title'] ) ) {
		return $item_data;
	}

	$item_data[] = array(
		'name'  => __( 'Дополнительная услуга', 'lvl-neva' ),
		'value' => wp_strip_all_tags( (string) $cart_item['lvl_neva_additional_service_title'] ),
	);

	return $item_data;
}
add_filter( 'woocommerce_get_item_data', 'lvl_neva_render_additional_service_in_cart', 10, 2 );

function lvl_neva_add_additional_service_to_order_item( $item, $cart_item_key, $values, $order ) {
	if ( empty( $values['lvl_neva_additional_service_title'] ) ) {
		return;
	}

	$item->add_meta_data(
		__( 'Дополнительная услуга', 'lvl-neva' ),
		wp_strip_all_tags( (string) $values['lvl_neva_additional_service_title'] ),
		true
	);
}
add_action( 'woocommerce_checkout_create_order_line_item', 'lvl_neva_add_additional_service_to_order_item', 10, 4 );

function lvl_neva_disable_add_to_cart_notice( $message ) {
	return '';
}
add_filter( 'wc_add_to_cart_message_html', 'lvl_neva_disable_add_to_cart_notice' );

function lvl_neva_enqueue_assets() {
	$theme_version = wp_get_theme()->get( 'Version' );
	$css_dir       = trailingslashit( get_template_directory() ) . 'assets/css/';
	$css_uri       = trailingslashit( get_template_directory_uri() ) . 'assets/css/';
	$fonts_uri     = trailingslashit( get_template_directory_uri() ) . 'assets/fonts/';
	$js_dir        = trailingslashit( get_template_directory() ) . 'assets/js/';
	$js_uri        = trailingslashit( get_template_directory_uri() ) . 'assets/js/';
	$css_priority  = array(
		'main.css',
		'tt_default_styles.css',
		'tokens.css',
		'ms_site_default.css',
		// 'styles-inline.css',
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

			if ( 0 === strpos( $file_name, 'editor-' ) ) {
				continue;
			}

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

	wp_add_inline_style(
		$previous_css,
		"@font-face{font-family:'BebasNeue';font-style:normal;font-weight:400;src:url('{$fonts_uri}BebasNeue.woff2') format('woff2'),url('{$fonts_uri}BebasNeue.woff') format('woff');}" .
		"@font-face{font-family:'BebasNeue Bold';font-style:normal;font-weight:700;src:url('{$fonts_uri}BebasNeue.woff2') format('woff2'),url('{$fonts_uri}BebasNeue.woff') format('woff');}"
	);

	wp_enqueue_script(
		'lvl-neva-swiper',
		'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js',
		array(),
		'12.0.0',
		true
	);

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

			if ( 0 === strpos( $file_name, 'editor-' ) ) {
				continue;
			}

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

	if ( wp_script_is( 'lvl-neva-js-content-filter', 'enqueued' ) ) {
		wp_localize_script(
			'lvl-neva-js-content-filter',
			'lvlNevaContentFilter',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'lvl_neva_content_filter' ),
			)
		);
	}

	if ( wp_script_is( 'lvl-neva-js-search-drawer', 'enqueued' ) ) {
		wp_localize_script(
			'lvl-neva-js-search-drawer',
			'lvlNevaSearchDrawer',
			array(
				'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'lvl_neva_search_drawer' ),
				'minChars' => 1,
			)
		);
	}

	if ( wp_script_is( 'lvl-neva-js-cart-drawer', 'enqueued' ) ) {
		wp_localize_script(
			'lvl-neva-js-cart-drawer',
			'lvlNevaCartDrawer',
			array(
				'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
				'nonce'       => wp_create_nonce( 'lvl_neva_cart_drawer' ),
				'initialCount'=> function_exists( 'lvl_neva_get_cart_drawer_count' ) ? lvl_neva_get_cart_drawer_count() : 0,
			)
		);
	}

	if ( wp_script_is( 'lvl-neva-js-contact-form', 'enqueued' ) ) {
		wp_localize_script(
			'lvl-neva-js-contact-form',
			'lvlNevaContactForm',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'lvl_neva_contact_form' ),
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'lvl_neva_enqueue_assets' );

if ( ! function_exists( 'lvl_neva_parse_video_time_to_seconds' ) ) {
	function lvl_neva_parse_video_time_to_seconds( $value ) {
		$value = trim( (string) $value );

		if ( '' === $value ) {
			return 0;
		}

		if ( ctype_digit( $value ) ) {
			return (int) $value;
		}

		if ( preg_match_all( '/(\d+)(h|m|s)/i', $value, $matches, PREG_SET_ORDER ) ) {
			$seconds = 0;

			foreach ( $matches as $match ) {
				$amount = (int) $match[1];
				$unit   = strtolower( $match[2] );

				if ( 'h' === $unit ) {
					$seconds += $amount * HOUR_IN_SECONDS;
				} elseif ( 'm' === $unit ) {
					$seconds += $amount * MINUTE_IN_SECONDS;
				} else {
					$seconds += $amount;
				}
			}

			return $seconds;
		}

		return 0;
	}
}

if ( ! function_exists( 'lvl_neva_get_youtube_embed_url' ) ) {
	function lvl_neva_get_youtube_embed_url( $video_url ) {
		$video_url = esc_url_raw( $video_url );

		if ( ! $video_url ) {
			return '';
		}

		$parsed_url = wp_parse_url( $video_url );

		if ( false === $parsed_url ) {
			return '';
		}

		$host       = strtolower( (string) ( $parsed_url['host'] ?? '' ) );
		$path       = trim( (string) ( $parsed_url['path'] ?? '' ), '/' );
		$query_args = array();
		$video_id   = '';

		if ( ! empty( $parsed_url['query'] ) ) {
			parse_str( $parsed_url['query'], $query_args );
		}

		if ( false !== strpos( $host, 'youtu.be' ) ) {
			$path_parts = explode( '/', $path );
			$video_id   = $path_parts[0] ?? '';
		} elseif ( false !== strpos( $host, 'youtube' ) || false !== strpos( $host, 'youtube-nocookie' ) ) {
			if ( ! empty( $query_args['v'] ) ) {
				$video_id = (string) $query_args['v'];
			} elseif ( preg_match( '~^(?:embed|shorts|live)/([^/?&#]+)~', $path, $matches ) ) {
				$video_id = $matches[1];
			}
		}

		if ( '' === $video_id ) {
			return '';
		}

		$embed_args = array(
			'rel' => '0',
		);
		$start_time = 0;

		if ( ! empty( $query_args['start'] ) ) {
			$start_time = lvl_neva_parse_video_time_to_seconds( $query_args['start'] );
		} elseif ( ! empty( $query_args['t'] ) ) {
			$start_time = lvl_neva_parse_video_time_to_seconds( $query_args['t'] );
		}

		if ( $start_time > 0 ) {
			$embed_args['start'] = $start_time;
		}

		if ( ! empty( $query_args['list'] ) ) {
			$embed_args['list'] = sanitize_text_field( (string) $query_args['list'] );
		}

		return add_query_arg(
			$embed_args,
			sprintf( 'https://www.youtube-nocookie.com/embed/%s', rawurlencode( $video_id ) )
		);
	}
}

if ( ! function_exists( 'lvl_neva_get_rutube_embed_url' ) ) {
	function lvl_neva_get_rutube_embed_url( $video_url ) {
		$video_url = esc_url_raw( $video_url );

		if ( ! $video_url ) {
			return '';
		}

		$parsed_url = wp_parse_url( $video_url );

		if ( false === $parsed_url ) {
			return '';
		}

		$host       = strtolower( (string) ( $parsed_url['host'] ?? '' ) );
		$path       = (string) ( $parsed_url['path'] ?? '' );
		$query_args = array();
		$video_id   = '';

		if ( false === strpos( $host, 'rutube.ru' ) ) {
			return '';
		}

		if ( ! empty( $parsed_url['query'] ) ) {
			parse_str( $parsed_url['query'], $query_args );
		}

		if ( preg_match( '~^/play/embed/([a-zA-Z0-9]+)/?~', $path, $matches ) ) {
			$video_id = $matches[1];
		} elseif ( preg_match( '~^/video/([a-zA-Z0-9]+)/?~', $path, $matches ) ) {
			$video_id = $matches[1];
		}

		if ( '' === $video_id ) {
			return '';
		}

		$embed_url = sprintf( 'https://rutube.ru/play/embed/%s/', rawurlencode( $video_id ) );

		if ( ! empty( $query_args['p'] ) ) {
			$embed_url = add_query_arg(
				array(
					'p' => sanitize_text_field( (string) $query_args['p'] ),
				),
				$embed_url
			);
		}

		return $embed_url;
	}
}

if ( ! function_exists( 'lvl_neva_get_vk_video_embed_url' ) ) {
	function lvl_neva_get_vk_video_embed_url( $video_url ) {
		$video_url = esc_url_raw( $video_url );

		if ( ! $video_url ) {
			return '';
		}

		$parsed_url = wp_parse_url( $video_url );

		if ( false === $parsed_url ) {
			return '';
		}

		$host       = strtolower( (string) ( $parsed_url['host'] ?? '' ) );
		$path       = (string) ( $parsed_url['path'] ?? '' );
		$query_args = array();

		if ( false === strpos( $host, 'vk.com' ) && false === strpos( $host, 'vkvideo.ru' ) ) {
			return '';
		}

		if ( ! empty( $parsed_url['query'] ) ) {
			parse_str( $parsed_url['query'], $query_args );
		}

		if ( false !== strpos( $path, 'video_ext.php' ) ) {
			return $video_url;
		}

		if ( ! preg_match( '~video(-?\d+)_(\d+)~', $video_url, $matches ) ) {
			return '';
		}

		$embed_args = array(
			'oid' => $matches[1],
			'id'  => $matches[2],
			'hd'  => '2',
		);

		if ( ! empty( $query_args['hash'] ) ) {
			$embed_args['hash'] = sanitize_text_field( (string) $query_args['hash'] );
		}

		return add_query_arg( $embed_args, 'https://vk.com/video_ext.php' );
	}
}

if ( ! function_exists( 'lvl_neva_get_video_embed_html' ) ) {
	function lvl_neva_get_video_embed_html( $video_url, $args = array() ) {
		$video_url = esc_url_raw( trim( (string) $video_url ) );

		if ( ! $video_url ) {
			return '';
		}

		$args = wp_parse_args(
			$args,
			array(
				'title'  => '',
				'width'  => 1428,
				'height' => 803,
				'poster' => '',
			)
		);

		$parsed_url = wp_parse_url( $video_url );

		if ( false === $parsed_url ) {
			return '';
		}

		$path        = strtolower( (string) ( $parsed_url['path'] ?? '' ) );
		$poster_attr = '';

		if ( ! empty( $args['poster'] ) ) {
			$poster_attr = sprintf( ' poster="%s"', esc_url( $args['poster'] ) );
		}

		if ( preg_match( '/\.(mp4|webm|ogg|ogv|m4v|mov)$/i', $path ) ) {
			return sprintf(
				'<video controls playsinline preload="metadata"%1$s><source src="%2$s"></video>',
				$poster_attr,
				esc_url( $video_url )
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
			return '';
		}

		return sprintf(
			'<iframe allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen frameborder="0" height="%1$d" referrerpolicy="strict-origin-when-cross-origin" src="%2$s" title="%3$s" width="%4$d"></iframe>',
			absint( $args['height'] ),
			esc_url( $embed_url ),
			esc_attr( $args['title'] ),
			absint( $args['width'] )
		);
	}
}
