<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'lvl_neva_get_cart_drawer_count' ) ) {
	function lvl_neva_get_cart_drawer_count() {
		if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
			return 0;
		}

		return max( 0, (int) WC()->cart->get_cart_contents_count() );
	}
}

if ( ! function_exists( 'lvl_neva_render_cart_drawer_count_badge' ) ) {
	function lvl_neva_render_cart_drawer_count_badge( $count = null ) {
		if ( null === $count ) {
			$count = lvl_neva_get_cart_drawer_count();
		}

		$count   = max( 0, (int) $count );
		$classes = 'site-cart-trigger__count';

		if ( $count > 0 ) {
			$classes .= ' is-visible';
		}

		return sprintf(
			'<span class="%1$s" data-cart-drawer-count aria-hidden="true"%2$s>%3$s</span>',
			esc_attr( $classes ),
			$count > 0 ? '' : ' hidden',
			esc_html( number_format_i18n( $count ) )
		);
	}
}

if ( ! function_exists( 'lvl_neva_get_cart_drawer_shop_url' ) ) {
	function lvl_neva_get_cart_drawer_shop_url() {
		if ( function_exists( 'lvl_neva_get_shop_archive_url' ) ) {
			return lvl_neva_get_shop_archive_url();
		}

		return home_url( '/' );
	}
}

if ( ! function_exists( 'lvl_neva_get_cart_drawer_response_data' ) ) {
	function lvl_neva_get_cart_drawer_response_data( $html = null, $count = null ) {
		return array(
			'html'  => null === $html ? lvl_neva_render_cart_drawer_markup() : (string) $html,
			'count' => null === $count ? lvl_neva_get_cart_drawer_count() : max( 0, (int) $count ),
		);
	}
}

if ( ! function_exists( 'lvl_neva_get_cart_drawer_checkout_prefill' ) ) {
	function lvl_neva_get_cart_drawer_checkout_prefill() {
		$values = array(
			'name'    => '',
			'phone'   => '',
			'email'   => '',
			'comment' => '',
		);

		if ( function_exists( 'WC' ) && WC()->customer ) {
			$customer_name  = trim( WC()->customer->get_billing_first_name() . ' ' . WC()->customer->get_billing_last_name() );
			$values['name'] = $customer_name ? $customer_name : '';
			$values['phone'] = (string) WC()->customer->get_billing_phone();
			$values['email'] = (string) WC()->customer->get_billing_email();
		}

		if ( is_user_logged_in() ) {
			$current_user = wp_get_current_user();

			if ( ! $values['name'] && $current_user instanceof WP_User ) {
				$values['name'] = $current_user->display_name ? $current_user->display_name : $current_user->user_login;
			}

			if ( ! $values['email'] && $current_user instanceof WP_User ) {
				$values['email'] = (string) $current_user->user_email;
			}
		}

		return $values;
	}
}

if ( ! function_exists( 'lvl_neva_render_cart_drawer_empty_markup' ) ) {
	function lvl_neva_render_cart_drawer_empty_markup() {
		$shop_url = lvl_neva_get_cart_drawer_shop_url();

		ob_start();
		?>
		<div class="site-cart-drawer__empty">
			<div class="site-cart-drawer__empty-text"><?php esc_html_e( 'В корзине пока нет товаров', 'lvl-neva' ); ?></div>
			<a class="nav-btn text-style-body product-purchase__submit site-cart-drawer__checkout" href="<?php echo esc_url( $shop_url ); ?>">
				<span class="nav-btn__label" data-label="<?php esc_attr_e( 'Перейти в каталог', 'lvl-neva' ); ?>">
					<span class="nav-btn__label-text"><?php esc_html_e( 'Перейти в каталог', 'lvl-neva' ); ?></span>
				</span>
				<span class="nav-btn__icon" aria-hidden="true">
					<svg class="nav-btn__icon-svg nav-btn__icon-svg--default" fill="none" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
						<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
					</svg>
					<svg class="nav-btn__icon-svg nav-btn__icon-svg--hover" fill="none" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
						<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
					</svg>
				</span>
			</a>
		</div>
		<?php

		return ob_get_clean();
	}
}

