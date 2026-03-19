<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args,
	array(
		'title'   => '',
		'excerpt' => '',
		'number'  => '01',
		'url'     => '#',
	)
);
?>
<a href="<?php echo esc_url( $args['url'] ); ?>" class="div flex-direction-vertical size-width-full background-white services-card_component-product services-card--is-suitable">
	<div class="div flex-direction-horizontal services-suitable-block__top">
		<div class="services-suitable-block__card-title"><?php echo esc_html( $args['title'] ); ?></div>
		<div class="services-suitable-block__card-num"><?php echo esc_html( $args['number'] ); ?></div>
	</div>
	<div class="div flex-direction-horizontal services-suitable-block__bottom">
		<div class="services-suitable-block__card-text"><?php echo esc_html( $args['excerpt'] ); ?></div>
		<div class="services-suitable-block__icon" aria-hidden="true">
			<svg viewBox="0 0 57 57" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M33.4796 44.8701L38.6445 50.035M33.4796 44.8701L29.4685 51.7748L30.6041 52.9105M33.4796 44.8701L48.4295 29.9202M38.6445 50.035L55.0186 33.6609L53.1405 31.7828M38.6445 50.035L31.7398 54.0461L30.6041 52.9105M30.6041 52.9105L29.1803 54.3343M48.4295 29.9202L49.8537 28.496L51.7319 30.3741M48.4295 29.9202L46.5514 28.042L41.3308 33.2626M51.7319 30.3741L53.6299 28.4761L55.0385 29.8847L53.1405 31.7828M51.7319 30.3741L53.1405 31.7828M51.5753 33.2626L45.0866 39.7514" stroke="currentColor" stroke-width="1.42292"/>
				<path d="M30.6045 52.9107L29.1807 54.3345" stroke="currentColor" stroke-width="1.42292"/>
				<path d="M48.4296 29.92L46.5514 28.0418L41.3308 33.2625" stroke="currentColor" stroke-width="1.42292"/>
			</svg>
		</div>
	</div>
</a>
