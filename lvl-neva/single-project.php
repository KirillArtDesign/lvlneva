<?php
get_header();
?>
<main class="div main-wrapper">
	<?php while ( have_posts() ) : ?>
		<?php
		the_post();
		$gallery_images = lvl_neva_get_default_gallery_images();
		if ( has_post_thumbnail() ) {
			$gallery_images[0]['src'] = get_the_post_thumbnail_url( get_the_ID(), 'large' );
			$gallery_images[0]['alt'] = get_the_title();
		}
		?>
		<section section-dark-theme="" class="section section-cover" id="ies2q7q46_0">
			<div class="div page-cover_component flex-direction-vertical" id="i905smb5f_0">
				<div class="div padding-block-large" id="iiyh304i8_0">
					<h1 class="text heading-style-h1 text-color-black heading-style-h1--is-page-cover" id="ijmxwrbg4_0"><?php the_title(); ?></h1>
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
									'label' => 'Наши работы',
									'url'   => lvl_neva_get_archive_url( 'project', '/projects/' ),
								),
								array(
									'label' => get_the_title(),
								),
							),
						)
					);
					?>
				</div>
			</div>
		</section>

		<section class="section section-equipment padding-global" id="iwg68smvj_0" style="padding-bottom:8rem;">
			<div class="div flex-direction-vertical grid-gap size-width-full">
				<div class="div flex-direction-horizontal grid-gap flex-direction-horizontal--is-equipment-page page-layout-3-2" id="is19dw1j9_0">
					<div class="div equipment-page_slider_component" id="ioqrul9l1_0">
						<div class="div flex-direction-vertical equipment-page_slider_gap" id="iqubkmwvf_0">
							<div class="div equipment-page_slider_preview background-white border-radius" id="ifb6j466j_0">
								<div equipment-slider="preview" class="div swiper" id="i06j0v493_0">
									<div class="div swiper-wrapper flex-direction-horizontal" id="izf9dxyzp_0">
										<?php foreach ( $gallery_images as $image ) : ?>
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
									<?php foreach ( $gallery_images as $index => $image ) : ?>
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
						<div class="div background-white border-radius equipment-page_title_component sticky sticky-padding" id="ibea6xlo1_0">
							<div class="div size-width-auto padding-block-large padding-block-large--is-equipment-title" id="iymzrx04j_0">
								<div class="div flex-direction-vertical equipment-page_title_gap" id="izq8h9fkr_0">
									<?php get_template_part( 'template-parts/components/tech-specs', null, array( 'rows' => lvl_neva_get_default_project_specs() ) ); ?>
									<a class="hero-corner-roll-btn hero-corner-roll-btn--brand hero-corner-roll-btn--h100" href="<?php echo esc_url( home_url( '/about/' ) ); ?>">
										<span class="hero-corner-roll-btn__label" data-label="Подробнее о компании">
											<span class="hero-corner-roll-btn__label-text">Подробнее о компании</span>
										</span>
										<span class="hero-corner-roll-btn__icon-slot" aria-hidden="true">
											<span class="hero-corner-roll-btn__icon-roll">
												<svg class="hero-corner-roll-btn__icon hero-corner-roll-btn__icon--default" fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path></svg>
												<svg class="hero-corner-roll-btn__icon hero-corner-roll-btn__icon--hover" fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path></svg>
											</span>
										</span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="div flex-direction-horizontal size-width-full equipment-article">
					<div class="div flex-direction-vertical size-width-full border-radius equipment-article__card">
						<div class="div flex-direction-horizontal size-width-full equipment-article__top">
							<div class="div flex-direction-vertical size-width-full equipment-article__content">
								<div class="div flex-direction-vertical size-width-full equipment-article__section">
									<?php if ( trim( get_the_content() ) ) : ?>
										<?php the_content(); ?>
									<?php else : ?>
										<div class="equipment-article__text">Клееный брус ЛВЛ 27×400 мм — современный конструкционный материал, сочетающий малую толщину с высокой прочностью и стабильностью. Он идеально подходит для усиления каркасных систем, перегородок, межкомнатных конструкций и лёгких перекрытий.</div>
									<?php endif; ?>
								</div>
								<div class="div flex-direction-vertical size-width-full equipment-article__section">
									<div class="equipment-article__title">Производство и особенности.</div>
									<div class="equipment-article__text">ЛВЛ-брус изготавливается из тонких слоёв шпона хвойных пород — сосны и ели. Каждый слой тщательно высушивается до влажности 9–12 % и склеивается под высоким давлением и температурой.</div>
								</div>
								<div class="div flex-direction-vertical size-width-full equipment-article__section">
									<div class="equipment-article__title">Область применения.</div>
									<div class="equipment-article__text">Материал используется для лёгких несущих конструкций, элементов перегородок, кровельных систем и усиления стен.</div>
								</div>
								<img class="equipment-article__image border-radius" src="<?php echo esc_url( lvl_neva_asset_url( 'img/img-02.jpg' ) ); ?>" alt="<?php the_title_attribute(); ?>">
								<div class="div flex-direction-vertical size-width-full equipment-article__quote">
									<div class="equipment-article__quote-text">На заводе сначала древесина очищается от коры и дефектов, затем нарезается на тонкие листы шпона. Эти листы высушивают, обрабатывают клеем и укладывают слоями, после чего прессуют под высоким давлением.</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php get_template_part( 'template-parts/sections/suitable-services' ); ?>
			</div>
		</section>

		<?php get_template_part( 'template-parts/sections/contact-form', null, array( 'button_label' => 'Смотреть весь каталог' ) ); ?>
		<?php get_template_part( 'template-parts/sections/work-cases', null, array( 'exclude' => array( get_the_ID() ) ) ); ?>
		<?php get_template_part( 'template-parts/sections/latest-news' ); ?>
	<?php endwhile; ?>
</main>
<?php
get_footer();
