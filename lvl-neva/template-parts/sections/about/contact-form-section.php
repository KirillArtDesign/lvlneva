<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$privacy_policy_url = function_exists( 'get_privacy_policy_url' ) ? get_privacy_policy_url() : '';

if ( ! $privacy_policy_url ) {
	$privacy_policy_url = home_url( '/' );
}
?>
<section class="section clip-content padding60" form-white-theme>
	<div class="div flex-direction-horizontal" id="igwrku9ze_0">
		<div class="div div--u-iqp65bist padding-global section-components_padding" id="iqp65bist_0">
			<div class="div grid-2 grid-2--3-col-tablet">
				<h2 class="text heading-style-h2 heading-style-h2--form">
					Остались вопросы? Свяжитесь с нами
				</h2>

				<div class="form form_component form--u-ik9et6wvg" data-lvl-neva-contact-form-wrap>
					<form action="#" class="form__state-default" data-lvl-neva-contact-form novalidate>
						<div class="div flex-direction-vertical form_gap-medium grid_col-padding-left">
							<input type="hidden" name="website" value="" tabindex="-1" autocomplete="off">

							<div class="div form_grid">
								<div class="form__field form_input-group form__field--u-iy5tp14h0 flex-direction-vertical color-inherit" data-field-position="" data-type-field="text" data-lvl-neva-contact-field="name">
									<div class="text-subtitle text-style-caption form_input-label">
										<span class="text-block-wrap-div text-color-grey">Имя</span>
									</div>
									<input class="form__input form_input text-style-body text-color-grey" name="name" placeholder="Ваше имя" type="text" autocomplete="name" required>
									<div class="form__field-error form__field-error--u-i1cy97vv7" data-lvl-neva-contact-error>
										<span class="text-block-wrap-div">Обязательное поле</span>
									</div>
									<div class="text-subtitle text-style-caption text-color-error form_input-error text-subtitle--u-iryb58w5z">
										<span class="text-block-wrap-div">Некорректный формат</span>
									</div>
								</div>

								<div class="form__field form_input-group form__field--u-ib0ot1oie flex-direction-vertical color-inherit" data-field-position="1" data-type-field="email" data-lvl-neva-contact-field="email">
									<div class="text-subtitle text-style-caption form_input-label">
										<span class="text-block-wrap-div text-color-grey">Почта</span>
									</div>
									<input class="form__input form_input text-style-body" name="email" placeholder="Почта" type="email" autocomplete="email">
									<div class="form__field-error form__field-error--u-irqe7y5zu" data-lvl-neva-contact-error>
										<span class="text-block-wrap-div">Обязательное поле</span>
									</div>
									<div class="text-subtitle text-style-caption text-color-error form_input-error text-subtitle--u-ilos9n7vi">
										<span class="text-block-wrap-div">Некорректный формат</span>
									</div>
								</div>

								<div class="form__field form_input-group form__field--u-i3ihs10aj flex-direction-vertical color-inherit" data-field-position="2" data-type-field="tel" data-lvl-neva-contact-field="phone">
									<div class="text-subtitle text-style-caption form_input-label">
										<span class="text-block-wrap-div text-color-grey">Телефон</span>
									</div>
									<input class="form__input form_input text-style-body" name="phone" placeholder="Телефон" type="tel" inputmode="tel" autocomplete="tel" required>
									<div class="form__field-error form__field-error--u-izn2ircbn" data-lvl-neva-contact-error>
										<span class="text-block-wrap-div">Обязательное поле</span>
									</div>
									<div class="text-subtitle text-style-caption text-color-error form_input-error text-subtitle--u-i31cnbdr1">
										<span class="text-block-wrap-div">Некорректный формат</span>
									</div>
								</div>

								<div class="form__field form__field--u-i2qmwu17w flex-direction-vertical form_input-group color-inherit" data-field-position="3" data-type-field="textarea" data-lvl-neva-contact-field="comment">
									<div class="text-subtitle text-style-caption form_input-label">
										<span class="text-block-wrap-div text-color-grey">Комментарий</span>
									</div>
									<textarea class="form__textarea text-style-body form_input form_input--is-message" name="comment" placeholder="Сообщение"></textarea>
									<div class="form__field-error form__field-error--u-iwzsvazoa" data-lvl-neva-contact-error>
										<span class="text-block-wrap-div">Обязательное поле</span>
									</div>
									<div class="text-subtitle text-style-caption text-color-error form_input-error text-subtitle--u-i1um86qcw">
										<span class="text-block-wrap-div">Некорректный формат</span>
									</div>
								</div>
							</div>

							<div checkbox="" class="form__field flex-direction-vertical form__field--s2-imy8w2wz6" data-field-position="4" data-type-field="checkbox_group" data-lvl-neva-contact-field="consent">
								<div class="text-subtitle text-subtitle--u-i7h73lfif hide">
									<span class="text-block-wrap-div">Согласие</span>
								</div>
								<div class="div form_checkbox-gap flex-direction-horizontal flex-align-center">
									<div class="form__widget-group form__widget-group--u-ii04bl6qu">
										<label class="form__widget-item">
											<input class="form__checkbox" name="consent" type="checkbox" value="1" required>
											<span class="form__checkbox-styled form_checkbox border-radius"></span>
											<span class="form__label-text form__label-text--u-il5h9b3fh">
												<span class="text-block-wrap-div">Согласие на обработку персональных данных</span>
											</span>
										</label>
									</div>
									<div class="text text-style-body text--u-i9w8yrx5e text-color-grey">
										<span class="text-block-wrap-div">
											Согласен на обработку
											<span><a href="<?php echo esc_url( $privacy_policy_url ); ?>" rel="noreferrer" target="_blank">персональных данных</a></span>
										</span>
									</div>
									<div class="form__widget-group form__widget-group--u-ira02tr22 form_checkbox border-radius hide"></div>
								</div>
								<div class="form__field-error" data-lvl-neva-contact-error>
									<span class="text-block-wrap-div">Подтвердите согласие</span>
								</div>
							</div>

							<div class="form__text-error" data-lvl-neva-contact-message hidden role="alert"></div>

							<div class="card-wrapper border-radius" data-original-height="126.65625" style="height: 126.656px">
								<div class="card-mask border-radius" style="height: 127px">
									<div class="form__submit-wrap">
										<button class="button-large_component hero-corner-roll-btn hero-corner-roll-btn--brand hero-corner-roll-btn--h100" data-action-element="" data-lvl-neva-contact-submit gsap-elements-scroll-animation="" type="submit">
											<span class="hero-corner-roll-btn__label" data-label="Оставить заявку">
												<span class="hero-corner-roll-btn__label-text">Оставить заявку</span>
											</span>
											<span class="hero-corner-roll-btn__icon-slot" aria-hidden="true">
												<span class="hero-corner-roll-btn__icon-roll">
													<svg class="hero-corner-roll-btn__icon hero-corner-roll-btn__icon--default" fill="none" height="24" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
														<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
													</svg>
													<svg class="hero-corner-roll-btn__icon hero-corner-roll-btn__icon--hover" fill="none" height="24" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
														<path d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z" fill="currentColor"></path>
													</svg>
												</span>
											</span>
										</button>
									</div>
								</div>
							</div>
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
			</div>
		</div>
	</div>
</section>
