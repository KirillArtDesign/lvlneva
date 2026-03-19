<?php
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main class="div main-wrapper">
	<section section-dark-theme="" class="section section-cover" id="ies2q7q46_0">
		<div class="div page-cover_component flex-direction-vertical" id="i905smb5f_0">
			<div class="div padding-block-large" id="iiyh304i8_0">
				<h1 class="text heading-style-h1 text-color-black heading-style-h1--is-page-cover" id="ijmxwrbg4_0"><?php echo esc_html( woocommerce_page_title( false ) ); ?></h1>
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
								'label' => 'Каталог',
							),
						),
					)
				);
				?>
			</div>
		</div>
	</section>

	<section class="section section-services-page" id="shop-layout">
		<div class="div padding-global size-height-auto-tablet size-height-full services-page_padding">
			<div class="div grid-4 services-card_component--height-full grid-4--is-services-layout" id="iuccyujov_0">
				<?php get_template_part( 'template-parts/sections/filter-drawer' ); ?>
				<div class="collection collection--u-i2lj9rvhv">
					<div role="list" class="collection__list grid-1 size-height-full">
						<?php if ( woocommerce_product_loop() ) : ?>
							<?php while ( have_posts() ) : ?>
								<?php
								the_post();
								$product = wc_get_product( get_the_ID() );
								get_template_part(
									'template-parts/cards/product-card',
									null,
									array_merge(
										lvl_neva_map_wc_product_to_card( $product ),
										array(
											'variant' => 'adaptive',
										)
									)
								);
								?>
							<?php endwhile; ?>
						<?php else : ?>
							<?php foreach ( lvl_neva_get_default_product_cards() as $item ) : ?>
								<?php get_template_part( 'template-parts/cards/product-card', null, array_merge( $item, array( 'variant' => 'adaptive' ) ) ); ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/sections/contact-form' ); ?>
</main>
<?php
get_footer();
