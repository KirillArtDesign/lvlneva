<?php
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main class="div main-wrapper">
	<?php while ( have_posts() ) : ?>
		<?php
		the_post();
		$product = wc_get_product( get_the_ID() );
		$gallery = lvl_neva_get_single_product_gallery( $product );
		$rows    = lvl_neva_get_default_product_specs();
		$price   = $product && $product->get_price() ? lvl_neva_format_price( $product->get_price() ) : '2 876₽';
		?>
		<section class="section section-cover" id="ivcca89n0_0">
			<div class="div page-cover_component page-cover--empty" id="im05sdb63_0"></div>
		</section>

		<section class="section section-equipment padding-global" id="iwg68smvj_0" style="padding-bottom:8rem;">
			<div class="div flex-direction-horizontal grid-gap flex-direction-horizontal--is-equipment-page equipment-page-layout-5-7" id="is19dw1j9_0">
				<div class="div equipment-page_slider_component" id="ioqrul9l1_0">
					<div class="div flex-direction-vertical equipment-page_slider_gap sticky sticky-padding" id="iqubkmwvf_0">
						<div class="div equipment-page_slider_preview background-white border-radius" id="ifb6j466j_0">
							<div equipment-slider="preview" class="div swiper" id="i06j0v493_0">
								<div class="div swiper-wrapper flex-direction-horizontal" id="izf9dxyzp_0">
									<?php foreach ( $gallery as $image ) : ?>
										<div class="div swiper-slide">
											<div class="div equipment-page_slider_img-wrapper">
												<div class="image size-full-percentage">
													<img src="<?php echo esc_url( $image['src'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" class="image__img">
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
							<div class="div flex-align-bottom flex-direction-horizontal layer-bottom z-index-top" id="ip0ooszxf_0">
								<div class="div padding-block-medium" id="i4p0t9k7d_0">
									<div class="div flex-direction-vertical" id="irf71f5m8_0">
										<div class="div slider-buttons_component" id="i0mmu9zpp_0">
											<div class="div space-between flex-direction-horizontal" id="iwqjyst4i_0">
												<a href="#" equipment-slider="prev" class="link-block border-radius button-iconic_component text-color-brand background-light-grey" role="button">
													<div class="div flex-center-all" style="padding:1rem;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.0898 6.71289L7.72363 10.999H18.5V12.999H7.72363L12.0898 17.2852L10.6885 18.7129L5.5 13.6182V10.3799L10.6885 5.28516L12.0898 6.71289Z" fill="currentColor"></path></svg></div>
												</a>
												<a href="#" equipment-slider="next" class="link-block border-radius button-iconic_component text-color-brand background-light-grey" role="button">
													<div class="div flex-center-all" style="padding:1rem;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path></svg></div>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="div equipment-page_thumbs" id="i36ut8pcx_0">
							<div class="div flex-direction-horizontal flex-center size-width-auto equipment-page_thumbs-gap" id="i1aoxzzxh_0">
								<?php foreach ( $gallery as $index => $image ) : ?>
									<div class="link-block equipment-page_slider_thumb<?php echo 0 === $index ? ' active' : ''; ?>" data-index="<?php echo esc_attr( $index ); ?>" role="button">
										<div class="image size-full-percentage">
											<img src="<?php echo esc_url( $image['src'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" class="image__img">
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>

				<div class="div flex-direction-vertical grid-gap div--u-iy6idvb8v" id="iy6idvb8v_0">
					<div class="div background-white border-radius equipment-page_title_component" id="ibea6xlo1_0">
						<div class="div size-width-auto padding-block-large padding-block-large--is-equipment-title" id="iymzrx04j_0">
							<div class="div flex-direction-vertical equipment-page_title_gap" id="izq8h9fkr_0">
								<div class="div">
									<h2 page-title="" class="text heading-style-product"><?php the_title(); ?></h2>
									<?php
									get_template_part(
										'template-parts/components/breadcrumbs',
										null,
										array(
											'items' => array(
												array(
													'label' => 'Главная',
													'url'   => home_url( '/' ),
												),
												array(
													'label' => 'Каталог',
													'url'   => lvl_neva_get_shop_url(),
												),
												array(
													'label' => get_the_title(),
												),
											),
										)
									);
									?>
								</div>

								<?php get_template_part( 'template-parts/components/tech-specs', null, array( 'rows' => $rows ) ); ?>

								<form class="div flex-direction-vertical size-width-full product-purchase" method="post" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', get_permalink() ) ); ?>">
									<div class="product-purchase__price"><?php echo esc_html( $price ); ?></div>
									<div class="div flex-direction-vertical size-width-full product-purchase__controls">
										<div class="div flex-direction-horizontal size-width-full product-purchase__lengths" role="radiogroup" aria-label="Выбор длины">
											<?php foreach ( lvl_neva_get_default_sizes() as $size ) : ?>
												<label class="product-purchase__length-option">
													<input class="product-purchase__length-input" type="radio" name="lvl_length" value="<?php echo esc_attr( $size ); ?>">
													<span class="product-purchase__length-btn"><?php echo esc_html( $size ); ?></span>
												</label>
											<?php endforeach; ?>
										</div>

										<div class="div flex-direction-horizontal size-width-full product-purchase__actions">
											<div class="product-purchase__field product-purchase__field--qty" data-qty-control>
												<button class="product-purchase__icon-btn" type="button" aria-label="Уменьшить количество" data-qty-decrease>
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 12H11H12H13H17" stroke="currentColor" stroke-width="2"/></svg>
												</button>
												<input class="product-purchase__qty-input" type="number" min="1" step="1" value="1" inputmode="numeric" aria-label="Количество" data-qty-input name="quantity">
												<button class="product-purchase__icon-btn" type="button" aria-label="Увеличить количество" data-qty-increase>
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 12H11M12 12H11M12 12V11M12 12H13M12 12V13M17 12H13M12 7V11M12 17V13M11 12L12 11M11 12L12 13M12 11L13 12M13 12L12 13" stroke="currentColor" stroke-width="2"/></svg>
												</button>
											</div>

											<div class="product-purchase__select-wrap">
												<select class="product-purchase__field product-purchase__field--service product-purchase__select" name="lvl_service" aria-label="Дополнительная услуга">
													<option value="">Добавить услугу</option>
													<option value="design">Проектирование и расчёт нагрузок</option>
													<option value="manufacturing">Изготовление стропильных систем</option>
													<option value="installation">Монтаж конструкций</option>
												</select>
												<span class="product-purchase__field-icon" aria-hidden="true">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.61245 7.48999L11.1225 11H12H12.8775L16.3875 7.48999" stroke="currentColor" stroke-width="2"/><path d="M7.61245 13L11.1225 16.51H12H12.8775L16.3875 13" stroke="currentColor" stroke-width="2"/></svg>
												</span>
											</div>

											<button class="nav-btn text-style-body product-purchase__submit" type="submit" name="add-to-cart" value="<?php echo esc_attr( get_the_ID() ); ?>">
												<span class="nav-btn__label" data-label="Оставить заявку"><span class="nav-btn__label-text">Оставить заявку</span></span>
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="section">
			<div class="div flex-direction-vertical grid-gap size-width-full art-conteiner">
				<div class="div flex-direction-horizontal size-width-full equipment-article">
					<div class="div flex-direction-vertical size-width-full border-radius equipment-article__card">
						<div class="div flex-direction-horizontal size-width-full equipment-article__top">
							<div class="div flex-direction-vertical size-width-full equipment-article__content">
								<div class="div flex-direction-vertical size-width-full equipment-article__section">
									<?php if ( trim( get_the_content() ) ) : ?>
										<?php the_content(); ?>
									<?php else : ?>
										<div class="equipment-article__text"><?php echo esc_html( $product && $product->get_short_description() ? wp_strip_all_tags( $product->get_short_description() ) : 'Клееный брус ЛВЛ 27×400 мм — современный конструкционный материал, сочетающий малую толщину с высокой прочностью и стабильностью.' ); ?></div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php get_template_part( 'template-parts/sections/suitable-services' ); ?>
			</div>
		</section>

		<?php get_template_part( 'template-parts/sections/latest-news' ); ?>
		<?php get_template_part( 'template-parts/sections/contact-form' ); ?>
	<?php endwhile; ?>
</main>
<?php
get_footer();
