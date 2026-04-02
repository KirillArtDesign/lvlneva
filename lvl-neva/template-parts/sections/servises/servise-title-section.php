<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$service_title             = get_the_title();
$service_short_description = get_field( 'kratkoe_opisanie_uslugi', get_the_ID() );
$service_image_id          = get_post_thumbnail_id();
$service_image_url         = $service_image_id ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '';
$service_image_alt         = $service_image_id ? get_post_meta( $service_image_id, '_wp_attachment_image_alt', true ) : '';
$service_image_title       = $service_image_id ? get_the_title( $service_image_id ) : '';
$breadcrumb_items          = function_exists( 'lvl_neva_get_breadcrumb_items' ) ? lvl_neva_get_breadcrumb_items() : array();
?>

<section section-dark-theme="" class="section service-hero">
    <div class="div page-cover_component flex-direction-vertical service-hero__cover">
        <div class="div layer-center">
            <div class="image size-full-percentage ">
                <?php if ( $service_image_url ) : ?>
                    <img src="<?php echo esc_url( $service_image_url ); ?>" alt="<?php echo esc_attr( $service_image_alt ); ?>"
                        title="<?php echo esc_attr( $service_image_title ); ?>" class="image__img">
                <?php endif; ?>
            </div>
        </div>

        <div class="div page-cover_service-content service-hero__content">
            <div class="div size-height-full flex-align-bottom flex-direction-horizontal service-hero__content-row"
               >
                <div class="div padding-block-large service-hero__inner">

                    <div class="div flex-direction-vertical service-hero__top">
                        <h1 gsap-text-instant-animation=""
                            class="text heading-style-h1 text-color-white heading-style-h1--is-page-cover"
                           >
                            <?php echo esc_html( $service_title ); ?>
                        </h1>

                        <?php if ( ! empty( $breadcrumb_items ) ) : ?>
                            <nav class="breadcrumbs" aria-label="<?php esc_attr_e( 'Хлебные крошки', 'lvl-neva' ); ?>">
                                <ul class="div flex-direction-horizontal service-hero__breadcrumbs">
                                    <?php foreach ( $breadcrumb_items as $index => $item ) : ?>
                                        <li>
                                            <?php if ( ! empty( $item['url'] ) && empty( $item['current'] ) ) : ?>
                                                <a href="<?php echo esc_url( $item['url'] ); ?>" class="text text-style-body text-color-grey">
                                                    <span class="text-block-wrap-div"><?php echo esc_html( $item['label'] ); ?></span>
                                                </a>
                                            <?php else : ?>
                                                <span class="text text-style-body <?php echo ! empty( $item['current'] ) ? 'text-color-white' : 'text-color-grey'; ?>"<?php echo ! empty( $item['current'] ) ? ' aria-current="page"' : ''; ?>>
                                                    <span class="text-block-wrap-div"><?php echo esc_html( $item['label'] ); ?></span>
                                                </span>
                                            <?php endif; ?>
                                        </li>

                                        <?php if ( $index < count( $breadcrumb_items ) - 1 ) : ?>
                                            <li class="text text-style-body text-color-grey" aria-hidden="true">/</li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    </div>

                    <div class="div flex-direction-horizontal service-hero__bottom">
                        <div
                            class="div flex-direction-vertical size-width-full equipment-article__section service-hero__text-wrap">
                            <div class="equipment-article__text text-color-white">
                                <?php echo nl2br( esc_html( $service_short_description ) ); ?>
                            </div>
                        </div>

                        <button
                            class="button-large_component hero-corner-roll-btn hero-corner-roll-btn--white-brand-hover hero-corner-roll-btn--h100"
                            data-action-element="" data-contact-drawer-open aria-controls="site-contact-drawer-panel" aria-expanded="false" gsap-elements-scroll-animation="" type="button">
                            <span class="hero-corner-roll-btn__label" data-label="Оставить заявку">
                                <span class="hero-corner-roll-btn__label-text">Оставить заявку</span>
                            </span>
                            <span class="hero-corner-roll-btn__icon-slot" aria-hidden="true">
                                <span class="hero-corner-roll-btn__icon-roll">
                                    <svg class="hero-corner-roll-btn__icon hero-corner-roll-btn__icon--default"
                                        fill="none" height="24" viewbox="0 0 24 24" width="24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z"
                                            fill="currentColor"></path>
                                    </svg>
                                    <svg class="hero-corner-roll-btn__icon hero-corner-roll-btn__icon--hover"
                                        fill="none" height="24" viewbox="0 0 24 24" width="24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </span>
                            </span>
                        </button>

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
