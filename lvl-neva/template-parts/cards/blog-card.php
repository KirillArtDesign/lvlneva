<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blog_post = ! empty( $args['post'] ) ? $args['post'] : get_post();

if ( $blog_post instanceof WP_Post ) {
	$blog_post_id = $blog_post->ID;
} elseif ( is_numeric( $blog_post ) ) {
	$blog_post_id = (int) $blog_post;
} else {
	$blog_post_id = get_the_ID();
}

$blog_permalink    = get_permalink( $blog_post_id );
$blog_title        = get_the_title( $blog_post_id );
$blog_thumbnail_id = get_post_thumbnail_id( $blog_post_id );
$blog_image_url    = $blog_thumbnail_id ? get_the_post_thumbnail_url( $blog_post_id, 'full' ) : '';
$blog_image_alt    = $blog_thumbnail_id ? get_post_meta( $blog_thumbnail_id, '_wp_attachment_image_alt', true ) : '';
$blog_image_title  = $blog_thumbnail_id ? get_the_title( $blog_thumbnail_id ) : '';
$blog_categories   = get_the_category( $blog_post_id );
$blog_category     = ! empty( $blog_categories ) && ! is_wp_error( $blog_categories ) ? $blog_categories[0]->name : '';
?>

<div role="listitem" class="collection__item size-full-percentage relative border-radius">

	<a href="<?php echo esc_url( $blog_permalink ); ?>"
		class="link-block news-card_component background-light-grey flex-direction-vertical size-full-percentage news-card_component--catalog">

		<div class="image size-full-percentage relative">
			<?php if ( $blog_image_url ) : ?>
				<img src="<?php echo esc_url( $blog_image_url ); ?>" alt="<?php echo esc_attr( $blog_image_alt ); ?>"
					title="<?php echo esc_attr( $blog_image_title ); ?>" class="image__img">
			<?php endif; ?>

			<div class="div padding-block-small absolute" style="top:0; left:0;">
				<p class="text text-style-body text-color-white">
					<span class="text-block-wrap-div"><?php echo esc_html( $blog_category ); ?></span>
				</p>
			</div>

		</div>

		<div class="div border-all div--u-ifil4yw8v news-card__content">

			<div class="div padding-block-small news-card__body">

				<div class="div flex-direction-horizontal news-card__row">

					<h3 class="div text heading-style-h5 text-color-black news-card__title">
						<?php echo esc_html( $blog_title ); ?>
					</h3>

					<svg class="icon-card_component" width="45" height="45" viewBox="0 0 45 45" fill="none"
						xmlns="http://www.w3.org/2000/svg">
						<rect width="45" height="45" rx="3" fill="#31572C" />
						<path
							d="M27.5 27.5V19.2667L26.6139 18.3833M17.5 17.5H25.7278L26.6139 18.3833M26.6139 18.3833L17.9909 26.9795"
							stroke="white" stroke-width="2" />
					</svg>


				</div>

			</div>

		</div>

	</a>
</div>
