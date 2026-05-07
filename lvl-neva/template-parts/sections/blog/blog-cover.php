<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blog_cover_image_id    = get_post_thumbnail_id();
$blog_cover_image_alt   = $blog_cover_image_id ? get_post_meta( $blog_cover_image_id, '_wp_attachment_image_alt', true ) : '';
$blog_cover_image_title = $blog_cover_image_id ? get_the_title( $blog_cover_image_id ) : '';
$blog_cover_image_html  = $blog_cover_image_id
	? wp_get_attachment_image(
		$blog_cover_image_id,
		'large',
		false,
		array(
			'class'         => 'full-photo-block__image',
			'alt'           => $blog_cover_image_alt,
			'title'         => $blog_cover_image_title,
			'loading'       => 'eager',
			'fetchpriority' => 'high',
			'decoding'      => 'async',
			'sizes'         => '100vw',
		)
	)
	: '';
?>

<section class="section full-photo-block">
  <div class="div flex-direction-horizontal size-width-full full-photo-block__inner">
    <div class="div full-photo-block__image-wrap">
      <div class="image size-full-percentage full-photo-block-height">
        <?php if ( $blog_cover_image_html ) : ?>
        <?php echo $blog_cover_image_html; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
