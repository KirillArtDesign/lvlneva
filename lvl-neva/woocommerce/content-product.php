<?php
defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product instanceof WC_Product || ! $product->is_visible() ) {
	return;
}

get_template_part(
	'template-parts/cards/product-archive-card',
	null,
	array(
		'product' => $product,
	)
);