if ( ! function_exists( 'lvl_neva_render_cart_drawer_checkout_form' ) ) {
	function lvl_neva_render_cart_drawer_checkout_form( $values = array() ) {
		$defaults = lvl_neva_get_cart_drawer_checkout_prefill();
		$values   = wp_parse_args( array_filter( $values, 'is_scalar' ), $defaults );

		ob_start();
		?>
		<div class="site-cart-drawer__checkout-view" data-cart-drawer-view="checkout" hidden>
			<button type="button" class="roll-link text-style-body site-cart-drawer__text-action" data-cart-drawer-back data-label="<?php esc_attr_e( 'Назад к корзине', 'lvl-neva' ); ?>">
				<span class="roll-link__text"><?php esc_html_e( 'Назад к корзине', 'lvl-neva' ); ?></span>
			</button>

			<form class="form__state-default site-cart-drawer__checkout-form" data-cart-drawer-checkout-form form-white-theme novalidate>
				<div class="div flex-direction-vertical form_gap-medium site-cart-drawer__checkout-form-inner">
					<div class="site-cart-drawer__checkout-heading">
						<div class="site-cart-drawer__title site-cart-drawer__title--form"><?php esc_html_e( 'Оформление заказа', 'lvl-neva' ); ?></div>
						<div class="site-cart-drawer__checkout-text"><?php esc_html_e( 'Оставьте контакты, и мы свяжемся с вами для подтверждения заказа.', 'lvl-neva' ); ?></div>
					</div>

					<div class="site-cart-drawer__form-message" data-cart-drawer-form-message hidden></div>

					<div class="div form_grid site-cart-drawer__form-grid">
						<div class="form__field form_input-group flex-direction-vertical color-inherit site-cart-drawer__field" data-cart-drawer-field="name" data-type-field="text">
							<div class="text-subtitle text-style-caption form_input-label text-color-white-opacity">
								<span class="text-block-wrap-div"><?php esc_html_e( 'Имя', 'lvl-neva' ); ?></span>
							</div>
							<input class="form__input form_input text-style-body" name="name" placeholder="<?php esc_attr_e( 'Ваше имя', 'lvl-neva' ); ?>" type="text" value="<?php echo esc_attr( (string) $values['name'] ); ?>" autocomplete="name">
							<div class="form__field-error" data-cart-drawer-field-error><?php esc_html_e( 'Укажите имя', 'lvl-neva' ); ?></div>
						</div>

						<div class="form__field form_input-group flex-direction-vertical color-inherit site-cart-drawer__field" data-cart-drawer-field="email" data-type-field="email">
							<div class="text-subtitle text-style-caption form_input-label text-color-white-opacity">
								<span class="text-block-wrap-div"><?php esc_html_e( 'Почта', 'lvl-neva' ); ?></span>
							</div>
							<input class="form__input form_input text-style-body" name="email" placeholder="Email" type="email" value="<?php echo esc_attr( (string) $values['email'] ); ?>" autocomplete="email">
							<div class="form__field-error" data-cart-drawer-field-error><?php esc_html_e( 'Некорректный email', 'lvl-neva' ); ?></div>
						</div>

						<div class="form__field form_input-group flex-direction-vertical color-inherit site-cart-drawer__field" data-cart-drawer-field="phone" data-type-field="tel">
							<div class="text-subtitle text-style-caption form_input-label text-color-white-opacity">
								<span class="text-block-wrap-div"><?php esc_html_e( 'Телефон', 'lvl-neva' ); ?></span>
							</div>
							<input class="form__input form_input text-style-body" name="phone" placeholder="<?php esc_attr_e( 'Телефон', 'lvl-neva' ); ?>" type="tel" value="<?php echo esc_attr( (string) $values['phone'] ); ?>" autocomplete="tel">
							<div class="form__field-error" data-cart-drawer-field-error><?php esc_html_e( 'Укажите телефон', 'lvl-neva' ); ?></div>
						</div>

						<div class="form__field form_input-group flex-direction-vertical color-inherit site-cart-drawer__field site-cart-drawer__field--comment" data-cart-drawer-field="comment" data-type-field="textarea">
							<div class="text-subtitle text-style-caption form_input-label text-color-white-opacity">
								<span class="text-block-wrap-div"><?php esc_html_e( 'Комментарий', 'lvl-neva' ); ?></span>
							</div>
							<textarea class="form__textarea text-style-body form_input form_input--is-message site-cart-drawer__textarea" name="comment" placeholder="<?php esc_attr_e( 'Комментарий', 'lvl-neva' ); ?>"><?php echo esc_textarea( (string) $values['comment'] ); ?></textarea>
							<div class="form__field-error" data-cart-drawer-field-error><?php esc_html_e( 'Заполните поле', 'lvl-neva' ); ?></div>
						</div>
					</div>

					<div class="site-cart-drawer__checkout-footer">
						<div class="site-cart-drawer__summary">
							<div class="site-cart-drawer__summary-label"><?php esc_html_e( 'Итого', 'lvl-neva' ); ?></div>
							<div class="site-cart-drawer__summary-value">
								<?php echo function_exists( 'WC' ) && WC()->cart ? wp_kses_post( WC()->cart->get_cart_subtotal() ) : ''; ?>
							</div>
						</div>

						<button class="nav-btn text-style-body product-purchase__submit site-cart-drawer__checkout-submit" type="submit" data-cart-drawer-checkout-submit>
							<span class="nav-btn__label" data-label="<?php esc_attr_e( 'Отправить заказ', 'lvl-neva' ); ?>">
								<span class="nav-btn__label-text"><?php esc_html_e( 'Отправить заказ', 'lvl-neva' ); ?></span>
							</span>
							<span class="nav-btn__icon" aria-hidden="true">
								<svg class="nav-btn__icon-svg nav-btn__icon-svg--default" fill="none" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
									<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
								</svg>
								<svg class="nav-btn__icon-svg nav-btn__icon-svg--hover" fill="none" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
									<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
								</svg>
							</span>
						</button>
					</div>
				</div>
			</form>
		</div>
		<?php

		return ob_get_clean();
	}
}

