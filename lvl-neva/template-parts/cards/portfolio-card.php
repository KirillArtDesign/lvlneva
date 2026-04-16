<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$portfolio_post = ! empty( $args['post'] ) ? $args['post'] : get_post();

if ( $portfolio_post instanceof WP_Post ) {
	$portfolio_post_id = $portfolio_post->ID;
} elseif ( is_numeric( $portfolio_post ) ) {
	$portfolio_post_id = (int) $portfolio_post;
} else {
	$portfolio_post_id = get_the_ID();
}

$portfolio_title        = get_the_title( $portfolio_post_id );
$portfolio_permalink    = get_permalink( $portfolio_post_id );
$portfolio_excerpt      = get_the_excerpt( $portfolio_post_id );
$portfolio_content      = get_post_field( 'post_content', $portfolio_post_id );
$portfolio_description  = '';
$portfolio_thumbnail_id = get_post_thumbnail_id( $portfolio_post_id );
$portfolio_image_url    = $portfolio_thumbnail_id ? get_the_post_thumbnail_url( $portfolio_post_id, 'full' ) : '';
$portfolio_image_alt    = $portfolio_thumbnail_id ? get_post_meta( $portfolio_thumbnail_id, '_wp_attachment_image_alt', true ) : '';

if ( '' !== trim( $portfolio_excerpt ) ) {
	$portfolio_description = $portfolio_excerpt;
} else {
	$portfolio_content = wp_strip_all_tags( strip_shortcodes( $portfolio_content ) );
	$portfolio_content = preg_replace( '/\s+/u', ' ', $portfolio_content );
	$portfolio_content = trim( $portfolio_content );

	if ( '' !== $portfolio_content ) {
		if ( function_exists( 'mb_strlen' ) && function_exists( 'mb_substr' ) ) {
			$portfolio_description = mb_strlen( $portfolio_content ) > 200 ? mb_substr( $portfolio_content, 0, 200 ) . '...' : $portfolio_content;
		} else {
			$portfolio_description = strlen( $portfolio_content ) > 200 ? substr( $portfolio_content, 0, 200 ) . '...' : $portfolio_content;
		}
	}
}

if ( '' === $portfolio_image_alt ) {
	$portfolio_image_alt = $portfolio_title;
}
?>

<a
  href="<?php echo esc_url( $portfolio_permalink ); ?>"
  class="link-block div flex-direction-horizontal size-width-full background-white border-radius project-case-card project-case-card__card-link"
  aria-label="<?php echo esc_attr( $portfolio_title ); ?>"
>
  <div class="div flex-direction-vertical project-case-card__content-list">
    <div class="div flex-direction-vertical project-case-card__content-top">
      <h3 class="project-case-card__title">
        <span class="nav-btn project-case-card__title-roll" aria-hidden="true">
          <span class="nav-btn__label" data-label="<?php echo esc_attr( $portfolio_title ); ?>">
            <span class="nav-btn__label-text"><?php echo esc_html( $portfolio_title ); ?></span>
          </span>
        </span>
      </h3>

      <div class="project-case-card__text">
        <?php echo esc_html( $portfolio_description ); ?>
      </div>
    </div>

    <div class="div flex-direction-horizontal project-case-card__link" aria-hidden="true">
      <div class="project-case-card__link-text">Подробнее</div>
      <svg class="project-case-card__link-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M13.1111 18L18 13.2V12M13.1111 6L18 10.8V12M18 12H6" stroke="currentColor" stroke-width="2"/>
      </svg>
    </div>
  </div>

  <div class="div project-case-card__media">
    <?php if ( $portfolio_image_url ) : ?>
    <img
      class="project-case-card__image border-radius"
      src="<?php echo esc_url( $portfolio_image_url ); ?>"
      alt="<?php echo esc_attr( $portfolio_image_alt ); ?>"
    >
    <?php endif; ?>
  </div>
</a>
