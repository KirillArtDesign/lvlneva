<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'lvl_neva_get_shop_archive_url' ) ) {
	function lvl_neva_get_shop_archive_url() {
		if ( is_tax() ) {
			$queried_term = get_queried_object();

			if ( $queried_term instanceof WP_Term && is_object_in_taxonomy( 'product', $queried_term->taxonomy ) ) {
				$term_link = get_term_link( $queried_term );

				if ( ! is_wp_error( $term_link ) && $term_link ) {
					return $term_link;
				}
			}
		}

		$archive_url = '';

		if ( function_exists( 'wc_get_page_permalink' ) ) {
			$archive_url = wc_get_page_permalink( 'shop' );
		}

		if ( ! $archive_url ) {
			$archive_url = get_post_type_archive_link( 'product' );
		}

		return $archive_url ? $archive_url : home_url( '/' );
	}
}

if ( ! function_exists( 'lvl_neva_get_shop_filter_numeric_value' ) ) {
	function lvl_neva_get_shop_filter_numeric_value( $value ) {
		$value = wp_strip_all_tags( (string) $value );

		if ( preg_match( '/-?\d+(?:[.,]\d+)?/', $value, $matches ) ) {
			return (float) str_replace( ',', '.', $matches[0] );
		}

		return 0.0;
	}
}

if ( ! function_exists( 'lvl_neva_get_shop_dimension_label' ) ) {
	function lvl_neva_get_shop_dimension_label( $value ) {
		$value         = trim( (string) $value );
		$numeric_value = lvl_neva_get_shop_filter_numeric_value( $value );

		if ( 0.0 === $numeric_value && '0' !== $value && '0.0' !== $value && '0,0' !== $value ) {
			return $value;
		}

		if ( floor( $numeric_value ) === $numeric_value ) {
			return sprintf( '%sмм', number_format_i18n( $numeric_value, 0 ) );
		}

		return sprintf( '%sмм', rtrim( rtrim( str_replace( '.', ',', (string) $numeric_value ), '0' ), ',' ) );
	}
}

if ( ! function_exists( 'lvl_neva_parse_shop_filter_values' ) ) {
	function lvl_neva_parse_shop_filter_values( $raw_values, $sanitize_callback = 'sanitize_text_field' ) {
		if ( is_array( $raw_values ) ) {
			$values = $raw_values;
		} else {
			$values = explode( ',', (string) $raw_values );
		}

		$values = array_map(
			static function ( $value ) use ( $sanitize_callback ) {
				$value = is_string( $value ) ? wp_unslash( $value ) : $value;
				$value = trim( (string) $value );

				if ( '' === $value ) {
					return '';
				}

				return is_callable( $sanitize_callback ) ? (string) call_user_func( $sanitize_callback, $value ) : sanitize_text_field( $value );
			},
			$values
		);

		$values = array_values( array_filter( array_unique( $values ) ) );

		usort(
			$values,
			static function ( $left, $right ) {
				return lvl_neva_get_shop_filter_numeric_value( $left ) <=> lvl_neva_get_shop_filter_numeric_value( $right );
			}
		);

		return $values;
	}
}

if ( ! function_exists( 'lvl_neva_get_shop_filter_state' ) ) {
	function lvl_neva_get_shop_filter_state( $source = null ) {
		if ( null === $source ) {
			$source = $_GET;
		}

		return array(
			'width'  => lvl_neva_parse_shop_filter_values( $source['shop_width'] ?? array() ),
			'height' => lvl_neva_parse_shop_filter_values( $source['shop_height'] ?? array() ),
			'length' => lvl_neva_parse_shop_filter_values( $source['shop_length'] ?? array(), 'sanitize_title' ),
		);
	}
}

if ( ! function_exists( 'lvl_neva_get_shop_dimension_options' ) ) {
	function lvl_neva_get_shop_dimension_options( $meta_key ) {
		global $wpdb;

		$values = $wpdb->get_col(
			$wpdb->prepare(
				"
				SELECT DISTINCT pm.meta_value
				FROM {$wpdb->postmeta} pm
				INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE pm.meta_key = %s
					AND pm.meta_value <> ''
					AND p.post_type = 'product'
					AND p.post_status = 'publish'
				",
				$meta_key
			)
		);

		if ( ! is_array( $values ) ) {
			return array();
		}

		return lvl_neva_parse_shop_filter_values( $values );
	}
}