if ( ! function_exists( 'lvl_neva_render_cart_drawer_success_markup' ) ) {
	function lvl_neva_render_cart_drawer_success_markup( WC_Order $order ) {
		$shop_url = lvl_neva_get_cart_drawer_shop_url();

		ob_start();
		?>
		<div class="site-cart-drawer__success">
			<div class="site-cart-drawer__success-title"><?php esc_html_e( 'Заказ отправлен', 'lvl-neva' ); ?></div>
			<div class="site-cart-drawer__success-text"><?php esc_html_e( 'Мы получили вашу заявку и свяжемся с вами в ближайшее время.', 'lvl-neva' ); ?></div>
			<div class="site-cart-drawer__success-order">
				<?php
				echo esc_html(
					sprintf(
						/* translators: %s: order number */
						__( 'Номер заказа: #%s', 'lvl-neva' ),
						$order->get_order_number()
					)
				);
				?>
			</div>
			<a class="nav-btn text-style-body product-purchase__submit site-cart-drawer__checkout" href="<?php echo esc_url( $shop_url ); ?>">
				<span class="nav-btn__label" data-label="<?php esc_attr_e( 'Вернуться в каталог', 'lvl-neva' ); ?>">
					<span class="nav-btn__label-text"><?php esc_html_e( 'Вернуться в каталог', 'lvl-neva' ); ?></span>
				</span>
				<span class="nav-btn__icon" aria-hidden="true">
					<svg class="nav-btn__icon-svg nav-btn__icon-svg--default" fill="none" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
						<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
					</svg>
					<svg class="nav-btn__icon-svg nav-btn__icon-svg--hover" fill="none" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
						<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
					</svg>
				</span>
			</a>
		</div>
		<?php

		return ob_get_clean();
	}
}

