<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'lvl_neva_render_contact_drawer_form_markup' ) ) {
	function lvl_neva_render_contact_drawer_form_markup() {
		$privacy_policy_url = function_exists( 'lvl_neva_get_contact_form_privacy_policy_url' )
			? lvl_neva_get_contact_form_privacy_policy_url()
			: home_url( '/' );

		ob_start();
		?>
		<div class="form form_component form--u-ik9et6wvg site-contact-drawer__form-component" data-lvl-neva-contact-form-wrap>
			<form action="#" class="form__state-default site-contact-drawer__form" data-lvl-neva-contact-form form-white-theme novalidate>
				<div class="div flex-direction-vertical form_gap-medium site-contact-drawer__form-inner">
					<div class="text heading-style-h2 heading-style-h2--form site-contact-drawer__form-title">
						Остались вопросы? Свяжитесь с нами
					</div>

					<input type="hidden" name="website" value="" tabindex="-1" autocomplete="off">

					<div class="div form_grid site-contact-drawer__form-grid">
						<div class="form__field form_input-group flex-direction-vertical color-inherit" data-lvl-neva-contact-field="name" data-type-field="text">
							<div class="text-subtitle text-style-caption form_input-label">
								<span class="text-block-wrap-div text-color-grey">Имя</span>
							</div>
							<input class="form__input form_input text-style-body" name="name" placeholder="Ваше имя" type="text" autocomplete="name" required>
							<div class="form__field-error" data-lvl-neva-contact-error>
								<span class="text-block-wrap-div">Обязательное поле</span>
							</div>
							<div class="text-subtitle text-style-caption text-color-error form_input-error">
								<span class="text-block-wrap-div">Некорректный формат</span>
							</div>
						</div>

						<div class="form__field form_input-group flex-direction-vertical color-inherit" data-lvl-neva-contact-field="email" data-type-field="email">
							<div class="text-subtitle text-style-caption form_input-label">
								<span class="text-block-wrap-div text-color-grey">Почта</span>
							</div>
							<input class="form__input form_input text-style-body" name="email" placeholder="Почта" type="email" autocomplete="email">
							<div class="form__field-error" data-lvl-neva-contact-error>
								<span class="text-block-wrap-div">Обязательное поле</span>
							</div>
							<div class="text-subtitle text-style-caption text-color-error form_input-error">
								<span class="text-block-wrap-div">Некорректный формат</span>
							</div>
						</div>

						<div class="form__field form_input-group flex-direction-vertical color-inherit" data-lvl-neva-contact-field="phone" data-type-field="tel">
							<div class="text-subtitle text-style-caption form_input-label">
								<span class="text-block-wrap-div text-color-grey">Телефон</span>
							</div>
							<input class="form__input form_input text-style-body" name="phone" placeholder="Телефон" type="tel" inputmode="tel" autocomplete="tel" required>
							<div class="form__field-error" data-lvl-neva-contact-error>
								<span class="text-block-wrap-div">Обязательное поле</span>
							</div>
							<div class="text-subtitle text-style-caption text-color-error form_input-error">
								<span class="text-block-wrap-div">Некорректный формат</span>
							</div>
						</div>

						<div class="form__field form_input-group flex-direction-vertical color-inherit site-contact-drawer__field--comment" data-lvl-neva-contact-field="comment" data-type-field="textarea">
							<div class="text-subtitle text-style-caption form_input-label">
								<span class="text-block-wrap-div text-color-grey">Комментарий</span>
							</div>
							<textarea class="form__textarea text-style-body form_input form_input--is-message site-contact-drawer__textarea" name="comment" placeholder="Сообщение"></textarea>
							<div class="form__field-error" data-lvl-neva-contact-error>
								<span class="text-block-wrap-div">Обязательное поле</span>
							</div>
							<div class="text-subtitle text-style-caption text-color-error form_input-error">
								<span class="text-block-wrap-div">Некорректный формат</span>
							</div>
						</div>
					</div>

					<div checkbox="" class="form__field flex-direction-vertical" data-lvl-neva-contact-field="consent" data-type-field="checkbox_group">
						<div class="div form_checkbox-gap flex-direction-horizontal flex-align-center">
							<div class="form__widget-group form_checkbox border-radius">
								<label class="form__widget-item">
									<input class="form__checkbox" name="consent" type="checkbox" value="1" required>
									<span class="form__checkbox-styled form_checkbox border-radius"></span>
									<span class="form__label-text" style="display:none;">
										<span class="text-block-wrap-div">Согласие на обработку персональных данных</span>
									</span>
								</label>
							</div>
							<div class="text text-style-body text-color-grey">
								<span class="text-block-wrap-div">
									Согласен на обработку
									<span><a href="<?php echo esc_url( $privacy_policy_url ); ?>" rel="noreferrer" target="_blank">персональных данных</a></span>
								</span>
							</div>
						</div>
						<div class="form__field-error" data-lvl-neva-contact-error>
							<span class="text-block-wrap-div">Подтвердите согласие</span>
						</div>
					</div>

					<div class="site-contact-drawer__message" data-lvl-neva-contact-message hidden role="alert"></div>

					<button class="button-large_component hero-corner-roll-btn hero-corner-roll-btn--brand hero-corner-roll-btn--h100 site-contact-drawer__submit" data-lvl-neva-contact-submit type="submit">
						<span class="hero-corner-roll-btn__label" data-label="Оставить заявку">
							<span class="hero-corner-roll-btn__label-text">Оставить заявку</span>
						</span>
						<span class="hero-corner-roll-btn__icon-slot" aria-hidden="true">
							<span class="hero-corner-roll-btn__icon-roll">
								<svg class="hero-corner-roll-btn__icon hero-corner-roll-btn__icon--default" fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
									<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
								</svg>
								<svg class="hero-corner-roll-btn__icon hero-corner-roll-btn__icon--hover" fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
									<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
								</svg>
							</span>
						</span>
					</button>
				</div>
			</form>

			<div class="form__state-success heading-style-h2" role="status" aria-live="polite">
				<div class="text">
					<span class="text-block-wrap-div" data-lvl-neva-contact-success-text>Спасибо! Заявка отправлена.</span>
				</div>
			</div>

			<div class="form__state-error heading-style-h2 form__state-error--u-iskvnm7ee" aria-live="polite">
				<div class="form__text-error">
					<span class="text-block-wrap-div">Не удалось отправить форму. Попробуйте ещё раз.</span>
				</div>
			</div>
		</div>
		<?php

		return (string) ob_get_clean();
	}
}
