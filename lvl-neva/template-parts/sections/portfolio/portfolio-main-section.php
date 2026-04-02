<?php
if (!defined('ABSPATH')) {
    exit;
}

$portfolio_gallery = get_field('foto_proekta');
$portfolio_characteristics = get_field('harakteristiki_proekta');

$portfolio_gallery = is_array($portfolio_gallery) ? $portfolio_gallery : array();
$portfolio_characteristics = is_array($portfolio_characteristics) ? $portfolio_characteristics : array();
?>
<section class="section section-equipment padding-global" id="iwg68smvj_0" style="padding-bottom: 8rem;">
    <div class="div flex-direction-vertical grid-gap size-width-full">

        <div class="div flex-direction-horizontal grid-gap flex-direction-horizontal--is-equipment-page page-layout-3-2"
            id="is19dw1j9_0">

            <div class="div equipment-page_slider_component" id="ioqrul9l1_0">
                <div class="div flex-direction-vertical equipment-page_slider_gap" id="iqubkmwvf_0">
                    <div class="div equipment-page_slider_preview background-white border-radius" id="ifb6j466j_0">
                        <div equipment-slider="preview" class="div swiper swiper-initialized swiper-horizontal"
                            id="i06j0v493_0">
                            <div class="div swiper-wrapper flex-direction-horizontal" id="izf9dxyzp_0"
                                aria-live="polite">
                                <?php foreach ($portfolio_gallery as $gallery_image): ?>
                                    <div class="div swiper-slide">
                                        <div class="div equipment-page_slider_img-wrapper">
                                            <div class="image size-full-percentage">
                                                <img src="<?php echo esc_url($gallery_image['url']); ?>"
                                                    alt="<?php echo esc_attr($gallery_image['alt']); ?>"
                                                    title="<?php echo esc_attr($gallery_image['title']); ?>"
                                                    class="image__img">
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                        </div>

                        <div class="div flex-align-bottom flex-direction-horizontal layer-bottom z-index-top"
                            id="ip0ooszxf_0">
                            <div class="div padding-block-medium" id="i4p0t9k7d_0">
                                <div class="div flex-direction-vertical" id="irf71f5m8_0">
                                    <div class="div slider-buttons_component" id="i0mmu9zpp_0">
                                        <div class="div space-between flex-direction-horizontal" id="iwqjyst4i_0">
                                            <a href="" data-action-element="" button-iconic-hover-animation=""
                                                equipment-slider="prev"
                                                class="link-block link-block--u-irkzwq2oj border-radius button-iconic_component text-color-brand background-light-grey swiper-button-disabled"
                                                id="irkzwq2oj_0" tabindex="-1" role="button" aria-label="Previous slide"
                                                aria-controls="izf9dxyzp_0" aria-disabled="true">
                                                <div class="div flex-direction-vertical" id="iyedi1vaq_0">
                                                    <div class="div div--u-iptql8tbi clip-content border-radius button-iconic__top background-brand text-color-white"
                                                        id="iptql8tbi_0">
                                                        <div class="div size-full-percentage flex-center-all"
                                                            id="iss28kos8_0">
                                                            <div class="embed icon_component embed--u-ipi1n9jo5 flex-center-all opacity"
                                                                id="ipi1n9jo5_0">
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
                                                        id="itgfue11b_0">
                                                        <div class="div size-full-percentage flex-center-all"
                                                            id="i8a6jrkdf_0">
                                                            <div class="embed icon_component embed--u-iaephav1f flex-center-all"
                                                                id="iaephav1f_0">
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
                                                id="icwi5o7ce_0" tabindex="0" role="button" aria-label="Next slide"
                                                aria-controls="izf9dxyzp_0" aria-disabled="false">
                                                <div class="div flex-direction-vertical" id="ic6wg18ks_0">
                                                    <div class="div div--u-iv9l4zuv3 clip-content border-radius button-iconic__top background-brand text-color-white"
                                                        id="iv9l4zuv3_0">
                                                        <div class="div size-full-percentage flex-center-all"
                                                            id="is4qdp0s4_0">
                                                            <div class="embed icon_component embed--u-iyahqvl6w flex-center-all opacity"
                                                                id="iyahqvl6w_0">
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
                                                        id="itae9id5i_0">
                                                        <div class="div size-full-percentage flex-center-all"
                                                            id="ie4yj27ek_0">
                                                            <div class="embed icon_component embed--u-iwfan7i4e flex-center-all"
                                                                id="iwfan7i4e_0">
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

                    <div class="div equipment-page_thumbs" id="i36ut8pcx_0">
                        <div class="div flex-direction-horizontal flex-center size-width-auto equipment-page_thumbs-gap"
                            id="i1aoxzzxh_0">
                            <?php foreach ($portfolio_gallery as $gallery_index => $gallery_image): ?>
                                <div role="button"
                                    class="link-block equipment-page_slider_thumb<?php echo 0 === $gallery_index ? ' active' : ''; ?>"
                                    data-index="<?php echo esc_attr($gallery_index); ?>">
                                    <div class="image size-full-percentage">
                                        <img src="<?php echo esc_url($gallery_image['url']); ?>"
                                            alt="<?php echo esc_attr($gallery_image['alt']); ?>"
                                            title="<?php echo esc_attr($gallery_image['title']); ?>" class="image__img">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="div flex-direction-vertical grid-gap div--u-iy6idvb8v" id="iy6idvb8v_0">
                <div class="div background-white border-radius equipment-page_title_component sticky sticky-padding"
                    id="ibea6xlo1_0">
                    <div class="div size-width-auto padding-block-large padding-block-large--is-equipment-title"
                        id="iymzrx04j_0">
                        <div class="div flex-direction-vertical equipment-page_title_gap" id="izq8h9fkr_0">
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

                            <button class="hero-corner-roll-btn hero-corner-roll-btn--brand hero-corner-roll-btn--h100"
                                data-action-element="" data-contact-drawer-open aria-controls="site-contact-drawer-panel" aria-expanded="false" gsap-elements-scroll-animation="" id="i8o80ox3i_0" type="button">
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
