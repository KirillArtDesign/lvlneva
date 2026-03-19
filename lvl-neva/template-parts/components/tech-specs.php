<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args,
	array(
		'rows' => array(),
	)
);

if ( empty( $args['rows'] ) ) {
	return;
}
?>
<div class="div flex-direction-vertical size-width-full tech-specs">
	<?php foreach ( $args['rows'] as $row ) : ?>
		<div class="div flex-direction-horizontal size-width-full tech-specs__row">
			<div class="text-style-body tech-specs__label"><?php echo esc_html( $row['label'] ); ?></div>
			<div class="equipment-page_tech-line-wrapper tech-specs__line">
				<div class="line_horizontal size-width-full"></div>
			</div>
			<div class="text-style-body tech-specs__value"><?php echo esc_html( $row['value'] ); ?></div>
		</div>
	<?php endforeach; ?>
</div>
