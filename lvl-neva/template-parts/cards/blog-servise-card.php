<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$service_post = ! empty( $args['service_post'] ) ? $args['service_post'] : get_post();

if ( $service_post instanceof WP_Post ) {
	$service_post_id = $service_post->ID;
} elseif ( is_numeric( $service_post ) ) {
	$service_post_id = (int) $service_post;
} else {
	$service_post_id = get_the_ID();
}

$service_title            = get_the_title( $service_post_id );
$service_permalink        = get_permalink( $service_post_id );
$service_card_description = get_field( 'opisanie_v_kartochke_uslugi', $service_post_id );
$service_icon             = get_field( 'ikonka_uslugi', $service_post_id );
$service_index            = isset( $args['service_index'] ) ? (int) $args['service_index'] : null;
?>

<a href="<?php echo esc_url( $service_permalink ); ?>" class="div link-block">
    <div class="div flex-direction-vertical size-width-full background-white services-card_component-product services-card--is-suitable">
        <div class="div flex-direction-horizontal services-suitable-block__top">
            <div class="services-suitable-block__card-title"><?php echo esc_html( $service_title ); ?></div>
            <div class="services-suitable-block__card-num"><?php echo null !== $service_index ? esc_html( sprintf( '%02d', $service_index ) ) : ''; ?></div>
        </div>
        <div class="div flex-direction-horizontal services-suitable-block__bottom">
            <div class="services-suitable-block__card-text"><?php echo nl2br( esc_html( $service_card_description ) ); ?></div>
            <div class="services-suitable-block__icon" aria-hidden="true">
                <?php if ( ! empty( $service_icon ) ) : ?>
                    <img
                        src="<?php echo esc_url( $service_icon['url'] ); ?>"
                        alt="<?php echo esc_attr( $service_icon['alt'] ); ?>"
                        title="<?php echo esc_attr( $service_icon['title'] ); ?>"
                        class="image__img"
                    >
                <?php endif; ?>
            </div>
        </div>
    </div>
</a>
