<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args,
	array(
		'title'       => '',
		'description' => '',
		'price'       => '',
		'sizes'       => array(),
		'image'       => lvl_neva_asset_url( 'img/card.jpg' ),
		'url'         => lvl_neva_get_shop_url(),
		'variant'     => 'slider',
	)
);
?>
<?php if ( 'adaptive' === $args['variant'] ) : ?>
	<a href="<?php echo esc_url( $args['url'] ); ?>" class="div equipments-card_component background-white border-radius equipments-card-adaptive">
		<div class="div flex-direction-horizontal background-white equipments-card-adaptive__layout">
			<div class="div padding-block-xlarge equipments-card-adaptive__content">
				<div class="div flex-direction-vertical size-height-full equipments-card-adaptive__content-inner">
					<div class="div flex-direction-vertical equipments-card-adaptive__top">
						<h3 class="text heading-style-h3 equipments-card-adaptive__title">
							<span class="text-block-wrap-div"><?php echo esc_html( $args['title'] ); ?></span>
						</h3>
						<div class="text text-style-body text-color-grey equipments-card-adaptive__description">
							<span class="text-block-wrap-div"><?php echo esc_html( $args['description'] ); ?></span>
						</div>
					</div>
					<div class="div flex-direction-vertical equipments-card-adaptive__bottom">
						<div class="text heading-style-h5 text-color-brand equipments-card-adaptive__price"><?php echo esc_html( $args['price'] ); ?></div>
						<div class="div flex-direction-vertical equipments-card-adaptive__sizes-block">
							<div class="text text-style-body text-color-grey equipments-card-adaptive__sizes-title"><?php esc_html_e( 'Доступно в размерах', 'lvl-neva' ); ?></div>
							<div class="div flex-direction-horizontal flex-wrap-gap equipments-card-adaptive__sizes">
								<?php foreach ( (array) $args['sizes'] as $size ) : ?>
									<div class="size-badge text text-style-body equipments-card-adaptive__size-badge"><?php echo esc_html( $size ); ?></div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="div equipments-card-adaptive__media">
				<div class="equipments-card-adaptive__media-fade"></div>
				<img class="image__img equipments-card-adaptive__image" src="<?php echo esc_url( $args['image'] ); ?>" alt="<?php echo esc_attr( $args['title'] ); ?>">
			</div>
		</div>
	</a>
<?php else : ?>
	<a href="<?php echo esc_url( $args['url'] ); ?>" class="div equipments-card_component background-white border-radius size-height-full">
		<div class="div flex-direction-horizontal grid-4--is-equipment background-white size-height-full">
			<div class="div equipments-card_img-wrapper flex-center-all" style="position:absolute;height:100%;">
				<div class="image equipments-card_img size-width-auto size-height-full equipments-card_img--is-main">
					<img class="image__img" src="<?php echo esc_url( $args['image'] ); ?>" alt="<?php echo esc_attr( $args['title'] ); ?>">
				</div>
			</div>
			<div class="div padding-block-xlarge">
				<div class="div flex-direction-vertical size-height-full flex-justify-left">
					<h3 class="text heading-style-h3">
						<span class="text-block-wrap-div"><?php echo esc_html( $args['title'] ); ?></span>
					</h3>
					<div class="div equipments-card_spacer"></div>
					<div class="div flex-align-center flex-direction-horizontal link-iconic_gap">
						<div class="text text-style-body">
							<span class="text-block-wrap-div text-color-grey"><?php echo esc_html( $args['description'] ); ?></span>
						</div>
					</div>
					<div class="div equipments-card_spacer"></div>
					<div class="div flex-direction-vertical">
						<div class="text heading-style-h5 text-color-brand"><?php echo esc_html( $args['price'] ); ?></div>
						<div class="div equipments-card_spacer"></div>
						<div class="text text-style-body text-color-grey"><?php esc_html_e( 'Доступно в размерах', 'lvl-neva' ); ?></div>
						<div class="div flex-direction-horizontal flex-wrap-gap">
							<?php foreach ( (array) $args['sizes'] as $size ) : ?>
								<div class="size-badge text text-style-body"><?php echo esc_html( $size ); ?></div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</a>
<?php endif; ?>
