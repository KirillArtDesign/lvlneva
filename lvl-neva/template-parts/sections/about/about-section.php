<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$about_title       = get_field( 'about_zagolovok' );
$about_description = get_field( 'about_opisanie' );
$allowed_about_html_tags = array(
	'br' => array(),
);

?>

<section class="section section-about" >

    <div class="div padding-global section-about_padding">
        <div class="div flex-direction-vertical section-about_gap-xlarge">
            <div class="div grid-4 section-about_gap-large">
                <h2 class="text heading-style-h4 text-color-grey">
                    О компании
                </h2>
                <div class="div grid_col-padding-left div--u-ilzpox96w">
                    <h3 class="text heading-style-h2 text--u-ilv3qk1pz">
                        <?php echo wp_kses( $about_title, $allowed_about_html_tags ); ?>
                    </h3>
                </div>
                <div class="div" style="grid-column: 3 / 5;grid-row: 2 / 3;">
                    <div class="div flex-direction-vertical section-about_gap-medium">
                        <div class="div flex-direction-vertical section-about_gap-small div--u-irs9pk5nk text-max-width"
                            gsap-opacity-scroll-animation="" style="opacity: 1">

                            <div class="tt-rich-text text-style-body text-color-grey" gsap-opacity-scroll-animation=""
                                rich-text="about" style="opacity: 1">
                                <div class="text-block-wrap-div">
                                    <p><?php echo wp_kses( $about_description, $allowed_about_html_tags ); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-wrapper border-radius">


                            


                        </div>
                    </div>
                </div>
            </div>
            <div class="div grid-4 grid-4--is-benefits">
                <?php if ( have_rows( 'about_priemushhestva' ) ) : ?>
                    <?php $benefit_index = 0; ?>
                    <?php while ( have_rows( 'about_priemushhestva' ) ) : the_row(); ?>
                        <?php
                        $benefit_index++;
                        $benefit_icon        = get_sub_field( 'ikonka' );
                        $benefit_title       = get_sub_field( 'zagolovok' );
                        $benefit_description = get_sub_field( 'opisanie' );
                        $benefit_card_class  = 'div benefits-card_component';
                        $benefit_icon_html   = '';

                        if ( 2 === $benefit_index ) {
                            $benefit_card_class .= ' div--u-iunsh8m2b';
                        }

                        if ( 4 === $benefit_index ) {
                            $benefit_card_class .= ' div--u-izfi6odmg';
                        }
                        ?>
                        <div class="<?php echo esc_attr( $benefit_card_class ); ?>">
                            <div class="div background-gradient-green size-height-full">
                                <div class="div padding-block-small">
                                    <div class="div flex-direction-vertical benifits-card_gap">
                                        <div class="div icon-card_component background-white">
                                            <div class="embed text-color-brand icon_full flex-center-all">
                                                <?php if ( ! empty( $benefit_icon['url'] ) ) : ?>
                                                    <?php if ( ! empty( $benefit_icon['mime_type'] ) && 'image/svg+xml' === $benefit_icon['mime_type'] && ! empty( $benefit_icon['ID'] ) ) : ?>
                                                        <?php
                                                        $benefit_icon_path = get_attached_file( $benefit_icon['ID'] );

                                                        if ( $benefit_icon_path && file_exists( $benefit_icon_path ) ) {
                                                            // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
                                                            echo file_get_contents( $benefit_icon_path ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                        }
                                                        ?>
                                                    <?php else : ?>
                                                        <?php
                                                        $benefit_icon_html = lvl_neva_get_field_image_html(
                                                            $benefit_icon,
                                                            'thumbnail',
                                                            array(
                                                                'alt'      => '',
                                                                'loading'  => 'lazy',
                                                                'decoding' => 'async',
                                                                'sizes'    => '5.7rem',
                                                            )
                                                        );
                                                        echo $benefit_icon_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                        ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="text heading-style-h5">
                                                <span class="text-block-wrap-div"><?php echo esc_html( $benefit_title ); ?></span>
                                            </h3>
                                            <div class="tt-rich-text text-style-body text-color-grey">
                                                <p><?php echo nl2br( esc_html( $benefit_description ) ); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
