<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$service_terms = get_terms(
	array(
		'taxonomy'   => 'services-type',
		'hide_empty' => true,
		'orderby'    => 'term_order',
		'order'      => 'ASC',
	)
);

if ( empty( $service_terms ) || is_wp_error( $service_terms ) ) {
	return;
}

foreach ( $service_terms as $service_term ) :
	$services_query = new WP_Query(
		array(
			'post_type'      => 'services',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'date',
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'services-type',
					'field'    => 'term_id',
					'terms'    => $service_term->term_id,
				),
			),
		)
	);

	if ( ! $services_query->have_posts() ) {
		wp_reset_postdata();
		continue;
	}
	?>
	<section class="section  section-services-page">
		<div class="div padding-global size-height-auto-tablet size-height-full services-page_padding">
			<div class="div grid-4 services-card_component--height-full grid-4--is-services-layout">
				<h2 class="text heading-style-h4 text-color-grey text--u-irj2o420v hide-on-mobile">
					<?php echo esc_html( $service_term->name ); ?>
				</h2>
				<div class="collection collection--u-i2lj9rvhv size-height-full">
					<div role="list" class="collection__list grid-2 size-height-full grid-2--is-services-page">
						<?php
						$service_index = 1;

						while ( $services_query->have_posts() ) :
							$services_query->the_post();

							get_template_part(
								'template-parts/cards/servise-card',
								null,
								array(
									'service_post'  => get_post(),
									'service_index' => $service_index,
								)
							);

							$service_index++;
						endwhile;
						?>
					</div>
				</div>
				<div class="div flex-direction-horizontal flex-align-bottom div--u-iw4krq8m1 section-left-sticky grid_col--padding-right hide-on-mobile">
					<div class="div flex-direction-vertical div--u-iib32ehuc text-max-width section-services_gap-small">
						<p class="text text--u-illef3you text-style-body text-color-grey">
							<span class="text-block-wrap-div"><?php echo wp_kses( $service_term->description, array( 'br' => array() ) ); ?></span>
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	wp_reset_postdata();
endforeach;
