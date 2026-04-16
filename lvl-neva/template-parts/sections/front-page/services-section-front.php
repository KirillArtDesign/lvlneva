<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$services_block_title      = get_field( 'services_zagolovok' );
$services_block_items      = get_field( 'services_uslugi_v_bloke' );
$services_block_image      = get_field( 'services_izobrazhenie_v_bloke' );
$services_archive_url      = function_exists( 'lvl_neva_get_archive_url_for_post_type' ) ? lvl_neva_get_archive_url_for_post_type( 'services' ) : home_url( '/' );
$allowed_title_html_tags = array(
	'br' => array(),
);
$services_block_title_plain = wp_strip_all_tags( (string) $services_block_title );
?>

<section class="section section-services" data-services-section="">
	<div class="div flex-direction-vertical section-services_cover sticky size-full-screen"
	>
		<div class="div layer-center">
			<?php if ( ! empty( $services_block_image ) ) : ?>
				<div class="image size-full-percentage show-on-desktop image--u-iqo9h72e9"
					data-services-image=""
				 style="width: 100%; height: 100%">
					<img alt="<?php echo esc_attr( $services_block_image['alt'] ); ?>" class="image__img"
						data-origin-src="<?php echo esc_url( $services_block_image['url'] ); ?>"
						data-size="<?php echo esc_attr( $services_block_image['width'] . 'x' . $services_block_image['height'] ); ?>"
					 src="<?php echo esc_url( $services_block_image['url'] ); ?>"
						title="<?php echo esc_attr( $services_block_image['title'] ); ?>" />
				</div>
				<div class="image size-full-percentage show-on-tablet-2">
					<img alt="<?php echo esc_attr( $services_block_image['alt'] ); ?>" class="image__img"
						data-origin-src="<?php echo esc_url( $services_block_image['url'] ); ?>"
						data-size="<?php echo esc_attr( $services_block_image['width'] . 'x' . $services_block_image['height'] ); ?>"
					 src="<?php echo esc_url( $services_block_image['url'] ); ?>"
						title="<?php echo esc_attr( $services_block_image['title'] ); ?>" />
				</div>
				<div class="image size-full-percentage show-on-mobile">
					<img alt="<?php echo esc_attr( $services_block_image['alt'] ); ?>" class="image__img"
						data-origin-src="<?php echo esc_url( $services_block_image['url'] ); ?>"
						data-size="<?php echo esc_attr( $services_block_image['width'] . 'x' . $services_block_image['height'] ); ?>"
					 src="<?php echo esc_url( $services_block_image['url'] ); ?>"
						title="<?php echo esc_attr( $services_block_image['title'] ); ?>" />
				</div>
			<?php endif; ?>
		</div>
		<div class="div layer-center div--u-ivb3ga2qz" data-services-overlay="" style="opacity: 1">
			<div class="div padding-block-large size-height-full">
				<div class="div flex-align-bottom flex-direction-horizontal size-height-full"
				>
					<h3 class="text text-color-white heading-style-h2--is-services heading-style-h2"
						data-original-text="<?php echo esc_attr( $services_block_title_plain ); ?>"
						gsap-text-scroll-animation="">
						<?php echo wp_kses( $services_block_title, $allowed_title_html_tags ); ?>
					</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="div div--u-izkhs27qx grid-2 gap-0 section-services_scroll-content size-height-full"
		data-services-scroll-content=""
		id="izkhs27qx_0">
		<div class="div sticky size-full-screen section-services_sticky hide-on-tablet"
		>
			<div class="div padding-block-large size-height-full padding-block-large--is-services-top"
			>
				<div class="div flex-direction-vertical space-between size-height-full flex-direction-vertical--is-services"
				>
					<h2 class="text heading-style-h4 text-color-white text-color-grey-tablet"
						data-original-text="Услуги" gsap-text-scroll-animation="">
						<div class="line-wrapper" style="height: 28px">
							<div class="line-mask" style="height: 28px">
								<div class="text-line">Услуги</div>
							</div>
						</div>
					</h2>
					<div class="card-wrapper border-radius">
						<a class="button-large_component hero-corner-roll-btn hero-corner-roll-btn--white-brand-hover hero-corner-roll-btn--h100"
							data-action-element="" gsap-elements-scroll-animation=""
							href="<?php echo esc_url( $services_archive_url ); ?>">
							<span class="hero-corner-roll-btn__label"
								data-label="Все услуги">
								<span class="hero-corner-roll-btn__label-text">Все услуги</span>
							</span>
							<span class="hero-corner-roll-btn__icon-slot" aria-hidden="true">
								<span class="hero-corner-roll-btn__icon-roll">
									<svg class="hero-corner-roll-btn__icon hero-corner-roll-btn__icon--default"
										fill="none" height="24" viewbox="0 0 24 24" width="24"
										xmlns="http://www.w3.org/2000/svg">
										<path
											d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z"
											fill="currentColor"></path>
									</svg>
									<svg class="hero-corner-roll-btn__icon hero-corner-roll-btn__icon--hover"
										fill="none" height="24" viewbox="0 0 24 24" width="24"
										xmlns="http://www.w3.org/2000/svg">
										<path
											d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z"
											fill="currentColor"></path>
									</svg>
								</span>
							</span>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="div padding-block-large background-light-grey padding-block-large--is-services-bottom"
		>
			<div class="div show-on-tablet">
				<div class="div grid-4 size-height-full size-height-auto-tablet grid-4--is-services-title"
				>
					<h2 class="text heading-style-h4 text-color-grey text--u-ihcc0md4o"
					>
						<span class="text-block-wrap-div">Услуги</span>
					</h2>
				</div>
			</div>
			<div class="collection" data-tt-widget-version="1">
				<div class="collection__list flex-direction-vertical section_services_cards-layout"
				
					role="list">
					<?php if ( ! empty( $services_block_items ) ) : ?>
						<?php foreach ( $services_block_items as $service_index => $service_post ) : ?>
							<?php
							get_template_part(
								'template-parts/cards/servise-card',
								null,
								array(
									'service_post'  => $service_post,
									'service_index' => $service_index + 1,
								)
							);
							?>
						<?php endforeach; ?>
					<?php endif; ?>

					<div class="div section-services__mobile-cta show-on-tablet">
						<div class="card-wrapper border-radius">
							<a class="button-large_component hero-corner-roll-btn hero-corner-roll-btn--white-brand-hover hero-corner-roll-btn--h100"
								data-action-element="" gsap-elements-scroll-animation=""
								href="<?php echo esc_url( $services_archive_url ); ?>">
								<span class="hero-corner-roll-btn__label"
									data-label="Все услуги">
									<span class="hero-corner-roll-btn__label-text">Все услуги</span>
								</span>
								<span class="hero-corner-roll-btn__icon-slot" aria-hidden="true">
									<span class="hero-corner-roll-btn__icon-roll">
										<svg class="hero-corner-roll-btn__icon hero-corner-roll-btn__icon--default"
											fill="none" height="24" viewbox="0 0 24 24" width="24"
											xmlns="http://www.w3.org/2000/svg">
											<path
												d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z"
												fill="currentColor"></path>
										</svg>
										<svg class="hero-corner-roll-btn__icon hero-corner-roll-btn__icon--hover"
											fill="none" height="24" viewbox="0 0 24 24" width="24"
											xmlns="http://www.w3.org/2000/svg">
											<path
												d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z"
												fill="currentColor"></path>
										</svg>
									</span>
								</span>
							</a>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>
