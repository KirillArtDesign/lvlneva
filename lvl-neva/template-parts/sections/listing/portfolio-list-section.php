<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$portfolio_list_config = lvl_neva_get_content_filter_config(
	array(
		'post_type'      => 'portfolio',
		'taxonomy'       => 'project-type',
		'posts_per_page' => 12,
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);

echo lvl_neva_get_content_filter_results_html(
	$portfolio_list_config,
	(int) $portfolio_list_config['current_term_id'],
	lvl_neva_get_content_filter_current_page()
);
?>
		</div>
	</div>

</section>
