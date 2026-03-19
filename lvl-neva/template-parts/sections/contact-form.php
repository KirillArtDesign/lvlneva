<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args,
	array(
		'eyebrow'      => 'свяжитесь с нами',
		'title'        => 'Остались вопросы? Свяжитесь с нами',
		'button_label' => 'Оставить заявку',
	)
);
?>
<section class="section section-form section-full-screen clip-content background-brand" id="i5rmyn4f7_0">
	<div class="div flex-direction-horizontal size-height-full" id="igwrku9ze_0">
		<div class="div div--u-iqp65bist padding-global section-form_padding" id="iqp65bist_0">
			<div class="div grid-2 grid-2--3-col-tablet" id="i27s3qiyq_0">
				<h2 class="text heading-style-h4 text-color-white text-color-grey-mobile" id="if61iqhaf_0">
					<div class="line-wrapper" style="height:28px">
						<div class="line-mask" style="height:28px">
							<div class="text-line"><?php echo esc_html( $args['eyebrow'] ); ?></div>
						</div>
					</div>
				</h2>
				<div class="form text-color-white form_component form--u-ik9et6wvg" id="ik9et6wvg_0">
					<form class="form__state-default" action="#" method="post">
						<div class="div flex-direction-vertical form_gap-medium grid_col-padding-left">
							<div class="text heading-style-h2 heading-style-h2--form"><?php echo esc_html( $args['title'] ); ?></div>
							<div class="div form_grid" id="ic4wjkfg8_0">
								<label class="form__field form_input-group flex-direction-vertical color-inherit">
									<div class="text-subtitle text-style-caption form_input-label text-color-white-opacity"><span class="text-block-wrap-div"><?php esc_html_e( 'Имя', 'lvl-neva' ); ?></span></div>
									<input class="form__input form_input text-style-body" type="text" placeholder="<?php esc_attr_e( 'Ваше имя', 'lvl-neva' ); ?>">
								</label>
								<label class="form__field form_input-group flex-direction-vertical color-inherit">
									<div class="text-subtitle text-style-caption form_input-label text-color-white-opacity"><span class="text-block-wrap-div"><?php esc_html_e( 'Почта', 'lvl-neva' ); ?></span></div>
									<input class="form__input form_input text-style-body" type="email" placeholder="Email">
								</label>
								<label class="form__field form_input-group flex-direction-vertical color-inherit">
									<div class="text-subtitle text-style-caption form_input-label text-color-white-opacity"><span class="text-block-wrap-div"><?php esc_html_e( 'Телефон', 'lvl-neva' ); ?></span></div>
									<input class="form__input form_input text-style-body" type="tel" placeholder="<?php esc_attr_e( 'Телефон', 'lvl-neva' ); ?>">
								</label>
								<label class="form__field form_input-group flex-direction-vertical color-inherit">
									<div class="text-subtitle text-style-caption form_input-label text-color-white-opacity"><span class="text-block-wrap-div"><?php esc_html_e( 'Комментарий', 'lvl-neva' ); ?></span></div>
									<textarea class="form__textarea text-style-body form_input form_input--is-message" placeholder="<?php esc_attr_e( 'Сообщение', 'lvl-neva' ); ?>"></textarea>
								</label>
							</div>
							<label class="div form_checkbox-gap flex-direction-horizontal flex-align-center">
								<input class="form__checkbox" type="checkbox">
								<span class="form__checkbox-styled form_checkbox border-radius"></span>
								<span class="text text-style-body text-color-grey">
									<span class="text-block-wrap-div"><?php esc_html_e( 'Согласен на обработку персональных данных', 'lvl-neva' ); ?></span>
								</span>
							</label>
							<div class="card-wrapper border-radius">
								<button class="button-large_component hero-corner-roll-btn hero-corner-roll-btn--white-brand-hover hero-corner-roll-btn--h100" type="submit">
									<span class="hero-corner-roll-btn__label" data-label="<?php echo esc_attr( $args['button_label'] ); ?>">
										<span class="hero-corner-roll-btn__label-text"><?php echo esc_html( $args['button_label'] ); ?></span>
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
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
