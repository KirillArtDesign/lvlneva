<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$certificates_raw = function_exists( 'get_field' ) ? get_field( 'sert' ) : array();
$certificates     = array();

if ( is_array( $certificates_raw ) ) {
	foreach ( $certificates_raw as $certificate ) {
		if ( ! is_array( $certificate ) || empty( $certificate['url'] ) ) {
			continue;
		}

		$certificates[] = array(
			'id'    => isset( $certificate['ID'] ) ? absint( $certificate['ID'] ) : 0,
			'url'   => lvl_neva_get_field_image_url( $certificate, 'large' ),
			'alt'   => ! empty( $certificate['alt'] ) ? (string) $certificate['alt'] : '',
			'title' => ! empty( $certificate['title'] ) ? (string) $certificate['title'] : '',
		);
	}
}

if ( empty( $certificates ) ) {
	return;
}

$certificates_slider_id = 'about-certificates-slider-' . get_queried_object_id();
$has_slider_nav         = count( $certificates ) > 1;
?>
<section class="section section-full-screen section-equipments section-about-certificates section--u-irwudmunb">
	<div class="div padding-global size-height-auto-tablet section-equipments_padding section-full-screen">
		<div class="div grid-4 grid-4--is-equipments-layout size-height-full size-height-auto-tablet">
			<h2 class="text heading-style-h4 text-color-grey text--u-ihdpdjstl">
				Сертификаты
			</h2>

			<div class="div section-equipments_slider-wrapper div--u-i08l6t9q5 size-height-full size-height-auto-tablet clip-content">
				<div class="collection size-height-full swiper size-height-auto-tablet" data-tt-widget-version="1" equipments-slider="container">
					<div aria-live="polite" class="collection__list size-height-full size-height-auto-tablet swiper-wrapper section-equipments_cards-flex about-certificates__list" id="<?php echo esc_attr( $certificates_slider_id ); ?>" role="list" style="cursor: grab">
						<?php foreach ( $certificates as $certificate ) : ?>
							<?php
							$certificate_title = '' !== $certificate['title'] ? $certificate['title'] : __( 'Сертификат', 'lvl-neva' );
							$certificate_alt   = '' !== $certificate['alt'] ? $certificate['alt'] : $certificate_title;
							$certificate_html  = lvl_neva_get_field_image_html(
								array(
									'ID'    => $certificate['id'],
									'url'   => $certificate['url'],
									'alt'   => $certificate_alt,
									'title' => $certificate_title,
								),
								'large',
								array(
									'class'    => 'image__img',
									'alt'      => $certificate_alt,
									'title'    => $certificate_title,
									'loading'  => 'lazy',
									'decoding' => 'async',
									'sizes'    => '(max-width: 767px) 100vw, (max-width: 991px) 50vw, 33vw',
								)
							);
							?>
							<div class="collection__item size-height-full size-height-auto-tablet swiper-slide about-certificates__slide" role="group" aria-label="<?php echo esc_attr( $certificate_title ); ?>">
								<div class="div equipments-card_component background-white border-radius size-height-full about-certificate-card">
									<div class="image size-full-percentage about-certificate-card__image">
										<?php echo $certificate_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

			<?php if ( $has_slider_nav ) : ?>
				<div class="div show-on-desktop layer-left z-index-top show-on-desktop--is-equipments-slider-buttons">
					<div class="div">
						<div class="div slider-buttons_component">
							<div class="div flex-direction-horizontal">
								<a aria-controls="<?php echo esc_attr( $certificates_slider_id ); ?>" aria-disabled="false" aria-label="Предыдущий сертификат" button-iconic-hover-animation="" class="link-block link-block--u-iigo3gnpy border-radius button-iconic_component text-color-brand background-white" data-action-element="" equipments-slider="prev" href="#" role="button" tabindex="0">
									<div class="div flex-direction-vertical">
										<div class="div div--u-i9ekafbym clip-content border-radius button-iconic__top background-brand text-color-white">
											<div class="div size-full-percentage flex-center-all">
												<div class="embed icon_component embed--u-i0ydq3xjl flex-center-all opacity">
													<svg fill="none" height="24" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
														<path d="M12.0898 6.71289L7.72363 10.999H18.5V12.999H7.72363L12.0898 17.2852L10.6885 18.7129L5.5 13.6182V10.3799L10.6885 5.28516L12.0898 6.71289Z" fill="currentColor"></path>
													</svg>
												</div>
											</div>
										</div>
										<div class="div div--u-i9ipmrni7 button-iconic__bottom">
											<div class="div size-full-percentage flex-center-all">
												<div class="embed icon_component embed--u-i600v39mo flex-center-all">
													<svg fill="none" height="24" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
														<path d="M12.0898 6.71289L7.72363 10.999H18.5V12.999H7.72363L12.0898 17.2852L10.6885 18.7129L5.5 13.6182V10.3799L10.6885 5.28516L12.0898 6.71289Z" fill="currentColor"></path>
													</svg>
												</div>
											</div>
										</div>
									</div>
								</a>

								<a aria-controls="<?php echo esc_attr( $certificates_slider_id ); ?>" aria-disabled="false" aria-label="Следующий сертификат" button-iconic-hover-animation="" class="link-block link-block--u-iwsuicknx border-radius button-iconic_component text-color-white background-brand" data-action-element="" equipments-slider="next" href="#" role="button" tabindex="0">
									<div class="div flex-direction-vertical">
										<div class="div div--u-i42430wfu clip-content border-radius button-iconic__top background-brand text-color-white">
											<div class="div size-full-percentage flex-center-all">
												<div class="embed icon_component embed--u-i2z2160jq flex-center-all opacity">
													<svg fill="none" height="24" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
														<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
													</svg>
												</div>
											</div>
										</div>
										<div class="div div--u-idhlvqjcz button-iconic__bottom">
											<div class="div size-full-percentage flex-center-all">
												<div class="embed icon_component embed--u-igww5j4kx flex-center-all">
													<svg fill="none" height="24" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
														<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
													</svg>
												</div>
											</div>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