if ( ! function_exists( 'lvl_neva_validate_cart_drawer_checkout_payload' ) ) {
	function lvl_neva_validate_cart_drawer_checkout_payload( $request_data ) {
		$values = array(
			'name'    => isset( $request_data['name'] ) ? sanitize_text_field( wp_unslash( $request_data['name'] ) ) : '',
			'phone'   => isset( $request_data['phone'] ) ? sanitize_text_field( wp_unslash( $request_data['phone'] ) ) : '',
			'email'   => isset( $request_data['email'] ) ? sanitize_email( wp_unslash( $request_data['email'] ) ) : '',
			'comment' => isset( $request_data['comment'] ) ? sanitize_textarea_field( wp_unslash( $request_data['comment'] ) ) : '',
		);
		$errors = array();

		if ( '' === $values['name'] ) {
			$errors['name'] = __( 'Укажите имя', 'lvl-neva' );
		}

		$phone_digits = preg_replace( '/\D+/', '', $values['phone'] );

		if ( '' === $values['phone'] || strlen( (string) $phone_digits ) < 5 ) {
			$errors['phone'] = __( 'Укажите телефон', 'lvl-neva' );
		}

		if ( '' !== $values['email'] && ! is_email( $values['email'] ) ) {
			$errors['email'] = __( 'Некорректный email', 'lvl-neva' );
		}

		return array(
			'values' => $values,
			'errors' => $errors,
		);
	}
}

if ( ! function_exists( 'lvl_neva_create_order_from_cart_drawer' ) ) {
	function lvl_neva_create_order_from_cart_drawer( $values ) {
		if ( ! function_exists( 'WC' ) || ! WC()->cart || 0 === lvl_neva_get_cart_drawer_count() ) {
			return new WP_Error( 'empty_cart', __( 'Корзина пуста', 'lvl-neva' ) );
		}

		$order = wc_create_order();

		if ( is_wp_error( $order ) || ! $order instanceof WC_Order ) {
			return new WP_Error( 'order_create_failed', __( 'Не удалось создать заказ', 'lvl-neva' ) );
		}

		$cart_items   = WC()->cart->get_cart();
		$items_added  = 0;

		foreach ( $cart_items as $cart_item ) {
			$line_product = null;

			if ( ! empty( $cart_item['variation_id'] ) ) {
				$line_product = wc_get_product( (int) $cart_item['variation_id'] );
			}

			if ( ! $line_product instanceof WC_Product ) {
				$line_product = $cart_item['data'] ?? null;
			}

			if ( ! $line_product instanceof WC_Product ) {
				continue;
			}

			$item_id = $order->add_product(
				$line_product,
				max( 1, (int) ( $cart_item['quantity'] ?? 1 ) ),
				array(
					'variation' => isset( $cart_item['variation'] ) && is_array( $cart_item['variation'] ) ? $cart_item['variation'] : array(),
				)
			);

			if ( ! $item_id ) {
				continue;
			}

			++$items_added;

			if ( ! empty( $cart_item['lvl_neva_additional_service_title'] ) ) {
				$order_item = $order->get_item( $item_id );

				if ( $order_item instanceof WC_Order_Item_Product ) {
					$order_item->add_meta_data(
						__( 'Дополнительная услуга', 'lvl-neva' ),
						wp_strip_all_tags( (string) $cart_item['lvl_neva_additional_service_title'] ),
						true
					);
					$order_item->save();
				}
			}
		}

		if ( 0 === $items_added ) {
			$order->delete( true );

			return new WP_Error( 'order_empty', __( 'Не удалось добавить товары в заказ', 'lvl-neva' ) );
		}

		$order->set_address(
			array(
				'first_name' => (string) $values['name'],
				'phone'      => (string) $values['phone'],
				'email'      => (string) $values['email'],
			),
			'billing'
		);

		$order->set_customer_note( (string) $values['comment'] );
		$order->set_created_via( 'lvl_neva_cart_drawer' );
		$order->calculate_totals();
		$order->update_status( 'on-hold', __( 'Заказ оформлен через drawer без онлайн-оплаты.', 'lvl-neva' ) );

		WC()->cart->empty_cart();

		return $order;
	}
}