if ( ! function_exists( 'lvl_neva_get_shop_length_options' ) ) {
	function lvl_neva_get_shop_length_options() {
		$terms = get_terms(
			array(
				'taxonomy'   => 'pa_dlinna',
				'hide_empty' => true,
			)
		);

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return array();
		}

		$terms = array_values(
			array_filter(
				$terms,
				static function ( $term ) {
					return $term instanceof WP_Term;
				}
			)
		);

		usort(
			$terms,
			static function ( $left, $right ) {
				return lvl_neva_get_shop_filter_numeric_value( $left->name ) <=> lvl_neva_get_shop_filter_numeric_value( $right->name );
			}
		);

		return $terms;
	}
}

if ( ! function_exists( 'lvl_neva_get_shop_filter_options' ) ) {
	function lvl_neva_get_shop_filter_options() {
		return array(
			'width'  => lvl_neva_get_shop_dimension_options( '_width' ),
			'height' => lvl_neva_get_shop_dimension_options( '_height' ),
			'length' => lvl_neva_get_shop_length_options(),
		);
	}
}

if ( ! function_exists( 'lvl_neva_is_shop_context' ) ) {
	function lvl_neva_is_shop_context( $query = null ) {
		if ( ! post_type_exists( 'product' ) ) {
			return false;
		}

		$product_taxonomies = get_object_taxonomies( 'product' );
		$is_product_archive = false;

		if ( $query instanceof WP_Query ) {
			$is_product_archive = $query->is_post_type_archive( 'product' );

			if ( ! $is_product_archive && ! empty( $product_taxonomies ) ) {
				$is_product_archive = $query->is_tax( $product_taxonomies );
			}
		}

		if ( $is_product_archive ) {
			return true;
		}

		if ( function_exists( 'is_shop' ) && is_shop() ) {
			return true;
		}

		if ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'lvl_neva_apply_shop_archive_filters' ) ) {
	function lvl_neva_apply_shop_archive_filters( $query ) {
		if ( is_admin() || ! $query instanceof WP_Query || ! $query->is_main_query() ) {
			return;
		}

		if ( ! lvl_neva_is_shop_context( $query ) ) {
			return;
		}

		$state = lvl_neva_get_shop_filter_state();

		if ( empty( $state['width'] ) && empty( $state['height'] ) && empty( $state['length'] ) ) {
			return;
		}

		$meta_query = $query->get( 'meta_query' );
		$tax_query  = $query->get( 'tax_query' );

		if ( ! is_array( $meta_query ) ) {
			$meta_query = array();
		}

		if ( ! is_array( $tax_query ) ) {
			$tax_query = array();
		}

		if ( ! empty( $state['width'] ) ) {
			$meta_query[] = array(
				'key'     => '_width',
				'value'   => $state['width'],
				'compare' => 'IN',
			);
		}

		if ( ! empty( $state['height'] ) ) {
			$meta_query[] = array(
				'key'     => '_height',
				'value'   => $state['height'],
				'compare' => 'IN',
			);
		}

		if ( ! empty( $state['length'] ) ) {
			$tax_query[] = array(
				'taxonomy' => 'pa_dlinna',
				'field'    => 'slug',
				'terms'    => $state['length'],
			);
		}

		$query->set( 'meta_query', $meta_query );
		$query->set( 'tax_query', $tax_query );
	}
}
add_action( 'pre_get_posts', 'lvl_neva_apply_shop_archive_filters' );

if ( ! function_exists( 'lvl_neva_filter_woocommerce_pagination_args' ) ) {
	function lvl_neva_filter_woocommerce_pagination_args( $args ) {
		if ( ! lvl_neva_is_shop_context() ) {
			return $args;
		}

		$state    = lvl_neva_get_shop_filter_state();
		$add_args = isset( $args['add_args'] ) && is_array( $args['add_args'] ) ? $args['add_args'] : array();

		if ( ! empty( $state['width'] ) ) {
			$add_args['shop_width'] = implode( ',', $state['width'] );
		}

		if ( ! empty( $state['height'] ) ) {
			$add_args['shop_height'] = implode( ',', $state['height'] );
		}

		if ( ! empty( $state['length'] ) ) {
			$add_args['shop_length'] = implode( ',', $state['length'] );
		}

		$args['add_args'] = $add_args;

		return $args;
	}
}
add_filter( 'woocommerce_pagination_args', 'lvl_neva_filter_woocommerce_pagination_args' );
