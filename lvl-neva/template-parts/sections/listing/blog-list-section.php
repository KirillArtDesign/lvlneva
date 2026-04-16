<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blog_list_config = lvl_neva_get_content_filter_config(
	array(
		'post_type'      => 'post',
		'taxonomy'       => 'category',
		'posts_per_page' => 12,
	)
);

echo lvl_neva_get_content_filter_results_html(
	$blog_list_config,
	(int) $blog_list_config['current_term_id'],
	lvl_neva_get_content_filter_current_page()
);
?>
		</div>
	</div>

</section>
