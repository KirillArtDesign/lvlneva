<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args,
	array(
		'title'   => 'Вам будет интересно',
		'count'   => 3,
		'exclude' => array(),
		'items'   => array(),
		'archive' => lvl_neva_get_blog_url(),
		'button'  => 'Смотреть все статьи',
	)
);

$items = ! empty( $args['items'] ) ? $args['items'] : lvl_neva_get_news_items(
	array(
		'count'   => (int) $args['count'],
		'exclude' => (array) $args['exclude'],
	)
);
?>
<section class="section section-news background-light-grey" id="ithc4hsyk_0">
	<div class="div padding-global section-news_padding" id="i8g5iq5ti_0">
		<div class="div flex-direction-vertical section_title-gap" id="i0nrf9qpz_0">
			<div class="div flex-direction-horizontal space-between" id="icel2rn7o_0">
				<h2 class="text heading-style-h4 text-color-grey"><?php echo esc_html( $args['title'] ); ?></h2>
				<a class="link-block link_component text-color-brand" href="<?php echo esc_url( $args['archive'] ); ?>">
					<div class="div flex-align-center flex-direction-horizontal link-iconic_gap">
						<div class="text text-style-body"><span class="text-block-wrap-div"><?php echo esc_html( $args['button'] ); ?></span></div>
						<div class="embed icon_component embed--u-idvmu9xz3 flex-center-all">
							<svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
								<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
							</svg>
						</div>
					</div>
				</a>
			</div>
			<div class="collection" id="ijktx60l9_0">
				<div role="list" class="collection__list grid-3 grid-gap grid-3--is-news-page">
					<?php foreach ( $items as $item ) : ?>
						<?php get_template_part( 'template-parts/cards/news-card', null, $item ); ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
