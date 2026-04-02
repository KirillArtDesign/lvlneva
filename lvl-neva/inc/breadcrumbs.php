<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'lvl_neva_get_context_title' ) ) {
	function lvl_neva_get_context_title() {
		if ( is_home() && ! is_front_page() ) {
			$posts_page_id = (int) get_option( 'page_for_posts' );

			return $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Блог', 'lvl-neva' );
		}

		if ( is_singular() ) {
			return get_the_title( get_queried_object_id() );
		}

		if ( is_post_type_archive() ) {
			return post_type_archive_title( '', false );
		}

		if ( is_category() || is_tag() || is_tax() ) {
			return single_term_title( '', false );
		}

		if ( is_author() ) {
			$author = get_queried_object();

			if ( $author instanceof WP_User ) {
				return $author->display_name;
			}
		}

		if ( is_search() ) {
			return sprintf(
				/* translators: %s: search query. */
				__( 'Результаты поиска: %s', 'lvl-neva' ),
				get_search_query()
			);
		}

		if ( is_404() ) {
			return __( 'Страница не найдена', 'lvl-neva' );
		}

		return wp_strip_all_tags( get_the_archive_title() );
	}
}

if ( ! function_exists( 'lvl_neva_get_archive_page_for_post_type' ) ) {
	function lvl_neva_get_archive_page_for_post_type( $post_type ) {
		$template_map = array(
			'services'  => 'servises-archive.php',
			'portfolio' => 'portfolio-archive.php',
		);

		if ( empty( $template_map[ $post_type ] ) ) {
			return 0;
		}

		$archive_pages = get_posts(
			array(
				'post_type'      => 'page',
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'meta_key'       => '_wp_page_template',
				'meta_value'     => $template_map[ $post_type ],
			)
		);

		return ! empty( $archive_pages ) ? (int) $archive_pages[0] : 0;
	}
}

