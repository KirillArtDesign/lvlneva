<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args    = wp_parse_args(
	$args,
	array(
		'title'   => '',
		'excerpt' => '',
		'number'  => '01',
		'url'     => '#',
		'variant' => 'default',
	)
);
$classes = 'div services-card_component background-white';

if ( 'page' === $args['variant'] ) {
	$classes .= ' services-card--is-page';
}
?>
<div class="<?php echo esc_attr( $classes ); ?>">
	<div class="div padding-block-medium div--u-ibxbmfx8g size-height-full">
		<div class="div flex-direction-vertical div--u-i2fastudu space-between services_gap size-height-full">
			<div class="div flex-direction-horizontal space-between services-card_gap">
				<h3 class="text text--u-ioudywas9 heading-style-h5--is-services-title text-style-body">
					<span class="text-block-wrap-div"><?php echo esc_html( $args['title'] ); ?></span>
				</h3>
				<p class="text heading-style-h5 text-color-grey">
					<span class="text-block-wrap-div"><?php echo esc_html( $args['number'] ); ?></span>
				</p>
			</div>
			<div class="div services-card_gap div--u-i30tlvz57 flex-direction-horizontal space-between">
				<a href="<?php echo esc_url( $args['url'] ); ?>" class="link-block link_component text-color-brand">
					<div class="div flex-align-center flex-direction-horizontal link-iconic_gap">
						<div class="text text-style-body text-color-grey">
							<span class="text-block-wrap-div"><?php echo esc_html( $args['excerpt'] ); ?></span>
						</div>
					</div>
				</a>
				<div class="div icon-card_component" aria-hidden="true">
					<svg class="icon-card_component" width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect width="45" height="45" rx="3" fill="#31572C" />
						<path d="M27.5 27.5V19.2667L26.6139 18.3833M17.5 17.5H25.7278L26.6139 18.3833M26.6139 18.3833L17.9909 26.9795" stroke="white" stroke-width="2" />
					</svg>
				</div>
			</div>
		</div>
	</div>
</div>
