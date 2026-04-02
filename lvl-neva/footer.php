<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$footer_menu_locations = get_nav_menu_locations();
$footer_menu_one_items = array();
$footer_menu_two_items = array();
$site_phone            = function_exists( 'get_field' ) ? (string) get_field( 'nomer_telefona', 'option' ) : '';
$site_email            = function_exists( 'get_field' ) ? (string) get_field( 'pochta', 'option' ) : '';
$site_address          = function_exists( 'get_field' ) ? (string) get_field( 'adres_kompanii', 'option' ) : '';
$site_copyright        = function_exists( 'get_field' ) ? (string) get_field( 'kopirajt', 'option' ) : '';
$site_socials          = function_exists( 'get_field' ) ? get_field( 'soczialnye_seti', 'option' ) : array();
$privacy_policy_url    = function_exists( 'get_privacy_policy_url' ) ? get_privacy_policy_url() : '';
$privacy_policy_label  = function_exists( 'get_the_title' ) && $privacy_policy_url ? get_the_title( (int) get_option( 'wp_page_for_privacy_policy' ) ) : '';
$developer_url         = 'https://t.me/kirillartdesign';

if ( isset( $footer_menu_locations['footer_menu_1'] ) ) {
	$footer_menu_one_items = wp_get_nav_menu_items( $footer_menu_locations['footer_menu_1'] );
}

if ( isset( $footer_menu_locations['footer_menu_2'] ) ) {
	$footer_menu_two_items = wp_get_nav_menu_items( $footer_menu_locations['footer_menu_2'] );
}

if ( ! is_array( $footer_menu_one_items ) ) {
	$footer_menu_one_items = array();
}

if ( ! is_array( $footer_menu_two_items ) ) {
	$footer_menu_two_items = array();
}

if ( ! is_array( $site_socials ) ) {
	$site_socials = array();
}

$site_phone      = trim( $site_phone );
$site_phone_href = $site_phone ? preg_replace( '/[^0-9+]+/', '', $site_phone ) : '';
$site_email      = trim( $site_email );
$site_address    = trim( $site_address );
$site_copyright  = trim( $site_copyright );

if ( ! $site_phone ) {
	$site_phone = '8 (812) 250-73-76';
}

if ( ! $site_phone_href ) {
	$site_phone_href = '+78122507376';
}

if ( ! $site_email ) {
	$site_email = 'info@lvlneva.ru';
}

if ( ! $site_copyright ) {
	$site_copyright = date_i18n( 'Y' ) . ' © Все права защищены';
}

