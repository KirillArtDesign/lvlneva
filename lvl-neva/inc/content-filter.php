<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'lvl_neva_get_content_filter_current_term' ) ) {
	function lvl_neva_get_content_filter_current_term( $taxonomy ) {
		$requested_term_id = function_exists( 'lvl_neva_get_requested_content_filter_term_id' )
			? lvl_neva_get_requested_content_filter_term_id( $taxonomy )
			: 0;

		if ( $requested_term_id > 0 ) {
			$term = get_term( $requested_term_id, $taxonomy );

			if ( $term instanceof WP_Term ) {
				return $term->slug;
			}
		}

		if ( 'category' === $taxonomy && is_category() ) {
			$term = get_queried_object();

			if ( $term instanceof WP_Term ) {
				return $term->slug;
			}
		}

		if ( is_tax( $taxonomy ) ) {
			$term = get_queried_object();

			if ( $term instanceof WP_Term ) {
				return $term->slug;
			}
		}

		return 'all';
	}
}

if ( ! function_exists( 'lvl_neva_get_requested_content_filter_term_id' ) ) {
	function lvl_neva_get_requested_content_filter_term_id( $taxonomy ) {
		if ( ! taxonomy_exists( $taxonomy ) ) {
			return 0;
		}

		$requested_term_id = isset( $_GET['content_filter_term'] ) ? absint( wp_unslash( $_GET['content_filter_term'] ) ) : 0;

		if ( $requested_term_id < 1 ) {
			return 0;
		}

		$term = get_term( $requested_term_id, $taxonomy );

		if ( is_wp_error( $term ) || ! $term instanceof WP_Term ) {
			return 0;
		}

		return (int) $term->term_id;
	}
}

if ( ! function_exists( 'lvl_neva_get_content_filter_current_term_id' ) ) {
	function lvl_neva_get_content_filter_current_term_id( $taxonomy ) {
		$requested_term_id = lvl_neva_get_requested_content_filter_term_id( $taxonomy );

		if ( $requested_term_id > 0 ) {
			return $requested_term_id;
		}

		if ( 'category' === $taxonomy && is_category() ) {
			$term = get_queried_object();

			if ( $term instanceof WP_Term ) {
				return (int) $term->term_id;
			}
		}

		if ( is_tax( $taxonomy ) ) {
			$term = get_queried_object();

			if ( $term instanceof WP_Term ) {
				return (int) $term->term_id;
			}
		}

		return 0;
	}
}

if ( ! function_exists( 'lvl_neva_get_content_filter_current_page' ) ) {
	function lvl_neva_get_content_filter_current_page() {
		return max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
	}
}

if ( ! function_exists( 'lvl_neva_get_content_filter_pagination_args' ) ) {
	function lvl_neva_get_content_filter_pagination_args( $term_id = 0 ) {
		$term_id = absint( $term_id );

		if ( $term_id < 1 ) {
			return array();
		}

		return array(
			'content_filter_term' => $term_id,
		);
	}
}

