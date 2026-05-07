<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$product_services_ids = get_field( 'uslugi_v_state', get_the_ID() );
$product_services     = array();

if ( ! empty( $product_services_ids ) ) {
	if ( ! is_array( $product_services_ids ) ) {
		$product_services_ids = array( $product_services_ids );
	}

	$product_services_ids = array_values(
		array_filter(
			array_map( 'absint', $product_services_ids )
		)
	);

	if ( ! empty( $product_services_ids ) ) {
		$product_services = get_posts(
			array(
				'post_type'      => 'services',
				'post_status'    => 'publish',
				'posts_per_page' => count( $product_services_ids ),
				'post__in'       => $product_services_ids,
				'orderby'        => 'post__in',
			)
		);
	}
}
?>

			<div class="div flex-direction-vertical grid-gap size-width-full">
				<div class="div flex-direction-horizontal size-width-full equipment-article">
					<div class="div flex-direction-vertical size-width-full background-white border-radius padding-block-large equipment-article__card">
						<div class="div flex-direction-horizontal size-width-full equipment-article__top">
							<div class="div flex-direction-vertical size-width-full equipment-article__content">
								<?php echo lvl_neva_get_equipment_article_content( get_the_ID() ); ?>
							</div>
						</div>
					</div>
				</div>

				<?php if ( ! empty( $product_services ) ) : ?>
					<div class="div flex-direction-vertical size-width-full background-white border-radius padding-block-large services-suitable-block">
						<div class="div flex-direction-vertical services-suitable-block__heading">
							<div class="services-suitable-block__title">Вам подойдут услуги</div>
						</div>

						<div class="div flex-direction-vertical size-width-full services-suitable-block__list">
							<?php
							$service_index = 1;

							foreach ( $product_services as $service_post ) :
								get_template_part(
									'template-parts/cards/blog-servise-card',
									null,
									array(
										'service_post'  => $service_post,
										'service_index' => $service_index,
									)
								);

								$service_index++;
							endforeach;
							?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
