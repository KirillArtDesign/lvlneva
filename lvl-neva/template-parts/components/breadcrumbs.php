<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args  = wp_parse_args(
	$args,
	array(
		'items' => array(),
	)
);
$items = array_values( array_filter( (array) $args['items'] ) );

if ( empty( $items ) ) {
	return;
}
?>
<nav class="breadcrumbs">
	<ul class="div flex-direction-horizontal" style="gap:6px;align-items:center;list-style-type:none;padding-left:0;">
		<?php foreach ( $items as $index => $item ) : ?>
			<?php
			$is_last = $index === count( $items ) - 1;
			$label   = isset( $item['label'] ) ? $item['label'] : '';
			$url     = isset( $item['url'] ) ? $item['url'] : '';
			?>
			<li>
				<?php if ( $url && ! $is_last ) : ?>
					<a href="<?php echo esc_url( $url ); ?>" class="text text-style-body text-color-grey">
						<span class="text-block-wrap-div"><?php echo esc_html( $label ); ?></span>
					</a>
				<?php else : ?>
					<span class="text text-style-body<?php echo $is_last ? '' : ' text-color-grey'; ?>">
						<span class="text-block-wrap-div"><?php echo esc_html( $label ); ?></span>
					</span>
				<?php endif; ?>
			</li>
			<?php if ( ! $is_last ) : ?>
				<li class="text text-style-body text-color-grey">/</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</nav>
