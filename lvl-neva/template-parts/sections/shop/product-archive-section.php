<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shop_pagination_html = '';

if ( function_exists( 'woocommerce_pagination' ) ) {
	ob_start();
	woocommerce_pagination();
	$shop_pagination_html = trim( ob_get_clean() );

	if ( $shop_pagination_html ) {
		$shop_pagination_html = preg_replace(
			'/<nav\b(?![^>]*\bdata-shop-filter-pagination\b)/',
			'<nav data-shop-filter-pagination',
			$shop_pagination_html,
			1
		);
	}
}
?>





<section class="section  section-services-page" id="il0p4zb9d_0">
                        <div class="div padding-global size-height-auto-tablet size-height-full services-page_padding">
                            <div class="div grid-4 services-card_component--height-full grid-4--is-services-layout"
                                id="iuccyujov_0"
                                data-shop-archive>


 <?php get_template_part( 'template-parts/sections/shop/shop-filter-archive' ); ?>

                                <div class="collection collection--u-i2lj9rvhv " data-shop-filter-results>
                                    <div role="list" class="collection__list  grid-1 size-height-full ">
                                        <!-- карточка услуги -->

								

			
					<?php if ( woocommerce_product_loop() ) : ?>
						<?php while ( have_posts() ) : ?>
							<?php the_post(); ?>
							<?php wc_get_template_part( 'content', 'product' ); ?>
						<?php endwhile; ?>
					<?php else : ?>
						<div class="div collection__empty">
							<div class="text">
								<span class="text-block-wrap-div text heading-style-h2 ">Товары пока не добавлены</span>
							</div>
						</div>
					<?php endif; ?>
				

			
                                        
                                    </div>
                                </div>
				<?php echo wp_kses_post( $shop_pagination_html ); ?>
                            </div>
                        </div>
                    </section>
