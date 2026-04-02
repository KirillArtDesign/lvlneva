<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$faq_post_items   = get_field( 'blok_otvetov_na_chastye_voprosy' );
$faq_option_items = get_field( 'blok_otvetov_na_chastye_voprosy', 'option' );

$faq_post_items = is_array( $faq_post_items ) ? $faq_post_items : array();
$faq_option_items = is_array( $faq_option_items ) ? $faq_option_items : array();

$faq_items = array_merge( $faq_post_items, $faq_option_items );
$faq_items = array_values(
	array_filter(
		$faq_items,
		static function ( $item ) {
			return ! empty( trim( (string) ( $item['vopros'] ?? '' ) ) ) && ! empty( trim( (string) ( $item['otvet'] ?? '' ) ) );
		}
	)
);

if ( empty( $faq_items ) ) {
	return;
}

$faq_section_id = 'faq-' . get_the_ID();
?>

<section class="section  section-services-page background-light-grey">
	<div class="div padding-global size-height-auto-tablet  services-page_padding">
		<div class="div grid-4 services-card_component--height-full grid-4--is-services-layout">
			<h2 gsap-text-scroll-animation=""
				class="text heading-style-h4 text-color-grey text--u-irj2o420v ">
				Ответы на частые вопросы
			</h2>
			<div class="collection collection--u-i2lj9rvhv ">
				<div role="list" class="collection__list grid-1 ">
					<div class="div flex-direction-vertical size-width-full faq-accordion">
						<div class="div flex-direction-vertical size-width-full faq-accordion__list">
							<?php foreach ( $faq_items as $faq_index => $faq_item ) : ?>
								<?php
								$faq_question   = trim( (string) $faq_item['vopros'] );
								$faq_answer     = trim( (string) $faq_item['otvet'] );
								$faq_is_open    = 0 === $faq_index;
								$faq_trigger_id = $faq_section_id . '-trigger-' . ( $faq_index + 1 );
								$faq_panel_id   = $faq_section_id . '-panel-' . ( $faq_index + 1 );
								?>
								<div class="div flex-direction-vertical size-width-full background-white border-radius faq-accordion__item<?php echo $faq_is_open ? ' is-open' : ''; ?>">
									<button
										class="faq-accordion__trigger"
										type="button"
										aria-expanded="<?php echo $faq_is_open ? 'true' : 'false'; ?>"
										aria-controls="<?php echo esc_attr( $faq_panel_id ); ?>"
										id="<?php echo esc_attr( $faq_trigger_id ); ?>"
									>
										<div class="faq-accordion__title">
											<?php echo esc_html( $faq_question ); ?>
										</div>

										<div class="faq-accordion__icon-wrap">
											<svg class="faq-accordion__icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M6 10.8889L10.8 6H12M18 10.8889L13.2 6H12M12 6L12 18" stroke="currentColor" stroke-width="2"/>
											</svg>
										</div>
									</button>

									<div
										class="faq-accordion__panel"
										id="<?php echo esc_attr( $faq_panel_id ); ?>"
										role="region"
										aria-labelledby="<?php echo esc_attr( $faq_trigger_id ); ?>"
									>
										<div class="faq-accordion__panel-inner">
											<div class="faq-accordion__text">
												<?php echo nl2br( esc_html( $faq_answer ) ); ?>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
