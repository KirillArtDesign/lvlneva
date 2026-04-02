<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'lvl_neva_get_listing_pagination_items' ) ) {
	function lvl_neva_get_listing_pagination_items( $current_page, $total_pages, $end_size = 1, $mid_size = 1 ) {
		$current_page = max( 1, (int) $current_page );
		$total_pages  = max( 1, (int) $total_pages );
		$end_size     = max( 1, (int) $end_size );
		$mid_size     = max( 0, (int) $mid_size );

		if ( $total_pages < 2 ) {
			return array();
		}

		$pages = array( 1, $total_pages );

		for ( $page = 1; $page <= $end_size; $page++ ) {
			$pages[] = $page;
			$pages[] = $total_pages - $page + 1;
		}

		for ( $page = $current_page - $mid_size; $page <= $current_page + $mid_size; $page++ ) {
			$pages[] = $page;
		}

		$pages = array_values(
			array_unique(
				array_filter(
					array_map( 'intval', $pages ),
					static function ( $page ) use ( $total_pages ) {
						return $page >= 1 && $page <= $total_pages;
					}
				)
			)
		);

		sort( $pages );

		$items     = array();
		$last_page = 0;

		foreach ( $pages as $page ) {
			if ( $last_page && $page - $last_page > 1 ) {
				$items[] = array(
					'type' => 'dots',
				);
			}

			$items[] = array(
				'type'       => 'page',
				'page'       => $page,
				'is_current' => $page === $current_page,
			);

			$last_page = $page;
		}

		return $items;
	}
}

if ( ! function_exists( 'lvl_neva_render_listing_pagination_arrow' ) ) {
	function lvl_neva_render_listing_pagination_arrow( $direction, $url ) {
		$direction = 'prev' === $direction ? 'prev' : 'next';
		$label     = 'prev' === $direction ? __( 'Предыдущая страница', 'lvl-neva' ) : __( 'Следующая страница', 'lvl-neva' );
		?>
		<a
			href="<?php echo esc_url( $url ); ?>"
			button-iconic-hover-animation
			class="link-block border-radius button-iconic_component text-color-brand background-light-grey lvl-neva-list-pagination__arrow lvl-neva-list-pagination__arrow--<?php echo esc_attr( $direction ); ?>"
			aria-label="<?php echo esc_attr( $label ); ?>"
		>
			<div class="div flex-direction-vertical">
				<div class="div clip-content border-radius button-iconic__top background-brand text-color-white">
					<div class="div size-full-percentage flex-center-all">
						<div class="embed icon_component flex-center-all opacity lvl-neva-list-pagination__arrow-icon" aria-hidden="true">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
							</svg>
						</div>
					</div>
				</div>
				<div class="div button-iconic__bottom">
					<div class="div size-full-percentage flex-center-all">
						<div class="embed icon_component flex-center-all lvl-neva-list-pagination__arrow-icon" aria-hidden="true">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
							</svg>
						</div>
					</div>
				</div>
			</div>
		</a>
		<?php
	}
}

if ( ! function_exists( 'lvl_neva_render_listing_pagination' ) ) {
	function lvl_neva_render_listing_pagination( $current_page, $total_pages ) {
		$current_page = max( 1, (int) $current_page );
		$total_pages  = max( 1, (int) $total_pages );

		if ( $total_pages < 2 || $current_page < 2 ) {
			return '';
		}

		$items    = lvl_neva_get_listing_pagination_items( $current_page, $total_pages );
		$prev_url = $current_page > 1 ? get_pagenum_link( $current_page - 1 ) : '';
		$next_url = $current_page < $total_pages ? get_pagenum_link( $current_page + 1 ) : '';

		ob_start();
		?>
		<nav class="collection__pagination lvl-neva-list-pagination" aria-label="<?php esc_attr_e( 'Пагинация', 'lvl-neva' ); ?>">
			<div class="div flex-direction-horizontal lvl-neva-list-pagination__inner">
				<?php if ( $prev_url ) : ?>
					<?php lvl_neva_render_listing_pagination_arrow( 'prev', $prev_url ); ?>
				<?php endif; ?>

				<div class="div flex-direction-horizontal product-purchase__lengths lvl-neva-list-pagination__pages">
					<?php foreach ( $items as $item ) : ?>
						<?php if ( 'dots' === $item['type'] ) : ?>
							<span class="lvl-neva-list-pagination__dots text-style-body text-color-grey" aria-hidden="true">...</span>
							<?php continue; ?>
						<?php endif; ?>

						<?php if ( ! empty( $item['is_current'] ) ) : ?>
							<span class="product-purchase__length-option">
								<span class="product-purchase__length-btn is-active lvl-neva-list-pagination__page-btn">
									<span class="lvl-neva-list-pagination__page-label" data-label="<?php echo esc_attr( $item['page'] ); ?>">
										<span class="lvl-neva-list-pagination__page-label-text"><?php echo esc_html( $item['page'] ); ?></span>
									</span>
								</span>
							</span>
						<?php else : ?>
							<a href="<?php echo esc_url( get_pagenum_link( $item['page'] ) ); ?>" class="product-purchase__length-option lvl-neva-list-pagination__page-link" aria-label="<?php echo esc_attr( sprintf( __( 'Страница %d', 'lvl-neva' ), $item['page'] ) ); ?>">
								<span class="product-purchase__length-btn lvl-neva-list-pagination__page-btn">
									<span class="lvl-neva-list-pagination__page-label" data-label="<?php echo esc_attr( $item['page'] ); ?>">
										<span class="lvl-neva-list-pagination__page-label-text"><?php echo esc_html( $item['page'] ); ?></span>
									</span>
								</span>
							</a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>

				<?php if ( $next_url ) : ?>
					<?php lvl_neva_render_listing_pagination_arrow( 'next', $next_url ); ?>
				<?php endif; ?>
			</div>
		</nav>
		<?php

		return trim( ob_get_clean() );
	}
}
