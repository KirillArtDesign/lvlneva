<?php
if (!defined('ABSPATH')) {
    exit;
}

$portfolio_gallery = get_field('foto_proekta');
$portfolio_characteristics = get_field('harakteristiki_proekta');

$portfolio_gallery = is_array($portfolio_gallery) ? $portfolio_gallery : array();
$portfolio_characteristics = is_array($portfolio_characteristics) ? $portfolio_characteristics : array();
?>
<section class="section section-equipment">
    <div class="div flex-direction-vertical grid-gap size-width-full">

        <div class="div flex-direction-horizontal grid-gap flex-direction-horizontal--is-equipment-page page-layout-3-2 padding-global"
           >

            <div class="div flex-direction-vertical grid-gap equipment-page_slider_component">
                <div class="div flex-direction-vertical equipment-page_slider_gap">
                    <div class="div equipment-page_slider_preview background-white border-radius">
                        <div equipment-slider="preview" class="div swiper swiper-initialized swiper-horizontal"
                           >
                            <div class="div swiper-wrapper flex-direction-horizontal" id="izf9dxyzp_0"
                                aria-live="polite">
                                <?php foreach ($portfolio_gallery as $gallery_image): ?>
                                    <?php
                                    $gallery_preview_html = lvl_neva_get_field_image_html(
                                        $gallery_image,
                                        'large',
                                        array(
                                            'class'    => 'image__img',
                                            'loading'  => 'lazy',
                                            'decoding' => 'async',
                                            'sizes'    => '(max-width: 767px) 100vw, (max-width: 991px) 60vw, 55vw',
                                        )
                                    );
                                    ?>
                                    <div class="div swiper-slide">
                                        <div class="div equipment-page_slider_img-wrapper">
                                            <div class="image size-full-percentage">
                                                <?php echo $gallery_preview_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                        </div>

                        <div class="div flex-align-bottom flex-direction-horizontal layer-bottom z-index-top"
                           >
                            <div class="div padding-block-medium">
                                <div class="div flex-direction-vertical">
                                    <div class="div slider-buttons_component">
                                        <div class="div space-between flex-direction-horizontal">
                                            <a href="" data-action-element="" button-iconic-hover-animation=""
                                                equipment-slider="prev"
                                                class="link-block link-block--u-irkzwq2oj border-radius button-iconic_component text-color-brand background-light-grey swiper-button-disabled"
                                                tabindex="-1" role="button" aria-label="Previous slide"
                                                aria-controls="izf9dxyzp_0" aria-disabled="true">
                                                <div class="div flex-direction-vertical">
                                                    <div class="div div--u-iptql8tbi clip-content border-radius button-iconic__top background-brand text-color-white"
                                                       >
                                                        <div class="div size-full-percentage flex-center-all"
                                                           >
                                                            <div class="embed icon_component embed--u-ipi1n9jo5 flex-center-all opacity"
                                                               >
                                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M12.0898 6.71289L7.72363 10.999H18.5V12.999H7.72363L12.0898 17.2852L10.6885 18.7129L5.5 13.6182V10.3799L10.6885 5.28516L12.0898 6.71289Z"
                                                                        fill="currentColor"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="div div--u-itgfue11b button-iconic__bottom"
                                                       >
                                                        <div class="div size-full-percentage flex-center-all"
                                                           >
                                                            <div class="embed icon_component embed--u-iaephav1f flex-center-all"
                                                               >
                                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M12.0898 6.71289L7.72363 10.999H18.5V12.999H7.72363L12.0898 17.2852L10.6885 18.7129L5.5 13.6182V10.3799L10.6885 5.28516L12.0898 6.71289Z"
                                                                        fill="currentColor"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>

                                            <a href="" data-action-element="" button-iconic-hover-animation=""
                                                equipment-slider="next"
                                                class="link-block link-block--u-icwi5o7ce border-radius button-iconic_component text-color-brand background-light-grey"
                                                tabindex="0" role="button" aria-label="Next slide"
                                                aria-controls="izf9dxyzp_0" aria-disabled="false">
                                                <div class="div flex-direction-vertical">
                                                    <div class="div div--u-iv9l4zuv3 clip-content border-radius button-iconic__top background-brand text-color-white"
                                                       >
                                                        <div class="div size-full-percentage flex-center-all"
                                                           >
                                                            <div class="embed icon_component embed--u-iyahqvl6w flex-center-all opacity"
                                                               >
                                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z"
                                                                        fill="currentColor"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="div div--u-itae9id5i button-iconic__bottom"
                                                       >
                                                        <div class="div size-full-percentage flex-center-all"
                                                           >
                                                            <div class="embed icon_component embed--u-iwfan7i4e flex-center-all"
                                                               >
                                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z"
                                                                        fill="currentColor"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="div equipment-page_thumbs">
                        <div class="div flex-direction-horizontal flex-center size-width-auto equipment-page_thumbs-gap"
                           >
                            <?php foreach ($portfolio_gallery as $gallery_index => $gallery_image): ?>
                                <?php
                                $gallery_thumb_html = lvl_neva_get_field_image_html(
                                    $gallery_image,
                                    'thumbnail',
                                    array(
                                        'class'    => 'image__img',
                                        'loading'  => 'lazy',
                                        'decoding' => 'async',
                                        'sizes'    => '10rem',
                                    )
                                );
                                ?>
                                <div role="button"
                                    class="link-block equipment-page_slider_thumb<?php echo 0 === $gallery_index ? ' active' : ''; ?>"
                                    data-index="<?php echo esc_attr($gallery_index); ?>">
                                    <div class="image size-full-percentage">
                                        <?php echo $gallery_thumb_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <?php get_template_part( 'template-parts/sections/portfolio/portfolio-content-section' ); ?>
            </div>

            <div class="div flex-direction-vertical grid-gap div--u-iy6idvb8v portfolio-main__sidebar">
                <div class="div background-white border-radius equipment-page_title_component sticky sticky-padding portfolio-main__sidebar-card"
                   >
                    <div class="div size-width-auto padding-block-large padding-block-large--is-equipment-title portfolio-main__sidebar-inner"
                       >
                        <div class="div flex-direction-vertical equipment-page_title_gap">
                            <div class="div flex-direction-vertical size-width-full tech-specs">
                                <?php foreach ($portfolio_characteristics as $portfolio_characteristic): ?>
                                    <?php
                                    $characteristic_label = trim((string) ($portfolio_characteristic['tip_harakteristiki'] ?? ''));
                                    $characteristic_value = trim((string) ($portfolio_characteristic['znachenie_harakteristiki'] ?? ''));

                                    if ('' === $characteristic_label || '' === $characteristic_value) {
                                        continue;
                                    }
                                    ?>
                                    <div class="div flex-direction-horizontal size-width-full tech-specs__row">
                                        <div class="text-style-body tech-specs__label">
                                            <?php echo esc_html($characteristic_label); ?></div>
                                        <div class="equipment-page_tech-line-wrapper tech-specs__line">
                                            <div class="line_horizontal size-width-full"></div>
                                        </div>
                                        <div class="text-style-body tech-specs__value">
                                            <?php echo esc_html($characteristic_value); ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <button class="hero-corner-roll-btn hero-corner-roll-btn--brand hero-corner-roll-btn--h100 portfolio-main__sidebar-cta"
                                data-action-element="" data-contact-drawer-open aria-controls="site-contact-drawer-panel" aria-expanded="false" gsap-elements-scroll-animation="" type="button">
                                <span class="hero-corner-roll-btn__label" data-label="Хочу так же">
                                    <span class="hero-corner-roll-btn__label-text">Хочу так же</span>
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