if ( ! function_exists( 'lvl_neva_render_cart_drawer_markup' ) ) {
	function lvl_neva_render_cart_drawer_markup() {
		$cart_count = lvl_neva_get_cart_drawer_count();

		ob_start();

		if ( ! function_exists( 'WC' ) || ! WC()->cart || 0 === $cart_count ) {
			echo lvl_neva_render_cart_drawer_empty_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			return ob_get_clean();
		}

		$cart_items = WC()->cart->get_cart();
		?>
		<div class="site-cart-drawer__views">
			<div class="site-cart-drawer__state" data-cart-drawer-view="cart">
				<div class="site-cart-drawer__list">
					<?php foreach ( $cart_items as $cart_item_key => $cart_item ) : ?>
						<?php
						get_template_part(
							'template-parts/cards/cart-drawer-product-card',
							null,
							array(
								'cart_item_key' => $cart_item_key,
								'cart_item'     => $cart_item,
							)
						);
						?>
					<?php endforeach; ?>
				</div>

				<div class="site-cart-drawer__footer">
					<div class="site-cart-drawer__summary">
						<div class="site-cart-drawer__summary-label"><?php esc_html_e( 'Итого', 'lvl-neva' ); ?></div>
						<div class="site-cart-drawer__summary-value"><?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?></div>
					</div>

					<div class="site-cart-drawer__actions">
						<button class="nav-btn text-style-body product-purchase__submit site-cart-drawer__checkout" type="button" data-cart-drawer-open-checkout>
							<span class="nav-btn__label" data-label="<?php esc_attr_e( 'Оформить заказ', 'lvl-neva' ); ?>">
								<span class="nav-btn__label-text"><?php esc_html_e( 'Оформить заказ', 'lvl-neva' ); ?></span>
							</span>
							<span class="nav-btn__icon" aria-hidden="true">
								<svg class="nav-btn__icon-svg nav-btn__icon-svg--default" fill="none" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
									<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
								</svg>
								<svg class="nav-btn__icon-svg nav-btn__icon-svg--hover" fill="none" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
									<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
								</svg>
							</span>
						</button>

						<button type="button" class="roll-link text-style-body site-cart-drawer__text-action" data-cart-drawer-close data-label="<?php esc_attr_e( 'Продолжить покупки', 'lvl-neva' ); ?>">
							<span class="roll-link__text"><?php esc_html_e( 'Продолжить покупки', 'lvl-neva' ); ?></span>
						</button>
					</div>
				</div>
			</div>

			<?php echo lvl_neva_render_cart_drawer_checkout_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<?php

		return ob_get_clean();
	}
}

if ( ! function_exists( 'lvl_neva_handle_get_cart_drawer_ajax' ) ) {
	function lvl_neva_handle_get_cart_drawer_ajax() {
		check_ajax_referer( 'lvl_neva_cart_drawer', 'nonce' );

		wp_send_json_success( lvl_neva_get_cart_drawer_response_data() );
	}
}
add_action( 'wp_ajax_lvl_neva_get_cart_drawer', 'lvl_neva_handle_get_cart_drawer_ajax' );
add_action( 'wp_ajax_nopriv_lvl_neva_get_cart_drawer', 'lvl_neva_handle_get_cart_drawer_ajax' );

