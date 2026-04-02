<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$contacts_phone = function_exists( 'get_field' ) ? (string) get_field( 'nomer_telefona', 'option' ) : '';
$contacts_email = function_exists( 'get_field' ) ? (string) get_field( 'pochta', 'option' ) : '';
$contacts_time  = function_exists( 'get_field' ) ? (string) get_field( 'vremya_raboty', 'option' ) : '';
$contacts_socials = function_exists( 'get_field' ) ? get_field( 'soczialnye_seti', 'option' ) : array();

$contacts_phone = '' !== trim( $contacts_phone ) ? $contacts_phone : '8 (812) 250-73-76';
$contacts_email = '' !== trim( $contacts_email ) ? $contacts_email : 'info@lvlneva.ru';
$contacts_time  = '' !== trim( $contacts_time ) ? $contacts_time : 'Ежедневно с 9:00 до 17:30';

if ( ! is_array( $contacts_socials ) ) {
	$contacts_socials = array();
}

$contacts_socials = array_values(
	array_filter(
		$contacts_socials,
		static function ( $item ) {
			return ! empty( $item['nazvanie'] ) && ! empty( $item['ssylka'] );
		}
	)
);
?>
<section class="section contacts-page" id="contacts-page">
	<div class="div flex-direction-vertical size-width-full">

		<div class="div background-light-grey contacts-page_section contacts-page_section--contacts">
			<div class="text contacts-page_eyebrow">Связь с нами</div>

			<div class="div flex-direction-vertical contacts-page_content contacts-page_content--contacts">
				<div class="div flex-direction-horizontal contacts-page_row contacts-page_row--contact">
					<div class="contacts-page_label">Телефон</div>
					<div class="text text-style-body contacts-page_value"><?php echo esc_html( $contacts_phone ); ?></div>
				</div>
				<div class="contacts-page_line"></div>

				<div class="div flex-direction-horizontal contacts-page_row contacts-page_row--contact">
					<div class="contacts-page_label">Почта</div>
					<div class="text text-style-body contacts-page_value"><?php echo esc_html( $contacts_email ); ?></div>
				</div>
				<div class="contacts-page_line"></div>

				<div class="div flex-direction-horizontal contacts-page_row contacts-page_row--contact">
					<div class="contacts-page_label">Время работы</div>
					<div class="text text-style-body contacts-page_value"><?php echo esc_html( $contacts_time ); ?></div>
				</div>

				<?php if ( ! empty( $contacts_socials ) ) : ?>
					<div class="contacts-page_line"></div>

					<div class="div flex-direction-horizontal contacts-page_row contacts-page_row--contact contacts-page_row--social">
						<div class="contacts-page_label">Социальные сети</div>

						<div class="div flex-direction-horizontal contacts-page_socials">
							<?php foreach ( $contacts_socials as $contacts_social_item ) : ?>
								<a
									href="<?php echo esc_url( $contacts_social_item['ssylka'] ); ?>"
									class="text text-style-body contacts-page_value contacts-page_social-link"
									target="_blank"
									rel="noreferrer"
								>
									<?php echo esc_html( $contacts_social_item['nazvanie'] ); ?>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
