<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wp_query;

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
$service_index            = isset( $args['service_index'] ) ? (int) $args['service_index'] : ( isset( $wp_query->current_post ) ? $wp_query->current_post + 1 : null );
?>

<div class="collection__item size-width-full border-radius">
    <a class="link-block size-width-full size-height-full servise-card__link" href="<?php echo esc_url( $service_permalink ); ?>" aria-label="<?php echo esc_attr( $service_title ); ?>">
        <div class="div services-card_component background-white">
            <div class="div padding-block-medium div--u-igqazvw6q size-height-full">
                <div class="div flex-direction-vertical div--u-im0u5un4v space-between services_gap size-height-full">
                    <div class="div flex-direction-horizontal space-between services-card_gap">
                        <h3 class="text heading-style-h5 text--u-idfkqrl0m servise-card__title">
                            <span class="nav-btn servise-card__title-roll" aria-hidden="true">
                                <span class="nav-btn__label" data-label="<?php echo esc_attr( $service_title ); ?>">
                                    <span class="nav-btn__label-text"><?php echo esc_html( $service_title ); ?></span>
                                </span>
                            </span>
                        </h3>
                        <p class="text heading-style-h5 text-color-grey">
                            <span class="text-block-wrap-div"><?php echo null !== $service_index ? esc_html( sprintf( '%02d', $service_index ) ) : ''; ?></span>
                        </p>
                    </div>
                    <div class="div services-card_gap div--u-i34bznnqn flex-direction-horizontal space-between">
                        <div class="link-block link_component text-color-brand">
                            <div class="div flex-align-center flex-direction-horizontal link-iconic_gap">
                                <div class="text text-style-body">
                                    <span class="text-block-wrap-div text-color-grey"><?php echo nl2br( esc_html( $service_card_description ) ); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="div icon-card_component">
                            <div class="image icon_full">
                                <?php if ( ! empty( $service_icon ) ) : ?>
                                    <img alt="<?php echo esc_attr( $service_icon['alt'] ); ?>" class="image__img" src="<?php echo esc_url( $service_icon['url'] ); ?>"
                                        title="<?php echo esc_attr( $service_icon['title'] ); ?>" />
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </a>
</div>