if ( ! function_exists( 'lvl_neva_get_breadcrumb_items' ) ) {
	function lvl_neva_get_breadcrumb_items() {
		$items = array(
			array(
				'label' => __( 'Главная', 'lvl-neva' ),
				'url'   => home_url( '/' ),
			),
		);

		if ( is_front_page() ) {
			return $items;
		}

		if ( is_home() && ! is_front_page() ) {
			$posts_page_id = (int) get_option( 'page_for_posts' );

			$items[] = array(
				'label'   => $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Блог', 'lvl-neva' ),
				'current' => true,
			);

			return $items;
		}

		if ( is_page() ) {
			$page_id   = get_queried_object_id();
			$ancestors = array_reverse( get_post_ancestors( $page_id ) );

			foreach ( $ancestors as $ancestor_id ) {
				$items[] = array(
					'label' => get_the_title( $ancestor_id ),
					'url'   => get_permalink( $ancestor_id ),
				);
			}

			$items[] = array(
				'label'   => get_the_title( $page_id ),
				'current' => true,
			);

			return $items;
		}

		if ( is_singular() ) {
			$post      = get_queried_object();
			$post_type = get_post_type( $post );

			if ( ! $post instanceof WP_Post || ! $post_type ) {
				return $items;
			}

			if ( 'post' === $post_type ) {
				$posts_page_id = (int) get_option( 'page_for_posts' );

				if ( $posts_page_id ) {
					$items[] = array(
						'label' => get_the_title( $posts_page_id ),
						'url'   => get_permalink( $posts_page_id ),
					);
				}
			} elseif ( 'product' === $post_type ) {
				$shop_page_id = function_exists( 'wc_get_page_id' ) ? (int) wc_get_page_id( 'shop' ) : 0;
				$shop_label   = $shop_page_id ? get_the_title( $shop_page_id ) : __( 'Каталог', 'lvl-neva' );
				$shop_url     = function_exists( 'lvl_neva_get_shop_archive_url' ) ? lvl_neva_get_shop_archive_url() : '';

				if ( $shop_url ) {
					$items[] = array(
						'label' => $shop_label,
						'url'   => $shop_url,
					);
				}
			} else {
				$post_type_object = get_post_type_object( $post_type );

				if ( $post_type_object && $post_type_object->has_archive ) {
					$items[] = array(
						'label' => $post_type_object->labels->name,
						'url'   => get_post_type_archive_link( $post_type ),
					);
				} else {
					$archive_page_id = lvl_neva_get_archive_page_for_post_type( $post_type );

					if ( $archive_page_id ) {
						$items[] = array(
							'label' => get_the_title( $archive_page_id ),
							'url'   => get_permalink( $archive_page_id ),
						);
					}
				}

				if ( is_post_type_hierarchical( $post_type ) ) {
					$ancestors = array_reverse( get_post_ancestors( $post->ID ) );

					foreach ( $ancestors as $ancestor_id ) {
						$items[] = array(
							'label' => get_the_title( $ancestor_id ),
							'url'   => get_permalink( $ancestor_id ),
						);
					}
				}
			}

			$items[] = array(
				'label'   => get_the_title( $post->ID ),
				'current' => true,
			);

			return $items;
		}

		if ( is_post_type_archive() ) {
			$items[] = array(
				'label'   => post_type_archive_title( '', false ),
				'current' => true,
			);

			return $items;
		}

		if ( is_category() || is_tag() || is_tax() ) {
			$term = get_queried_object();

			if ( $term instanceof WP_Term ) {
				if ( in_array( $term->taxonomy, array( 'category', 'post_tag' ), true ) ) {
					$posts_page_id = (int) get_option( 'page_for_posts' );

					if ( $posts_page_id ) {
						$items[] = array(
							'label' => get_the_title( $posts_page_id ),
							'url'   => get_permalink( $posts_page_id ),
						);
					}
				}

				$items[] = array(
					'label'   => $term->name,
					'current' => true,
				);
			}

			return $items;
		}

		if ( is_author() || is_date() ) {
			$posts_page_id = (int) get_option( 'page_for_posts' );

			if ( $posts_page_id ) {
				$items[] = array(
					'label' => get_the_title( $posts_page_id ),
					'url'   => get_permalink( $posts_page_id ),
				);
			}

			$items[] = array(
				'label'   => lvl_neva_get_context_title(),
				'current' => true,
			);

			return $items;
		}

		if ( is_search() || is_404() ) {
			$items[] = array(
				'label'   => lvl_neva_get_context_title(),
				'current' => true,
			);

			return $items;
		}

		$items[] = array(
			'label'   => lvl_neva_get_context_title(),
			'current' => true,
		);

		return $items;
	}
}

if ( ! function_exists( 'lvl_neva_render_breadcrumbs' ) ) {
	function lvl_neva_render_breadcrumbs() {
		$items = lvl_neva_get_breadcrumb_items();

		if ( empty( $items ) ) {
			return;
		}
		?>
		<nav class="breadcrumbs" aria-label="<?php esc_attr_e( 'Хлебные крошки', 'lvl-neva' ); ?>">
			<ul class="div flex-direction-horizontal" style="gap:6px; align-items:center;list-style-type: none;padding-left: 0;">
				<?php foreach ( $items as $index => $item ) : ?>
					<li>
						<?php if ( ! empty( $item['url'] ) && empty( $item['current'] ) ) : ?>
							<a href="<?php echo esc_url( $item['url'] ); ?>" class="text text-style-body text-color-grey">
								<span class="text-block-wrap-div"><?php echo esc_html( $item['label'] ); ?></span>
							</a>
						<?php else : ?>
							<span class="text text-style-body"<?php echo ! empty( $item['current'] ) ? ' aria-current="page"' : ''; ?>>
								<span class="text-block-wrap-div"><?php echo esc_html( $item['label'] ); ?></span>
							</span>
						<?php endif; ?>
					</li>

					<?php if ( $index < count( $items ) - 1 ) : ?>
						<li class="text text-style-body text-color-grey" aria-hidden="true">/</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</nav>
		<?php
	}
}
