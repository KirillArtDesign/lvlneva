<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$portfolio_section_query = new WP_Query(
	array(
		'post_type'      => 'portfolio',
		'post_status'    => 'publish',
		'posts_per_page' => 2,
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);
$portfolio_archive_url = function_exists( 'lvl_neva_get_archive_url_for_post_type' ) ? lvl_neva_get_archive_url_for_post_type( 'portfolio' ) : '';
?>

<section class="section  section-services-page background-light-grey">
	<div class="div padding-global size-height-auto-tablet  services-page_padding">
		<div class="div grid-4 services-card_component--height-full grid-4--is-services-layout"
		>
			<h2 gsap-text-scroll-animation=""
				class="text heading-style-h4 text-color-grey text--u-irj2o420v "
				>
				смотрите наши работы
			</h2>
			<div class="collection collection--u-i2lj9rvhv ">
				<div role="list"
					class="collection__list grid-1 "
					>
					<?php if ( $portfolio_section_query->have_posts() ) : ?>
						<?php while ( $portfolio_section_query->have_posts() ) : ?>
							<?php
							$portfolio_section_query->the_post();

							get_template_part(
								'template-parts/cards/portfolio-card',
								null,
								array(
									'post' => get_post(),
								)
							);
							?>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					<?php endif; ?>
				</div>
			</div>

			<div class="div flex-direction-horizontal flex-align-bottom div--u-iltmzvhq2 flex-align-bottom--is-equipment-button grid-2-tablet section-works-cta">
				<div class="div div--u-iw325u2iw tablet-col-right">
					<div class="card-wrapper border-radius">
						<a class="link-block button-large_component hero-corner-roll-btn hero-corner-roll-btn--brand hero-corner-roll-btn--h100"
							data-action-element="" gsap-elements-scroll-animation=""
							href="<?php echo esc_url( $portfolio_archive_url ); ?>">
							<span class="hero-corner-roll-btn__label"
								data-label="Смотреть все проекты">
								<span class="hero-corner-roll-btn__label-text">Смотреть все проекты</span>
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
</section>
