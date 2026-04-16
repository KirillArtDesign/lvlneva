<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'LVL_NEVA_COOKIE_NOTICE_NAME' ) ) {
	define( 'LVL_NEVA_COOKIE_NOTICE_NAME', 'lvl_neva_cookie_notice_accepted' );
}

function lvl_neva_has_cookie_notice_consent() {
	return ! empty( $_COOKIE[ LVL_NEVA_COOKIE_NOTICE_NAME ] );
}

function lvl_neva_render_cookie_notice() {
	if ( is_admin() || lvl_neva_has_cookie_notice_consent() ) {
		return;
	}

	$privacy_policy_url   = function_exists( 'get_privacy_policy_url' ) ? get_privacy_policy_url() : '';
	$privacy_policy_label = function_exists( 'get_the_title' ) && $privacy_policy_url ? get_the_title( (int) get_option( 'wp_page_for_privacy_policy' ) ) : '';

	if ( ! $privacy_policy_url ) {
		$privacy_policy_url = home_url( '/' );
	}

	if ( ! $privacy_policy_label ) {
		$privacy_policy_label = __( 'Политика конфиденциальности', 'lvl-neva' );
	}
	?>
	<div
		class="cookie-notice"
		data-cookie-notice
		data-cookie-name="<?php echo esc_attr( LVL_NEVA_COOKIE_NOTICE_NAME ); ?>"
		role="dialog"
		aria-live="polite"
		aria-label="<?php esc_attr_e( 'Уведомление об использовании cookie', 'lvl-neva' ); ?>"
	>
		<div class="cookie-notice__content">
			<div class="cookie-notice__copy">
				<p class="cookie-notice__text">
					<?php esc_html_e( 'Мы используем cookie, чтобы сайт работал стабильнее и был удобнее для вас.', 'lvl-neva' ); ?>
				</p>
				<a class="cookie-notice__link" href="<?php echo esc_url( $privacy_policy_url ); ?>">
					<?php echo esc_html( $privacy_policy_label ); ?>
				</a>
			</div>
			<button class="cookie-notice__accept" type="button" data-cookie-notice-accept>
				<?php esc_html_e( 'Принять', 'lvl-neva' ); ?>
			</button>
		</div>
	</div>
	<?php
}
add_action( 'wp_footer', 'lvl_neva_render_cookie_notice', 5 );
