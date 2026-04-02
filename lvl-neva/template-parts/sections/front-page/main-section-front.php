<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_image               = get_field( 'main_izobrazhenie_bloka' );
$hero_title               = get_field( 'main_zagolovok' );
$hero_description         = get_field( 'main_opisanie' );
$allowed_title_html_tags = array(
	'br' => array(),
);
?>

<section class="section section-cover" section-dark-theme="">
	<div class="div page-cover_component size-full-screen flex-direction-vertical">
		<div class="div layer-center div--u-i0rlqbii2">
			<div class="embed size-full-percentage ">
				<picture>
					<!-- Мобильные (до 479px) -->
					<source media="(max-width: 479px)" srcset="<?php echo esc_url( $hero_image['url'] ); ?>" />
					<!-- Планшеты (480-991px) -->
					<source media="(max-width: 991px)" srcset="<?php echo esc_url( $hero_image['url'] ); ?>" />
					<!-- Десктоп (992px+) -->
					<source media="(min-width: 992px)" srcset="<?php echo esc_url( $hero_image['url'] ); ?>" />
					<img alt="<?php echo esc_attr( $hero_image['alt'] ); ?>" loading="lazy" src="<?php echo esc_url( $hero_image['url'] ); ?>" />
				</picture>
			</div>

		</div>
		<div class="div size-height-full padding-block-large">
			<div class="div flex-direction-vertical space-between size-height-full">
				<h1 class="text heading-style-h1 text-color-white heading-style-h1--is-page-cover" cover-title="">
					<?php echo wp_kses( $hero_title, $allowed_title_html_tags ); ?>
				</h1>
				<div class="div flex-direction-horizontal space-between flex-align-bottom page-cover_gap-small"
				>
					<div class="div flex-direction-vertical page-cover_gap-small page-cover_description-wrapper"
					>
						<div class="text text-style-body text-color-white" >
							<span class="text-block-wrap-div">
								<?php echo esc_html( $hero_description ); ?>
							</span>
						</div>
						<div class="div flex-direction-horizontal page-cover_gap-xsmall div--u-iht1cbxm4"
						 max-width="100">

							<button class="hero-corner-roll-btn" type="button" data-menu-trigger="equipment">
								<span class="hero-corner-roll-btn__label" data-label="Каталог">
									<span class="hero-corner-roll-btn__label-text">Каталог</span>
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

							<button class="hero-corner-roll-btn" type="button" data-menu-trigger="equipment">
								<span class="hero-corner-roll-btn__label" data-label="Услуги">
									<span class="hero-corner-roll-btn__label-text">Услуги</span>
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
					<!-- <div class="div size-width-auto hide-on-mobile">
						<div class="div border-radius button-iconic_component text-color-white pointer-events-none background-blur"
						>
							<div class="div flex-center-all size-height-full">
								<div class="embed icon_component embed--u-igtqj1h0t flex-center-all">
									<svg fill="none" height="24" viewbox="0 0 24 24" width="24"
										xmlns="http://www.w3.org/2000/svg">
										<path
											d="M12.999 5.5V16.2764L17.2852 11.9102L18.7129 13.3115L13.6182 18.5H10.3799L5.28516 13.3115L6.71289 11.9102L10.999 16.2764V5.5H12.999Z"
											fill="currentColor"></path>
									</svg>
								</div>
							</div>
						</div>
					</div> -->
				</div>
			</div>
		</div>
	</div>
</section>