if ( ! function_exists( 'lvl_neva_get_content_filter_config' ) ) {
	function lvl_neva_get_content_filter_config( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'post_type'      => '',
				'taxonomy'       => '',
				'posts_per_page' => 0,
			)
		);

		$post_type = sanitize_key( $args['post_type'] );
		$taxonomy  = sanitize_key( $args['taxonomy'] );

		if ( ! $post_type ) {
			if ( is_post_type_archive( 'portfolio' ) || is_tax( 'project-type' ) ) {
				$post_type = 'portfolio';
			} else {
				$post_type = 'post';
			}
		}

		if ( ! $taxonomy ) {
			$taxonomy = 'portfolio' === $post_type ? 'project-type' : 'category';
		}

		if ( ! post_type_exists( $post_type ) || ! taxonomy_exists( $taxonomy ) || ! is_object_in_taxonomy( $post_type, $taxonomy ) ) {
			return array();
		}

		$posts_per_page = absint( $args['posts_per_page'] );

		if ( $posts_per_page < 1 ) {
			$posts_per_page = (int) get_option( 'posts_per_page' );
		}

		if ( $posts_per_page < 1 ) {
			$posts_per_page = 12;
		}

		$current_term    = lvl_neva_get_content_filter_current_term( $taxonomy );
		$current_term_id = lvl_neva_get_content_filter_current_term_id( $taxonomy );
		$terms        = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => true,
				'orderby'    => 'name',
				'order'      => 'ASC',
			)
		);

		if ( is_wp_error( $terms ) ) {
			$terms = array();
		}

		$terms = array_values(
			array_filter(
				$terms,
				static function ( $term ) use ( $taxonomy, $post_type ) {
					if ( ! $term instanceof WP_Term ) {
						return false;
					}

					return lvl_neva_term_has_posts( $taxonomy, $term->term_id, $post_type );
				}
			)
		);

		$valid_slugs = wp_list_pluck( $terms, 'slug' );
		$valid_ids   = array_map( 'intval', wp_list_pluck( $terms, 'term_id' ) );

		if ( 'all' !== $current_term && ! in_array( $current_term, $valid_slugs, true ) ) {
			$current_term = 'all';
		}

		if ( $current_term_id > 0 && ! in_array( $current_term_id, $valid_ids, true ) ) {
			$current_term_id = 0;
		}

		return array(
			'post_type'          => $post_type,
			'taxonomy'           => $taxonomy,
			'posts_per_page'     => $posts_per_page,
			'terms'              => $terms,
			'current_term'       => $current_term,
			'current_term_id'    => $current_term_id,
			'input_name'         => 'content-tag-' . $post_type,
			'card_template'      => 'portfolio' === $post_type ? 'template-parts/cards/portfolio-card' : 'template-parts/cards/blog-card',
			'collection_classes' => 'portfolio' === $post_type ? 'grid-2 grid-gap grid-3--is-news-page' : 'grid-3 grid-gap grid-3--is-news-page',
		);
	}
}

if ( ! function_exists( 'lvl_neva_term_has_posts' ) ) {
	function lvl_neva_term_has_posts( $taxonomy, $term_id, $post_type ) {
		$term_query = new WP_Query(
			array(
				'post_type'           => $post_type,
				'post_status'         => 'publish',
				'posts_per_page'      => 1,
				'ignore_sticky_posts' => true,
				'fields'              => 'ids',
				'no_found_rows'       => true,
				'tax_query'           => array(
					array(
						'taxonomy' => $taxonomy,
						'field'    => 'term_id',
						'terms'    => (int) $term_id,
					),
				),
			)
		);

		$has_posts = $term_query->have_posts();
		wp_reset_postdata();

		return $has_posts;
	}
}

if ( ! function_exists( 'lvl_neva_get_content_filter_query' ) ) {
	function lvl_neva_get_content_filter_query( $config, $term_id = 0, $paged = 1 ) {
		$query_args = array(
			'post_type'           => $config['post_type'],
			'post_status'         => 'publish',
			'posts_per_page'      => (int) $config['posts_per_page'],
			'paged'               => max( 1, (int) $paged ),
			'ignore_sticky_posts' => 'post' === $config['post_type'],
			'orderby'             => 'date',
			'order'               => 'DESC',
		);

		if ( $term_id > 0 ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => $config['taxonomy'],
					'field'    => 'term_id',
					'terms'    => $term_id,
				),
			);
		}

		return new WP_Query( $query_args );
	}
}

