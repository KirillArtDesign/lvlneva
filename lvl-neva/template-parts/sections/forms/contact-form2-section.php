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
			<div class="div grid-2 grid-2--3-col-tablet" id="i27s3qiyq_0">
				<h2 class="text heading-style-h2 heading-style-h2--form">
					Остались вопросы? Свяжитесь с нами
				</h2>

				<div class="form form_component form--u-ik9et6wvg" id="ik9et6wvg_0" data-lvl-neva-contact-form-wrap>
					<form action="#" class="form__state-default" id="ic1m4yor8_0" data-lvl-neva-contact-form novalidate>
						<div class="div flex-direction-vertical form_gap-medium grid_col-padding-left" id="i1pcovvn9_0">
							<input type="hidden" name="website" value="" tabindex="-1" autocomplete="off">

							<div class="div form_grid" id="ic4wjkfg8_0">
								<div class="form__field form_input-group form__field--u-iy5tp14h0 flex-direction-vertical color-inherit" data-field-position="" data-type-field="text" data-lvl-neva-contact-field="name" id="iy5tp14h0_0">
									<div class="text-subtitle text-style-caption form_input-label" id="ixmpspttd_0">
										<span class="text-block-wrap-div text-color-grey">Имя</span>
									</div>
									<input class="form__input form_input text-style-body text-color-grey" id="ipkws6fq5_0" name="name" placeholder="Ваше имя" type="text" autocomplete="name" required>
									<div class="form__field-error form__field-error--u-i1cy97vv7" id="i1cy97vv7_0" data-lvl-neva-contact-error>
										<span class="text-block-wrap-div">Обязательное поле</span>
									</div>
									<div class="text-subtitle text-style-caption text-color-error form_input-error text-subtitle--u-iryb58w5z" id="iryb58w5z_0">
										<span class="text-block-wrap-div">Некорректный формат</span>
									</div>
								</div>

								<div class="form__field form_input-group form__field--u-ib0ot1oie flex-direction-vertical color-inherit" data-field-position="1" data-type-field="email" data-lvl-neva-contact-field="email" id="ib0ot1oie_0">
									<div class="text-subtitle text-style-caption form_input-label" id="ixz4844i5_0">
										<span class="text-block-wrap-div text-color-grey">Почта</span>
									</div>
									<input class="form__input form_input text-style-body" id="ivr1ezazi_0" name="email" placeholder="Почта" type="email" autocomplete="email">
									<div class="form__field-error form__field-error--u-irqe7y5zu" id="irqe7y5zu_0" data-lvl-neva-contact-error>
										<span class="text-block-wrap-div">Обязательное поле</span>
									</div>
									<div class="text-subtitle text-style-caption text-color-error form_input-error text-subtitle--u-ilos9n7vi" id="ilos9n7vi_0">
										<span class="text-block-wrap-div">Некорректный формат</span>
									</div>
								</div>

								<div class="form__field form_input-group form__field--u-i3ihs10aj flex-direction-vertical color-inherit" data-field-position="2" data-type-field="tel" data-lvl-neva-contact-field="phone" id="i3ihs10aj_0">
									<div class="text-subtitle text-style-caption form_input-label" id="i0yn2wmc8_0">
										<span class="text-block-wrap-div text-color-grey">Телефон</span>
									</div>
									<input class="form__input form_input text-style-body" id="ipv0zcc0p_0" name="phone" placeholder="Телефон" type="tel" inputmode="tel" autocomplete="tel" required>
									<div class="form__field-error form__field-error--u-izn2ircbn" id="izn2ircbn_0" data-lvl-neva-contact-error>
										<span class="text-block-wrap-div">Обязательное поле</span>
									</div>
									<div class="text-subtitle text-style-caption text-color-error form_input-error text-subtitle--u-i31cnbdr1" id="i31cnbdr1_0">
										<span class="text-block-wrap-div">Некорректный формат</span>
									</div>
								</div>

								<div class="form__field form__field--u-i2qmwu17w flex-direction-vertical form_input-group color-inherit" data-field-position="3" data-type-field="textarea" data-lvl-neva-contact-field="comment" id="i2qmwu17w_0">
									<div class="text-subtitle text-style-caption form_input-label" id="ib2uej5q1_0">
										<span class="text-block-wrap-div text-color-grey">Комментарий</span>
									</div>
									<textarea class="form__textarea text-style-body form_input form_input--is-message" id="ix10ecljn_0" name="comment" placeholder="Сообщение"></textarea>
									<div class="form__field-error form__field-error--u-iwzsvazoa" id="iwzsvazoa_0" data-lvl-neva-contact-error>
										<span class="text-block-wrap-div">Обязательное поле</span>
									</div>
									<div class="text-subtitle text-style-caption text-color-error form_input-error text-subtitle--u-i1um86qcw" id="i1um86qcw_0">
										<span class="text-block-wrap-div">Некорректный формат</span>
									</div>
								</div>
							</div>

							<div checkbox="" class="form__field flex-direction-vertical form__field--s2-imy8w2wz6" data-field-position="4" data-type-field="checkbox_group" data-lvl-neva-contact-field="consent" id="imy8w2wz6_0">
								<div class="text-subtitle text-subtitle--u-i7h73lfif hide" id="i7h73lfif_0">
									<span class="text-block-wrap-div">Согласие</span>
								</div>
								<div class="div form_checkbox-gap flex-direction-horizontal flex-align-center" id="igz4ohqcu_0">
									<div class="form__widget-group form__widget-group--u-ii04bl6qu" id="ii04bl6qu_0">
										<label class="form__widget-item" id="iuacyh18p_0">
											<input class="form__checkbox" id="ic39upd3u_0" name="consent" type="checkbox" value="1" required>
											<span class="form__checkbox-styled form_checkbox border-radius" id="ix04o05g1_0"></span>
											<span class="form__label-text form__label-text--u-il5h9b3fh" id="il5h9b3fh_0">
												<span class="text-block-wrap-div">Согласие на обработку персональных данных</span>
											</span>
										</label>
									</div>
									<div class="text text-style-body text--u-i9w8yrx5e text-color-grey" id="i9w8yrx5e_0">
										<span class="text-block-wrap-div">
											Согласен на обработку
											<span><a href="<?php echo esc_url( $privacy_policy_url ); ?>" rel="noreferrer" target="_blank">персональных данных</a></span>
										</span>
									</div>
									<div class="form__widget-group form__widget-group--u-ira02tr22 form_checkbox border-radius hide" id="ira02tr22_0"></div>
								</div>
								<div class="form__field-error" id="iwmlcgqzb_0" data-lvl-neva-contact-error>
									<span class="text-block-wrap-div">Подтвердите согласие</span>
								</div>
							</div>

							<div class="form__text-error" data-lvl-neva-contact-message hidden role="alert"></div>

							<div class="card-wrapper border-radius" data-original-height="126.65625" style="height: 126.656px">
								<div class="card-mask border-radius" style="height: 127px">
									<div class="form__submit-wrap">
										<button class="button-large_component hero-corner-roll-btn hero-corner-roll-btn--brand hero-corner-roll-btn--h100" data-action-element="" data-lvl-neva-contact-submit gsap-elements-scroll-animation="" id="i8o80ox3i_0" type="submit">
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

					<div class="form__state-success heading-style-h2" id="ir546hcpo_0" role="status" aria-live="polite">
						<div class="text" id="i6zx1efmv_0">
							<span class="text-block-wrap-div" data-lvl-neva-contact-success-text>Спасибо! Заявка отправлена.</span>
						</div>
					</div>

					<div class="form__state-error heading-style-h2 form__state-error--u-iskvnm7ee" id="iskvnm7ee_0" aria-live="polite">
						<div class="form__text-error" id="icg10sa41_0">
							<span class="text-block-wrap-div">Не удалось отправить форму. Попробуйте ещё раз.</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
