<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args,
	array(
		'title'    => '',
		'category' => '',
		'image'    => lvl_neva_asset_url( 'img/main.jpg' ),
		'url'      => lvl_neva_get_blog_url(),
	)
);
?>
<div role="listitem" class="collection__item size-full-percentage relative border-radius">
	<a href="<?php echo esc_url( $args['url'] ); ?>" class="link-block news-card_component background-light-grey flex-direction-vertical size-full-percentage news-card_component--catalog">
		<div class="image size-full-percentage relative">
			<img src="<?php echo esc_url( $args['image'] ); ?>" alt="<?php echo esc_attr( $args['title'] ); ?>" class="image__img">
			<div class="div padding-block-small absolute" style="top:0;left:0;">
				<p class="text text-style-body text-color-white">
					<span class="text-block-wrap-div"><?php echo esc_html( $args['category'] ); ?></span>
				</p>
			</div>
		</div>
		<div class="div border-all div--u-ifil4yw8v">
			<div class="div padding-block-small">
				<div class="div flex-direction-horizontal">
					<h3 class="text heading-style-h5 text-color-black"><?php echo esc_html( $args['title'] ); ?></h3>
					<svg class="icon-card_component" width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect width="45" height="45" rx="3" fill="#31572C" />
						<path d="M27.5 27.5V19.2667L26.6139 18.3833M17.5 17.5H25.7278L26.6139 18.3833M26.6139 18.3833L17.9909 26.9795" stroke="white" stroke-width="2" />
					</svg>
				</div>
			</div>
		</div>
	</a>
</div>