if ( ! function_exists( 'lvl_neva_get_content_filter_results_html' ) ) {
	function lvl_neva_get_content_filter_results_html( $config, $term_id = 0, $page = 1 ) {
		$page         = max( 1, (int) $page );
		$term_id      = absint( $term_id );
		$filter_query = lvl_neva_get_content_filter_query( $config, $term_id, $page );
		$total_pages  = (int) $filter_query->max_num_pages;
		$next_page_url = $page < $total_pages
			? lvl_neva_get_listing_page_url( $page + 1, lvl_neva_get_content_filter_pagination_args( $term_id ) )
			: '';

		ob_start();
		?>
		<div
			class="div collection"
			data-content-filter-results
			data-blog-list
			data-post-type="<?php echo esc_attr( $config['post_type'] ); ?>"
			data-taxonomy="<?php echo esc_attr( $config['taxonomy'] ); ?>"
			data-posts-per-page="<?php echo esc_attr( (int) $config['posts_per_page'] ); ?>"
			data-current-term-id="<?php echo esc_attr( $term_id ); ?>"
			data-current-page="<?php echo esc_attr( $page ); ?>"
			data-next-page-url="<?php echo esc_url( $next_page_url ); ?>"
		>
			<div role="list" class="div collection__list <?php echo esc_attr( $config['collection_classes'] ); ?>" data-blog-list-items>
				<?php if ( $filter_query->have_posts() ) : ?>
					<?php while ( $filter_query->have_posts() ) : ?>
						<?php
						$filter_query->the_post();
						get_template_part(
							$config['card_template'],
							null,
							array(
								'post' => get_post(),
							)
						);
						?>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>

			<div data-blog-list-pagination>
				<?php
				echo lvl_neva_render_listing_pagination(
					$page,
					$total_pages,
					lvl_neva_get_content_filter_pagination_args( $term_id )
				);
				?>
			</div>

			<?php if ( 1 === $page && $next_page_url ) : ?>
				<noscript>
					<div class="collection__pagination">
						<a href="<?php echo esc_url( $next_page_url ); ?>" class="collection__pagination-button-load">
							<span class="collection__pagination-pages-text">
								<span class="text-block-wrap-div">Следующая страница</span>
							</span>
						</a>
					</div>
				</noscript>
			<?php endif; ?>

			<div data-blog-list-sentinel style="height: 1px;" aria-hidden="true"></div>
		</div>
		<?php
		wp_reset_postdata();

		return ob_get_clean();
	}
}

if ( ! function_exists( 'lvl_neva_handle_content_filter_ajax' ) ) {
	function lvl_neva_handle_content_filter_ajax() {
		check_ajax_referer( 'lvl_neva_content_filter', 'nonce' );

		$post_type      = isset( $_POST['post_type'] ) ? sanitize_key( wp_unslash( $_POST['post_type'] ) ) : '';
		$taxonomy       = isset( $_POST['taxonomy'] ) ? sanitize_key( wp_unslash( $_POST['taxonomy'] ) ) : '';
		$term_id        = isset( $_POST['term'] ) ? absint( wp_unslash( $_POST['term'] ) ) : 0;
		$page           = isset( $_POST['page'] ) ? max( 1, absint( wp_unslash( $_POST['page'] ) ) ) : 1;
		$posts_per_page = isset( $_POST['posts_per_page'] ) ? absint( wp_unslash( $_POST['posts_per_page'] ) ) : 0;
		$config         = lvl_neva_get_content_filter_config(
			array(
				'post_type'      => $post_type,
				'taxonomy'       => $taxonomy,
				'posts_per_page' => $posts_per_page,
			)
		);

		if ( empty( $config ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Некорректные параметры фильтра.', 'lvl-neva' ),
				),
				400
			);
		}

		wp_send_json_success(
			array(
				'html' => lvl_neva_get_content_filter_results_html( $config, $term_id, $page ),
			)
		);
	}
}
add_action( 'wp_ajax_lvl_neva_filter_content', 'lvl_neva_handle_content_filter_ajax' );
add_action( 'wp_ajax_nopriv_lvl_neva_filter_content', 'lvl_neva_handle_content_filter_ajax' );
