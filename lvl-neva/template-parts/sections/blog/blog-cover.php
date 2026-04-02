<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blog_cover_image_id    = get_post_thumbnail_id();
$blog_cover_image_url   = $blog_cover_image_id ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '';
$blog_cover_image_alt   = $blog_cover_image_id ? get_post_meta( $blog_cover_image_id, '_wp_attachment_image_alt', true ) : '';
$blog_cover_image_title = $blog_cover_image_id ? get_the_title( $blog_cover_image_id ) : '';
?>

<section class="section full-photo-block">
  <div class="div flex-direction-horizontal size-width-full full-photo-block__inner">
    <div class="div full-photo-block__image-wrap">
      <div class="image size-full-percentage full-photo-block-height">
        <?php if ( $blog_cover_image_url ) : ?>
        <img
          src="<?php echo esc_url( $blog_cover_image_url ); ?>"
          alt="<?php echo esc_attr( $blog_cover_image_alt ); ?>"
          title="<?php echo esc_attr( $blog_cover_image_title ); ?>"
          class="full-photo-block__image"
        >
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
