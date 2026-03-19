<?php
get_header();
?>
<main class="div main-wrapper">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<section class="section section-cover" id="service-cover">
			<div class="div page-cover_component flex-direction-vertical service-hero__cover">
				<div class="div layer-center">
					<div class="image size-full-percentage">
						<img src="<?php echo esc_url( lvl_neva_asset_url( 'img/servicebg.png' ) ); ?>" alt="<?php the_title_attribute(); ?>" class="image__img">
					</div>
				</div>
				<div class="div page-cover_service-content service-hero__content">
					<div class="div size-height-full flex-align-bottom flex-direction-horizontal service-hero__content-row">
						<div class="div padding-block-large service-hero__inner">
							<div class="div flex-direction-vertical service-hero__top">
								<h1 class="text heading-style-h1 text-color-white heading-style-h1--is-page-cover"><?php the_title(); ?></h1>
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
												'label' => 'Услуги',
												'url'   => lvl_neva_get_archive_url( 'service', '/services/' ),
											),
											array(
												'label' => get_the_title(),
											),
										),
									)
								);
								?>
							</div>
							<div class="div flex-direction-horizontal service-hero__bottom">
								<div class="div flex-direction-vertical size-width-full equipment-article__section service-hero__text-wrap">
									<div class="equipment-article__text text-color-white"><?php echo esc_html( get_the_excerpt() ?: 'Клееный брус ЛВЛ 27×400 мм — современный конструкционный материал, сочетающий малую толщину с высокой прочностью и стабильностью. Он идеально подходит для усиления каркасных систем, перегородок, межкомнатных конструкций и лёгких перекрытий.' ); ?></div>
								</div>
								<a class="button-large_component hero-corner-roll-btn hero-corner-roll-btn--white-brand-hover hero-corner-roll-btn--h100" href="#contact-form">
									<span class="hero-corner-roll-btn__label" data-label="Оставить заявку">
										<span class="hero-corner-roll-btn__label-text">Оставить заявку</span>
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
										<div class="equipment-article__text">Клееный брус ЛВЛ 27×400 мм — современный конструкционный материал, сочетающий малую толщину с высокой прочностью и стабильностью. Он идеально подходит для усиления каркасных систем, перегородок, межкомнатных конструкций и лёгких перекрытий.</div>
									<?php endif; ?>
								</div>
								<div class="div flex-direction-vertical size-width-full video-player-block" data-video-type="iframe" data-video-src="https://www.youtube.com/embed/KxWYFDR0oiA?si=EBeuvkyXt1-cOZgQ">
									<div class="div video-player-block__frame border-radius">
										<div class="image size-full-percentage video-player-block__preview-wrap"><img src="<?php echo esc_url( lvl_neva_asset_url( 'img/serv.jpg' ) ); ?>" alt="" class="image__img video-player-block__preview"></div>
										<button type="button" class="video-player-block__play border-radius" aria-label="Воспроизвести видео"><svg width="2.4rem" height="2.4rem" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.4473 11.1055V12.8945L8.44727 17.8945L7 17V7L8.44727 6.10547L18.4473 11.1055Z" stroke="var(--Primary, #31572C)" stroke-width="2" stroke-linejoin="bevel"/></svg></button>
										<div class="video-player-block__embed-wrap"></div>
									</div>
								</div>
								<div class="div flex-direction-vertical size-width-full equipment-article__section">
									<div class="equipment-article__title">Производство и особенности.</div>
									<div class="equipment-article__text">ЛВЛ-брус изготавливается из тонких слоёв шпона хвойных пород — сосны и ели. Каждый слой тщательно высушивается до влажности 9–12 % и склеивается под высоким давлением и температурой.</div>
								</div>
								<div class="div flex-direction-vertical size-width-full equipment-article__section">
									<div class="equipment-article__title">Область применения.</div>
									<div class="equipment-article__text">Брус используется для лёгких несущих конструкций, элементов перегородок, кровельных систем и усиления стен. Он востребован в строительстве жилых домов, ангаров, складов и каркасных сооружений.</div>
								</div>
								<img class="equipment-article__image border-radius" src="<?php echo esc_url( lvl_neva_asset_url( 'img/img-02.jpg' ) ); ?>" alt="<?php the_title_attribute(); ?>">
								<div class="div flex-direction-vertical size-width-full equipment-article__quote">
									<div class="equipment-article__quote-text">На заводе сначала древесина очищается от коры и дефектов, затем нарезается на тонкие листы шпона. Эти листы высушивают, обрабатывают клеем и укладывают слоями, после чего прессуют под высоким давлением.</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php get_template_part( 'template-parts/sections/suitable-services', null, array( 'exclude' => array( get_the_ID() ) ) ); ?>
			</div>
		</section>

		<?php get_template_part( 'template-parts/sections/work-cases' ); ?>
		<?php get_template_part( 'template-parts/sections/catalog-slider' ); ?>
		<?php get_template_part( 'template-parts/sections/latest-news' ); ?>
		<div id="contact-form"><?php get_template_part( 'template-parts/sections/contact-form' ); ?></div>
	<?php endwhile; ?>
</main>
<?php
get_footer();
