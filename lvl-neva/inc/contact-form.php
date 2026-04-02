<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'lvl_neva_get_contact_form_privacy_policy_url' ) ) {
	function lvl_neva_get_contact_form_privacy_policy_url() {
		$privacy_policy_url = function_exists( 'get_privacy_policy_url' ) ? get_privacy_policy_url() : '';

		if ( ! $privacy_policy_url ) {
			$privacy_policy_url = home_url( '/' );
		}

		return $privacy_policy_url;
	}
}

if ( ! function_exists( 'lvl_neva_get_contact_form_recipient' ) ) {
	function lvl_neva_get_contact_form_recipient() {
		$recipient = '';

		if ( function_exists( 'get_field' ) ) {
			$recipient = trim( (string) get_field( 'pochta_dlya_uvedomlenij', 'option' ) );

			if ( '' === $recipient ) {
				$recipient = trim( (string) get_field( 'pochta', 'option' ) );
			}
		}

		$recipient = sanitize_email( $recipient );

		if ( ! $recipient ) {
			$recipient = sanitize_email( (string) get_option( 'admin_email' ) );
		}

		return (string) apply_filters( 'lvl_neva_contact_form_recipient', $recipient );
	}
}

if ( ! function_exists( 'lvl_neva_validate_contact_form_payload' ) ) {
	function lvl_neva_validate_contact_form_payload( $payload ) {
		$payload = is_array( $payload ) ? $payload : array();
		$email   = trim( (string) ( $payload['email'] ?? '' ) );

		$data = array(
			'name'       => sanitize_text_field( trim( (string) ( $payload['name'] ?? '' ) ) ),
			'email'      => sanitize_email( $email ),
			'phone'      => sanitize_text_field( trim( (string) ( $payload['phone'] ?? '' ) ) ),
			'comment'    => sanitize_textarea_field( trim( (string) ( $payload['comment'] ?? '' ) ) ),
			'page_url'   => esc_url_raw( trim( (string) ( $payload['page_url'] ?? '' ) ) ),
			'page_title' => sanitize_text_field( trim( (string) ( $payload['page_title'] ?? '' ) ) ),
			'website'    => sanitize_text_field( trim( (string) ( $payload['website'] ?? '' ) ) ),
			'consent'    => ! empty( $payload['consent'] ),
		);

		$errors = array();

		if ( '' === $data['name'] ) {
			$errors['name'] = __( 'Укажите имя', 'lvl-neva' );
		}

		$phone_digits = preg_replace( '/\D+/', '', $data['phone'] );

		if ( '' === $data['phone'] || strlen( (string) $phone_digits ) < 5 ) {
			$errors['phone'] = __( 'Укажите телефон', 'lvl-neva' );
		}

		if ( '' !== $email && ! is_email( $email ) ) {
			$errors['email'] = __( 'Некорректный формат почты', 'lvl-neva' );
		}

		if ( ! $data['consent'] ) {
			$errors['consent'] = __( 'Подтвердите согласие на обработку персональных данных', 'lvl-neva' );
		}

		if ( '' !== $data['website'] ) {
			$errors['form'] = __( 'Не удалось отправить форму. Попробуйте ещё раз.', 'lvl-neva' );
		}

		return array(
			'data'   => $data,
			'errors' => $errors,
		);
	}
}

if ( ! function_exists( 'lvl_neva_build_contact_form_mail_subject' ) ) {
	function lvl_neva_build_contact_form_mail_subject( $submission ) {
		$site_name = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );

		return (string) apply_filters(
			'lvl_neva_contact_form_subject',
			sprintf( 'Новая заявка с сайта %s', $site_name ),
			$submission
		);
	}
}

if ( ! function_exists( 'lvl_neva_build_contact_form_mail_body' ) ) {
	function lvl_neva_build_contact_form_mail_body( $submission ) {
		$lines = array(
			'Новая заявка с формы обратной связи',
			'',
			'Имя: ' . ( $submission['name'] ? $submission['name'] : 'Не указано' ),
			'Телефон: ' . ( $submission['phone'] ? $submission['phone'] : 'Не указан' ),
			'Почта: ' . ( $submission['email'] ? $submission['email'] : 'Не указана' ),
			'Комментарий: ' . ( $submission['comment'] ? $submission['comment'] : 'Не указан' ),
		);

		if ( ! empty( $submission['page_title'] ) ) {
			$lines[] = 'Страница: ' . $submission['page_title'];
		}

		if ( ! empty( $submission['page_url'] ) ) {
			$lines[] = 'URL страницы: ' . $submission['page_url'];
		}

		$lines[] = 'Дата: ' . wp_date( 'd.m.Y H:i' );

		return (string) apply_filters(
			'lvl_neva_contact_form_body',
			implode( PHP_EOL, $lines ),
			$submission
		);
	}
}

if ( ! function_exists( 'lvl_neva_send_contact_form_email' ) ) {
	function lvl_neva_send_contact_form_email( $submission ) {
		$recipient = lvl_neva_get_contact_form_recipient();

		if ( ! $recipient ) {
			return false;
		}

		$headers = array(
			'Content-Type: text/plain; charset=UTF-8',
		);

		if ( ! empty( $submission['email'] ) && is_email( $submission['email'] ) ) {
			$reply_name = $submission['name'] ? $submission['name'] : 'Отправитель';
			$headers[]  = sprintf( 'Reply-To: %s <%s>', $reply_name, $submission['email'] );
		}

		return wp_mail(
			$recipient,
			lvl_neva_build_contact_form_mail_subject( $submission ),
			lvl_neva_build_contact_form_mail_body( $submission ),
			$headers
		);
	}
}

if ( ! function_exists( 'lvl_neva_handle_contact_form_ajax' ) ) {
	function lvl_neva_handle_contact_form_ajax() {
		check_ajax_referer( 'lvl_neva_contact_form', 'nonce' );

		$validation = lvl_neva_validate_contact_form_payload( wp_unslash( $_POST ) );
		$submission = $validation['data'];
		$errors     = $validation['errors'];

		if ( ! empty( $errors ) ) {
			wp_send_json_error(
				array(
					'errors'  => $errors,
					'message' => __( 'Проверьте заполнение формы.', 'lvl-neva' ),
				),
				400
			);
		}

		$mail_sent = lvl_neva_send_contact_form_email( $submission );

		if ( ! $mail_sent ) {
			wp_send_json_error(
				array(
					'errors'  => array(),
					'message' => __( 'Не удалось отправить форму. Попробуйте ещё раз.', 'lvl-neva' ),
				),
				500
			);
		}

		/**
		 * Hook for future CRM integrations.
		 *
		 * @param array $submission Данные формы.
		 */
		do_action( 'lvl_neva_contact_form_submitted', $submission );

		wp_send_json_success(
			array(
				'message' => __( 'Спасибо! Заявка отправлена. Мы свяжемся с вами в ближайшее время.', 'lvl-neva' ),
			)
		);
	}
}
add_action( 'wp_ajax_lvl_neva_submit_contact_form', 'lvl_neva_handle_contact_form_ajax' );
add_action( 'wp_ajax_nopriv_lvl_neva_submit_contact_form', 'lvl_neva_handle_contact_form_ajax' );
