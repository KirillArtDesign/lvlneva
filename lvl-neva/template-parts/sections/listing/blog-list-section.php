<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blog_list_paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
$blog_list_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 12,
		'paged'               => $blog_list_paged,
		'ignore_sticky_posts' => true,
		'orderby'             => 'date',
		'order'               => 'DESC',
	)
);
$blog_list_has_posts = $blog_list_query->have_posts();
$blog_list_total     = (int) $blog_list_query->max_num_pages;
$blog_list_next_url  = $blog_list_paged < (int) $blog_list_query->max_num_pages ? get_pagenum_link( $blog_list_paged + 1 ) : '';
?>
<div
	class="div collection"
	data-content-filter-results
	data-blog-list
	data-current-page="<?php echo esc_attr( $blog_list_paged ); ?>"
	data-next-page-url="<?php echo esc_url( $blog_list_next_url ); ?>"
>

	<div role="list" class="div collection__list grid-3 grid-gap grid-3--is-news-page" data-blog-list-items>
		<?php if ( $blog_list_has_posts ) : ?>
			<?php while ( $blog_list_query->have_posts() ) : ?>
				<?php
				$blog_list_query->the_post();
				get_template_part(
					'template-parts/cards/blog-card',
					null,
					array(
						'post' => get_post(),
					)
				);
				?>
			<?php endwhile; ?>
		<?php endif; ?>
	</div>

	<div data-blog-list-pagination>
		<?php echo lvl_neva_render_listing_pagination( $blog_list_paged, $blog_list_total ); ?>
	</div>

	<?php if ( 1 === $blog_list_paged && $blog_list_next_url ) : ?>
		<noscript>
			<div class="collection__pagination">
				<a href="<?php echo esc_url( $blog_list_next_url ); ?>" class="collection__pagination-button-load">
					<span class="collection__pagination-pages-text">
						<span class="text-block-wrap-div">Следующая страница</span>
					</span>
				</a>
			</div>
		</noscript>
	<?php endif; ?>

	<div data-blog-list-sentinel style="height: 1px;" aria-hidden="true"></div>
</div>
<?php wp_reset_postdata(); ?>
		</div>
	</div>

</section>
