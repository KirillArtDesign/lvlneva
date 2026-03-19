<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args,
	array(
		'title'   => 'Вам подойдут услуги',
		'count'   => 3,
		'exclude' => array(),
		'items'   => array(),
	)
);

$items = ! empty( $args['items'] ) ? $args['items'] : lvl_neva_get_related_service_items(
	array(
		'count'   => (int) $args['count'],
		'exclude' => (array) $args['exclude'],
	)
);
?>
<div class="div flex-direction-vertical size-width-full border-radius services-suitable-block">
	<div class="div flex-direction-vertical services-suitable-block__heading">
		<div class="services-suitable-block__title"><?php echo esc_html( $args['title'] ); ?></div>
	</div>
	<div class="div flex-direction-vertical size-width-full services-suitable-block__list">
		<?php foreach ( $items as $item ) : ?>
			<?php get_template_part( 'template-parts/cards/service-suitable-card', null, $item ); ?>
		<?php endforeach; ?>
	</div>
</div>
