<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$production_title       = get_field( 'production_zagolovok' );
$production_description = get_field( 'production_opisanie' );
$production_image       = get_field( 'production_izobrazhenie_v_bloke' );
$production_video       = get_field( 'production_video_v_bloke' );
$production_video       = is_array( $production_video ) ? $production_video : array();
$video_cover_image      = ! empty( $production_video['oblozhka_video'] ) ? $production_video['oblozhka_video'] : null;
$video_url              = ! empty( $production_video['ssylka_na_video'] ) ? $production_video['ssylka_na_video'] : '';
$production_image_src   = lvl_neva_get_field_image_url( $production_image, 'large' );
$production_image_full  = lvl_neva_get_field_image_url( $production_image, 'full' );
$video_cover_src        = lvl_neva_get_field_image_url( $video_cover_image, 'large' );
$video_embed_html       = lvl_neva_get_video_embed_html(
	$video_url,
	array(
		'title'  => $production_title ? wp_strip_all_tags( $production_title ) : 'Видео производства',
		'width'  => 1428,
		'height' => 803,
		'poster' => $video_cover_src,
	)
);
$has_production_video = '' !== trim( $video_embed_html );
$allowed_title_html_tags = array(
	'br' => array(),
);
?>

<section class="section section-production section-full-screen text-color-white" style="background: var(--color-black);">
	<div class="div layer-center" style="
    opacity: 50%;
">
		<div class="image size-full-percentage">
			<?php if ( $production_image_src ) : ?>
				<img alt="<?php echo esc_attr( $production_image['alt'] ); ?>" class="image__img"
					data-origin-src="<?php echo esc_url( $production_image_full ? $production_image_full : $production_image_src ); ?>"
					data-size="<?php echo esc_attr( $production_image['width'] . 'x' . $production_image['height'] ); ?>"
				 src="<?php echo esc_url( $production_image_src ); ?>"
				 loading="lazy"
				 decoding="async"
					title="<?php echo esc_attr( $production_image['title'] ); ?>" />
			<?php endif; ?>
		</div>
	</div>
	<div class="div padding-global size-height-full section-production_padding">
		<div class="div flex-direction-vertical section-production_gap-large space-between size-height-full"
		>
			<div class="div grid-4 grid-4--is-production-title">
				<h2 class="text heading-style-h4 text-color-grey-mobile" data-original-text="Производство"
					gsap-text-scroll-animation="">
					<div class="line-wrapper" style="height: 28px">
						<div class="line-mask" style="height: 28px">
							<div class="text-line">Наше Производство</div>
						</div>
					</div>
				</h2>
				<div class="div grid_col-padding-left div--u-i8jl1uyke">
					<h3 class="text heading-style-h2 text--u-i5a1b8iu7">
						<?php echo wp_kses( nl2br( esc_html( $production_title ) ), $allowed_title_html_tags ); ?>
					</h3>
				</div>
			</div>
			<div class="div grid-4 grid-4--is-production">
				<div class="div div--u-igksdfdgz grid_col--padding-right section-production__video-col"
				>
					<div class="div flex-align-bottom flex-direction-horizontal size-height-full">
						<div class="div border-radius production_video-card div--u-io0cduz6i section-production__video-card"
							data-production-video-card=""
						>
							<?php if ( $has_production_video ) : ?>
								<div class="embed layer-center size-full-percentage">
									<?php echo $video_embed_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
							<?php endif; ?>
							<div class="image size-full-percentage layer-center image--u-iopk7wa23">
								<?php if ( $video_cover_src ) : ?>
									<img alt="<?php echo esc_attr( $video_cover_image['alt'] ); ?>" class="image__img"
										data-size="<?php echo esc_attr( $video_cover_image['width'] . 'x' . $video_cover_image['height'] ); ?>"
									 src="<?php echo esc_url( $video_cover_src ); ?>"
									 loading="lazy"
									 decoding="async"
										title="<?php echo esc_attr( $video_cover_image['title'] ); ?>" />
								<?php endif; ?>
							</div>
							<?php if ( $has_production_video ) : ?>
								<div class="div layer-center div--u-i8559gqfs pointer-events-none flex-center-all"
								>
									<div class="div text-color-brand button-iconic_component button-iconic_rounded background-white"
									>
										<div class="embed embed--u-iq92bxoyc icon_full flex-center-all">
											<svg fill="none" height="40" viewbox="0 0 40 40" width="40"
												xmlns="http://www.w3.org/2000/svg">
												<path
													d="M24.2617 21.3938L18.933 24.9463C17.8254 25.6847 16.3418 24.8907 16.3418 23.5596V16.4546C16.3418 15.1235 17.8254 14.3295 18.933 15.0679L24.2617 18.6203C25.2512 19.28 25.2512 20.7341 24.2617 21.3938Z"
													fill="currentColor"></path>
											</svg>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="div grid_col-padding-left flex-direction-vertical section-production_gap-medium div--u-iny92dg0s section-production__content-col"
				>
					<div class="div flex-direction-vertical section-about_gap-small div--u-irs9pk5nk text-max-width"
						gsap-opacity-scroll-animation="" style="opacity: 1">

						<div class="tt-rich-text text-style-body text-color-white" gsap-opacity-scroll-animation=""
						 rich-text="about" style="opacity: 1">
							<div class="text-block-wrap-div">
								<?php echo wpautop( esc_html( $production_description ) ); ?>
							</div>
						</div>
					</div>
					<div class="div">
						<div class="card-wrapper border-radius">

							<button
								class="button-large_component hero-corner-roll-btn hero-corner-roll-btn--white-brand-hover hero-corner-roll-btn--h100"
								data-action-element="" data-contact-drawer-open aria-controls="site-contact-drawer-panel" aria-expanded="false" gsap-elements-scroll-animation="" type="button">
								<span class="hero-corner-roll-btn__label" data-label="Связаться с нами">
									<span class="hero-corner-roll-btn__label-text">Связаться с нами</span>
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
							</button>


						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
