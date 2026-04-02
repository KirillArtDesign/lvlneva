<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$contacts_address = function_exists( 'get_field' ) ? (string) get_field( 'adres_kompanii', 'option' ) : '';
$contacts_address = '' !== trim( $contacts_address ) ? $contacts_address : 'Ленинградская обл., п. Кузьмоловский, ул. Победы 10а';
?>
<div class="div flex-direction-vertical background-white contacts-page_section contacts-page_section--address">
	<div class="div contacts-page_head">
		<div class="text contacts-page_eyebrow">Адрес</div>

		<div class="div flex-direction-vertical contacts-page_content contacts-page_content--address">
			<div class="div flex-direction-horizontal contacts-page_row contacts-page_row--address">
				<div class="contacts-page_label contacts-page_label--address">Фактический адрес</div>
				<div class="text text-style-body contacts-page_value contacts-page_value--address">
					<?php echo wp_kses_post( nl2br( esc_html( $contacts_address ) ) ); ?>
				</div>
			</div>
			<div class="contacts-page_line"></div>
		</div>
	</div>

	<div class="div border-radius contacts-page_map-wrap">
		<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Af503d96aad4837dff246e7fd518bdb6ffb4798b83e916464c928df1dd3aad8d9&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
	</div>
</div>
