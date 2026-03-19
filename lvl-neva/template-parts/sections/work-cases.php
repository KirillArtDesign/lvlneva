<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args,
	array(
		'title'         => 'Смотрите другие наши работы',
		'count'         => 2,
		'exclude'       => array(),
		'items'         => array(),
		'background'    => 'background-light-grey',
		'button_label'  => 'Смотреть все проекты',
		'button_url'    => lvl_neva_get_archive_url( 'project', '/projects/' ),
		'content_class' => 'project-case-card__content',
	)
);

$items = ! empty( $args['items'] ) ? $args['items'] : lvl_neva_get_project_items(
	array(
		'count'   => (int) $args['count'],
		'exclude' => (array) $args['exclude'],
	)
);
?>
<section class="section section-services-page <?php echo esc_attr( $args['background'] ); ?>" id="il0p4zb9d_0">
	<div class="div padding-global size-height-auto-tablet services-page_padding">
		<div class="div grid-4 services-card_component--height-full grid-4--is-services-layout" id="iuccyujov_0">
			<h2 class="text heading-style-h4 text-color-grey text--u-irj2o420v"><?php echo esc_html( $args['title'] ); ?></h2>
			<div class="collection collection--u-i2lj9rvhv">
				<div role="list" class="collection__list grid-1">
					<?php foreach ( $items as $item ) : ?>
						<?php get_template_part( 'template-parts/cards/project-card', null, array_merge( $item, array( 'content_class' => $args['content_class'] ) ) ); ?>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="div flex-direction-horizontal flex-align-bottom div--u-iltmzvhq2 flex-align-bottom--is-equipment-button grid-2-tablet section-works-cta">
				<div class="div div--u-iw325u2iw tablet-col-right">
					<div class="card-wrapper border-radius">
						<a class="button-large_component hero-corner-roll-btn hero-corner-roll-btn--brand hero-corner-roll-btn--h100" href="<?php echo esc_url( $args['button_url'] ); ?>">
							<span class="hero-corner-roll-btn__label" data-label="<?php echo esc_attr( $args['button_label'] ); ?>">
								<span class="hero-corner-roll-btn__label-text"><?php echo esc_html( $args['button_label'] ); ?></span>
							</span>
							<span class="hero-corner-roll-btn__icon-slot" aria-hidden="true">
								<span class="hero-corner-roll-btn__icon-roll">
									<svg class="hero-corner-roll-btn__icon hero-corner-roll-btn__icon--default" fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
										<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
									</svg>
									<svg class="hero-corner-roll-btn__icon hero-corner-roll-btn__icon--hover" fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
										<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
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