if ( ! function_exists( 'lvl_neva_handle_remove_cart_item_ajax' ) ) {
	function lvl_neva_handle_remove_cart_item_ajax() {
		check_ajax_referer( 'lvl_neva_cart_drawer', 'nonce' );

		$cart_item_key = isset( $_POST['cart_item_key'] ) ? wc_clean( wp_unslash( $_POST['cart_item_key'] ) ) : '';

		if ( $cart_item_key && function_exists( 'WC' ) && WC()->cart ) {
			$cart_items = WC()->cart->get_cart();

			if ( isset( $cart_items[ $cart_item_key ] ) ) {
				WC()->cart->remove_cart_item( $cart_item_key );
				WC()->cart->calculate_totals();
			}
		}

		wp_send_json_success( lvl_neva_get_cart_drawer_response_data() );
	}
}
add_action( 'wp_ajax_lvl_neva_remove_cart_item', 'lvl_neva_handle_remove_cart_item_ajax' );
add_action( 'wp_ajax_nopriv_lvl_neva_remove_cart_item', 'lvl_neva_handle_remove_cart_item_ajax' );

if ( ! function_exists( 'lvl_neva_handle_update_cart_item_quantity_ajax' ) ) {
	function lvl_neva_handle_update_cart_item_quantity_ajax() {
		check_ajax_referer( 'lvl_neva_cart_drawer', 'nonce' );

		$cart_item_key = isset( $_POST['cart_item_key'] ) ? wc_clean( wp_unslash( $_POST['cart_item_key'] ) ) : '';
		$quantity      = isset( $_POST['quantity'] ) ? max( 1, absint( wp_unslash( $_POST['quantity'] ) ) ) : 1;

		if ( ! $cart_item_key || ! function_exists( 'WC' ) || ! WC()->cart ) {
			wp_send_json_error(
				array(
					'message' => __( 'Не удалось обновить количество.', 'lvl-neva' ),
				),
				400
			);
		}

		$cart_items = WC()->cart->get_cart();

		if ( empty( $cart_items[ $cart_item_key ] ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Товар не найден в корзине.', 'lvl-neva' ),
				),
				404
			);
		}

		WC()->cart->set_quantity( $cart_item_key, $quantity, true );
		WC()->cart->calculate_totals();

		wp_send_json_success( lvl_neva_get_cart_drawer_response_data() );
	}
}
add_action( 'wp_ajax_lvl_neva_update_cart_item_quantity', 'lvl_neva_handle_update_cart_item_quantity_ajax' );
add_action( 'wp_ajax_nopriv_lvl_neva_update_cart_item_quantity', 'lvl_neva_handle_update_cart_item_quantity_ajax' );

if ( ! function_exists( 'lvl_neva_handle_submit_cart_checkout_ajax' ) ) {
	function lvl_neva_handle_submit_cart_checkout_ajax() {
		check_ajax_referer( 'lvl_neva_cart_drawer', 'nonce' );

		$validated = lvl_neva_validate_cart_drawer_checkout_payload( $_POST );
		$values    = $validated['values'];
		$errors    = $validated['errors'];

		if ( ! function_exists( 'WC' ) || ! WC()->cart || 0 === lvl_neva_get_cart_drawer_count() ) {
			wp_send_json_error(
				array(
					'message' => __( 'Корзина пуста. Добавьте товары перед оформлением заказа.', 'lvl-neva' ),
					'errors'  => array(),
				),
				400
			);
		}

		if ( ! empty( $errors ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Проверьте заполнение формы.', 'lvl-neva' ),
					'errors'  => $errors,
				),
				400
			);
		}

		$order = lvl_neva_create_order_from_cart_drawer( $values );

		if ( is_wp_error( $order ) ) {
			wp_send_json_error(
				array(
					'message' => $order->get_error_message(),
					'errors'  => array(),
				),
				400
			);
		}

		wp_send_json_success(
			lvl_neva_get_cart_drawer_response_data(
				lvl_neva_render_cart_drawer_success_markup( $order ),
				0
			)
		);
	}
}
add_action( 'wp_ajax_lvl_neva_submit_cart_checkout', 'lvl_neva_handle_submit_cart_checkout_ajax' );
add_action( 'wp_ajax_nopriv_lvl_neva_submit_cart_checkout', 'lvl_neva_handle_submit_cart_checkout_ajax' );