if ( ! $privacy_policy_label ) {
	$privacy_policy_label = __( 'Политика конфиденциальности', 'lvl-neva' );
}
?>
			<?php get_template_part( 'template-parts/sections/forms/contact-form1-section' ); ?>
			</main>
			
			<footer class="div footer_component background-white" id="i2uwtei7q_0">
				<div class="div padding-global footer_padding-medium" id="iva9807wo_0">
					<div class="div grid-4 grid-4--is-footer" id="ibc4fjm2n_0">
						<div class="div grid-4_col" id="irsbk5r43_0">
							<a class="link-block logo_component" data-action-element="" href="<?php echo esc_url( home_url( '/' ) ); ?>" id="ico2l591q_0">
								<div class="div flex-direction-horizontal flex-align-center logo_gap" id="it4gwweam_0">
									<div class="div logo_img border-radius background-brand" id="ic9o35gyr_0">
										<div class="embed icon_full text-color-white flex-center-all" id="iw0qe1aid_0">
											<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
												<rect x="0.4" y="0.4" width="39.2" height="39.2" rx="2.6" fill="#31572C" />
												<rect x="0.4" y="0.4" width="39.2" height="39.2" rx="2.6" stroke="#31572C" stroke-width="0.8" />
												<path d="M19.7773 8.2959L12.8887 13.4443L12.8516 32.0928L19.7959 32.083L19.7773 34.1484H6V15.9258L19.7773 6V8.2959ZM24.5186 9.11133V34.1484H20.2217V6L24.5186 9.11133ZM29.2588 12.5186V34.1484H24.9629V9.40723L29.2588 12.5186ZM34 15.9258V34.1475H29.7041V12.8145L34 15.9258Z" fill="white" />
											</svg>
										</div>
									</div>
									<div class="div logo_text" id="ixub3x1lb_0">
										<div class="embed logo_text-svg flex-direction-horizontal flex-align-center" id="icd29klmq_0">
											<span class="text heading-style-h6">LVL Neva</span>
										</div>
									</div>
								</div>
							</a>
						</div>

						<div class="div grid-4_col grid_col-padding-horizontal div--u-ia4lyfuvx" id="ia4lyfuvx_0">
							<div class="div flex-direction-vertical footer_gap-medium" id="ifkdvkwpg_0">
								<h5 class="text heading-style-h6 text-color-grey" id="ievc0wx7e_0"><span class="text-block-wrap-div">меню</span></h5>
								<div class="div footer_gap-small flex-direction-horizontal flex-direction-horizontal--is-footer" id="iocvhhh7c_0">
									<div class="div flex-direction-vertical footer_gap-small" id="i965cox2q_0">
										<?php foreach ( $footer_menu_one_items as $menu_item ) : ?>
											<a class="roll-link text-style-body" href="<?php echo esc_url( $menu_item->url ); ?>" data-label="<?php echo esc_attr( $menu_item->title ); ?>">
												<span class="roll-link__text"><?php echo esc_html( $menu_item->title ); ?></span>
											</a>
										<?php endforeach; ?>
									</div>
									<div class="div flex-direction-vertical footer_gap-small" id="iib5t78l7_0">
										<?php foreach ( $footer_menu_two_items as $menu_item ) : ?>
											<a class="roll-link text-style-body" href="<?php echo esc_url( $menu_item->url ); ?>" data-label="<?php echo esc_attr( $menu_item->title ); ?>">
												<span class="roll-link__text"><?php echo esc_html( $menu_item->title ); ?></span>
											</a>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
						</div>

						<div class="div grid-4_col grid_col-padding-horizontal div--u-i4u0z48q2" id="i4u0z48q2_0">
							<div class="div flex-direction-vertical footer_gap-medium" id="i3sjtrjh3_0">
								<h5 class="text heading-style-h6 text-color-grey" id="ilbs5vut6_0"><span class="text-block-wrap-div">Соцсети</span></h5>
								<div class="div flex-direction-vertical footer_gap-small" id="itx1yfifl_0">
									<?php foreach ( $site_socials as $social_item ) : ?>
										<?php
										$social_title = isset( $social_item['nazvanie'] ) ? trim( (string) $social_item['nazvanie'] ) : '';
										$social_url   = isset( $social_item['ssylka'] ) ? trim( (string) $social_item['ssylka'] ) : '';

										if ( '' === $social_title || '' === $social_url ) {
											continue;
										}
										?>
										<a class="roll-link text-style-body" href="<?php echo esc_url( $social_url ); ?>" target="_blank" rel="noopener noreferrer" data-label="<?php echo esc_attr( $social_title ); ?>">
											<span class="roll-link__text"><?php echo esc_html( $social_title ); ?></span>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						</div>

						<div class="div grid-4_col grid_col-padding-left div--u-i23i7nbea" id="i23i7nbea_0">
							<div class="div flex-direction-vertical footer_gap-medium" id="i09f1w646_0">
								<h5 class="text heading-style-h6 text-color-grey" id="iqolerhm8_0"><span class="text-block-wrap-div">Для связи</span></h5>
								<div class="div flex-direction-vertical footer_gap-small" id="il4scap9k_0">
									<a href="tel:<?php echo esc_attr( $site_phone_href ); ?>" class="roll-link text-style-body" data-label="<?php echo esc_attr( $site_phone ); ?>">
										<span class="roll-link__text"><?php echo esc_html( $site_phone ); ?></span>
									</a>
									<a href="mailto:<?php echo esc_attr( antispambot( $site_email ) ); ?>" class="roll-link text-style-body" data-label="<?php echo esc_attr( $site_email ); ?>">
										<span class="roll-link__text"><?php echo esc_html( antispambot( $site_email ) ); ?></span>
									</a>
									<div class="text text-style-body text-color-grey" id="i0lswocb5_0"><span class="text-block-wrap-div">Адрес</span></div>
									<div class="div footer_gap-xsmall flex-direction-vertical" id="idp97b7gt_0">
										<div class="text text-style-body" id="irufeekd4_0">
											<span class="text-block-wrap-div"><?php echo wp_kses( nl2br( esc_html( $site_address ) ), array( 'br' => array() ) ); ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="div padding-global footer_padding-small border-top" id="iqu2k0w5a_0">
					<div class="div grid-4 grid-4--is-footer grid-4--is-credit" id="i6kqnjutb_0">
						<div class="div grid-4_col" id="in47miqa2_0">
							<div class="text text-style-body text-color-grey" id="ik46k9ipp_0">
								<span class="text-block-wrap-div"><?php echo esc_html( $site_copyright ); ?></span>
							</div>
						</div>
						<div class="div grid-4_col grid_col-padding-horizontal show-on-desktop" id="ifx1wfzk8_0"></div>
						<div class="div grid-4_col grid_col-padding-horizontal div--u-idmpx1hh2" id="idmpx1hh2_0">
							<a class="link text-style-body link-text-grey__hover text-color-grey" href="<?php echo esc_url( $privacy_policy_url ? $privacy_policy_url : home_url( '/' ) ); ?>">
								<span class="text-block-wrap-div"><?php echo esc_html( $privacy_policy_label ); ?></span>
							</a>
						</div>
						<div class="div grid-4_col grid_col-padding-left div--u-iekexfzrk" id="iekexfzrk_0">
							<div class="div flex-direction-horizontal footer_gap-xxsmall flex-align-center" id="iqfzq9di8_0">
								<a class="roll-link text-style-body" href="<?php echo esc_url( $developer_url ); ?>" target="_blank" rel="noopener noreferrer" data-label="Разработка сайта">
									<span class="roll-link__text">Разработка сайта</span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</footer>
			<?php get_template_part( 'template-parts/shared/search-drawer' ); ?>
			<?php get_template_part( 'template-parts/shared/cart-drawer' ); ?>
			<?php get_template_part( 'template-parts/shared/contact-drawer' ); ?>
		</div>
	</div>
</div>
<?php wp_footer(); ?>
</body>
</html>
