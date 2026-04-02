<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blog_page_id  = (int) get_option( 'page_for_posts' );
$blog_page_url = $blog_page_id ? get_permalink( $blog_page_id ) : home_url( '/' );
$latest_posts  = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
	)
);
$has_latest_posts = $latest_posts->have_posts();
?>

<section class="section section-news">

	<div class="div padding-global section-news_padding">
		<div class="div flex-direction-vertical section_title-gap">
			<div class="div flex-direction-horizontal space-between">
				<h2 class="text heading-style-h4 text-color-grey" >
					Вам будет интересно
				</h2>
				<a class="link-block link_component text-color-brand" data-action-element=""
					href="<?php echo esc_url( $blog_page_url ); ?>">
					<div class="div flex-align-center flex-direction-horizontal link-iconic_gap">
						<div class="text text-style-body">
							<span class="text-block-wrap-div">Смотреть все статьи</span>
						</div>
						<div class="embed icon_component embed--u-idvmu9xz3 flex-center-all">
							<svg fill="none" height="24" viewbox="0 0 24 24" width="24"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M18.5 10.3809V13.6191L13.3115 18.7139L11.9102 17.2861L16.2764 13H5.5V11H16.2764L11.9102 6.71387L13.3115 5.28613L18.5 10.3809Z"
									fill="currentColor"></path>
							</svg>
						</div>
					</div>
				</a>
			</div>
			<div class="div collection">
				<div role="list" class="collection__list grid-3 grid-gap grid-3--is-news-page">
					<?php if ( $has_latest_posts ) : ?>
						<?php while ( $latest_posts->have_posts() ) : ?>
							<?php
							$latest_posts->the_post();

							get_template_part(
								'template-parts/cards/blog-card',
								null,
								array(
									'post' => get_post(),
								)
							);
							?>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					<?php endif; ?>
				</div>
				<?php if ( ! $has_latest_posts ) : ?>
					<div class="collection__empty">
						<div class="text">
							<span class="text-block-wrap-div">Записи не найдены</span>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

</section>
