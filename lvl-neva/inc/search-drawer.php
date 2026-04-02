<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'lvl_neva_get_search_drawer_post_types' ) ) {
	function lvl_neva_get_search_drawer_post_types() {
		return array(
			'post'      => array(
				'label' => __( 'Блог', 'lvl-neva' ),
			),
			'portfolio' => array(
				'label' => __( 'Портфолио', 'lvl-neva' ),
			),
			'services'  => array(
				'label' => __( 'Услуги', 'lvl-neva' ),
			),
			'product'   => array(
				'label' => __( 'Продукты', 'lvl-neva' ),
			),
		);
	}
}

if ( ! function_exists( 'lvl_neva_get_search_drawer_empty_markup' ) ) {
	function lvl_neva_get_search_drawer_empty_markup( $message = '' ) {
		if ( '' === $message ) {
			$message = __( 'Начните вводить запрос', 'lvl-neva' );
		}

		ob_start();
		?>
		<div class="site-search-drawer__empty">
			<div class="site-search-drawer__empty-text"><?php echo esc_html( $message ); ?></div>
		</div>
		<?php

		return (string) ob_get_clean();
	}
}

if ( ! function_exists( 'lvl_neva_render_search_drawer_results_markup' ) ) {
	function lvl_neva_render_search_drawer_results_markup( $search_query ) {
		$search_query = trim( sanitize_text_field( (string) $search_query ) );

		if ( '' === $search_query ) {
			return lvl_neva_get_search_drawer_empty_markup();
		}

		$post_type_map = lvl_neva_get_search_drawer_post_types();
		$has_results   = false;

		ob_start();

		foreach ( $post_type_map as $post_type => $post_type_config ) {
			$results_query = new WP_Query(
				array(
					'post_type'           => $post_type,
					'post_status'         => 'publish',
					'posts_per_page'      => 5,
					'ignore_sticky_posts' => true,
					'no_found_rows'       => true,
					's'                   => $search_query,
				)
			);

			if ( ! $results_query->have_posts() ) {
				wp_reset_postdata();
				continue;
			}

			$has_results = true;
			?>
			<div class="site-search-drawer__group">
				<div class="site-search-drawer__group-title">
					<?php echo esc_html( $post_type_config['label'] ); ?>
				</div>

				<div class="site-search-drawer__group-list">
					<?php while ( $results_query->have_posts() ) : ?>
						<?php
						$results_query->the_post();
						$result_permalink = get_permalink();
						$result_title     = get_the_title();
						?>
						<a class="site-search-drawer__result link-block" href="<?php echo esc_url( $result_permalink ); ?>">
							<span class="site-search-drawer__result-title"><?php echo esc_html( $result_title ); ?></span>
							<span class="site-search-drawer__result-arrow" aria-hidden="true">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
								</svg>
							</span>
						</a>
					<?php endwhile; ?>
				</div>
			</div>
			<?php

			wp_reset_postdata();
		}

		if ( ! $has_results ) {
			echo lvl_neva_get_search_drawer_empty_markup( __( 'Ничего не найдено', 'lvl-neva' ) );
		}

		return (string) ob_get_clean();
	}
}

if ( ! function_exists( 'lvl_neva_handle_search_drawer_ajax' ) ) {
	function lvl_neva_handle_search_drawer_ajax() {
		check_ajax_referer( 'lvl_neva_search_drawer', 'nonce' );

		$search_query = isset( $_POST['query'] ) ? wp_unslash( $_POST['query'] ) : '';

		wp_send_json_success(
			array(
				'html' => lvl_neva_render_search_drawer_results_markup( $search_query ),
			)
		);
	}
}
add_action( 'wp_ajax_lvl_neva_search_drawer', 'lvl_neva_handle_search_drawer_ajax' );
add_action( 'wp_ajax_nopriv_lvl_neva_search_drawer', 'lvl_neva_handle_search_drawer_ajax' );
