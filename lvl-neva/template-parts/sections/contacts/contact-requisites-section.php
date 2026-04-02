<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$contacts_requisites = function_exists( 'get_field' ) ? get_field( 'rekvizity_kompanii', 'option' ) : array();

if ( ! is_array( $contacts_requisites ) ) {
	$contacts_requisites = array();
}

$contacts_company_name = isset( $contacts_requisites['naimenovanie_kampanii'] ) ? (string) $contacts_requisites['naimenovanie_kampanii'] : '';
$contacts_requisite_rows = isset( $contacts_requisites['dannye_rekvizitov'] ) && is_array( $contacts_requisites['dannye_rekvizitov'] )
	? $contacts_requisites['dannye_rekvizitov']
	: array();

$contacts_company_name = '' !== trim( $contacts_company_name ) ? $contacts_company_name : 'Индивидуальный предприниматель Кожокар Леонид Константинович';

$contacts_requisite_rows = array_values(
	array_filter(
		$contacts_requisite_rows,
		static function ( $row ) {
			return ! empty( $row['tip_rekvizita'] ) && ! empty( $row['znachenie_rekvizita'] );
		}
	)
);

if ( empty( $contacts_requisite_rows ) ) {
	$contacts_requisite_rows = array(
		array(
			'tip_rekvizita'      => 'Адрес',
			'znachenie_rekvizita' => '188662, Ленинградская область, р-н Всеволожский, г. Мурино, ул Оборонная, д. 2, к. 5, кв. 12',
		),
		array(
			'tip_rekvizita'      => 'ИНН',
			'znachenie_rekvizita' => '470617530243',
		),
		array(
			'tip_rekvizita'      => 'Банк',
			'znachenie_rekvizita' => 'Сбербанк России (ПАО)',
		),
		array(
			'tip_rekvizita'      => 'р/с',
			'znachenie_rekvizita' => '40802810455000483145',
		),
		array(
			'tip_rekvizita'      => 'к/с',
			'znachenie_rekvizita' => '30101810500000000653',
		),
		array(
			'tip_rekvizita'      => 'БИК',
			'znachenie_rekvizita' => '044030653',
		),
	);
}
?>
<section class="section section-services-page background-light-grey" id="il0p4zb9d_0">
	<div class="div padding-global size-height-auto-tablet services-page_padding">
		<div class="div grid-4 services-card_component--height-full grid-4--is-services-layout" id="iuccyujov_0">
			<h2 gsap-text-scroll-animation="" class="text heading-style-h4 text-color-grey text--u-irj2o420v">
				Реквизиты
			</h2>
			<div class="collection collection--u-i2lj9rvhv">
				<div role="list" class="collection__list grid-1">
					<div class="div flex-direction-vertical contacts-page_content contacts-page_content--requisites">
						<div class="contacts-page_company">
							<?php echo esc_html( $contacts_company_name ); ?>
						</div>
						<div class="contacts-page_line"></div>

						<?php foreach ( $contacts_requisite_rows as $contacts_requisite_row ) : ?>
							<div class="div flex-direction-horizontal contacts-page_row contacts-page_row--requisite">
								<div class="text text-style-body contacts-page_meta-label">
									<?php echo esc_html( $contacts_requisite_row['tip_rekvizita'] ); ?>
								</div>
								<div class="text text-style-body contacts-page_meta-value">
									<?php echo esc_html( $contacts_requisite_row['znachenie_rekvizita'] ); ?>
								</div>
							</div>
							<div class="contacts-page_line"></div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

			<div class="div flex-direction-horizontal flex-align-bottom div--u-iltmzvhq2 flex-align-bottom--is-equipment-button grid-2-tablet section-works-cta">
				<div class="div div--u-iw325u2iw tablet-col-right">
					<div class="card-wrapper border-radius">
						<button
							class="button-large_component hero-corner-roll-btn hero-corner-roll-btn--white-brand-hover hero-corner-roll-btn--h100"
							data-action-element=""
							gsap-elements-scroll-animation=""
							type="button"
						>
							<span class="hero-corner-roll-btn__label" data-label="Смотреть все проекты">
								<span class="hero-corner-roll-btn__label-text">Скачать реквизиты</span>
							</span>
							<span class="hero-corner-roll-btn__icon-slot" aria-hidden="true">
								<span class="hero-corner-roll-btn__icon-roll">
									<svg class="hero-corner-roll-btn__icon hero-corner-roll-btn__icon--default" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M7.2 10.7778L11.04 14.75L12 14.75M16.8 10.7778L12.96 14.75L12 14.75M12 14.75V5M5 19L19 19" stroke="currentColor" stroke-width="2"/>
									</svg>
									<svg class="hero-corner-roll-btn__icon hero-corner-roll-btn__icon--hover" fill="none" height="24" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
										<path d="M7.2 10.7778L11.04 14.75L12 14.75M16.8 10.7778L12.96 14.75L12 14.75M12 14.75V5M5 19L19 19" stroke="currentColor" stroke-width="2"/>
									</svg>
								</span>
							</span>
						</button>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

	</div>
</section>
