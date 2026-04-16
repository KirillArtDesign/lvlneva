<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shop_current_page    = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
$shop_total_pages     = isset( $GLOBALS['wp_query']->max_num_pages ) ? (int) $GLOBALS['wp_query']->max_num_pages : 1;
$shop_next_page_url   = $shop_current_page < $shop_total_pages ? get_pagenum_link( $shop_current_page + 1 ) : '';
$shop_pagination_html = function_exists( 'lvl_neva_render_listing_pagination' )
	? lvl_neva_render_listing_pagination( $shop_current_page, $shop_total_pages )
	: '';
?>





<section class="section  section-services-page">
                        <div class="div padding-global size-height-auto-tablet size-height-full services-page_padding">
                            <div class="div grid-4 services-card_component--height-full grid-4--is-services-layout"
                               
                                data-shop-archive
								data-current-page="<?php echo esc_attr( $shop_current_page ); ?>"
								data-next-page-url="<?php echo esc_url( $shop_next_page_url ); ?>">


 <?php get_template_part( 'template-parts/sections/shop/shop-filter-archive' ); ?>

                                <div class="collection collection--u-i2lj9rvhv " data-shop-filter-results>
                                    <div role="list" class="collection__list  grid-1 size-height-full " data-shop-list-items>
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
									<?php if ( 1 === $shop_current_page && $shop_next_page_url ) : ?>
										<noscript>
											<div class="collection__pagination">
												<a href="<?php echo esc_url( $shop_next_page_url ); ?>" class="collection__pagination-button-load">
													<span class="collection__pagination-pages-text">
														<span class="text-block-wrap-div">Следующая страница</span>
													</span>
												</a>
											</div>
										</noscript>
									<?php endif; ?>
									<div data-shop-list-sentinel style="height: 1px;" aria-hidden="true"></div>
                                </div>
								<div data-shop-filter-pagination>
									<?php echo $shop_pagination_html; ?>
								</div>
                            </div>
                        </div>
                    </section>
