<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args,
	array(
		'title'         => '',
		'description'   => '',
		'image'         => lvl_neva_asset_url( 'img/pr.jpg' ),
		'url'           => lvl_neva_get_archive_url( 'project', '/projects/' ),
		'content_class' => 'project-case-card__content',
	)
);
?>
<div class="div flex-direction-horizontal size-width-full background-white border-radius project-case-card">
	<div class="div flex-direction-vertical <?php echo esc_attr( $args['content_class'] ); ?>">
		<div class="div flex-direction-vertical project-case-card__content-top">
			<div class="project-case-card__title"><?php echo esc_html( $args['title'] ); ?></div>
			<div class="project-case-card__text"><?php echo esc_html( $args['description'] ); ?></div>
		</div>
		<a href="<?php echo esc_url( $args['url'] ); ?>" class="link-block div flex-direction-horizontal project-case-card__link">
			<div class="project-case-card__link-text"><?php esc_html_e( 'Подробнее', 'lvl-neva' ); ?></div>
			<svg class="project-case-card__link-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M13.1111 18L18 13.2V12M13.1111 6L18 10.8V12M18 12H6" stroke="currentColor" stroke-width="2"/>
			</svg>
		</a>
	</div>
	<div class="div project-case-card__media">
		<img class="project-case-card__image border-radius" src="<?php echo esc_url( $args['image'] ); ?>" alt="<?php echo esc_attr( $args['title'] ); ?>">
	</div>
</div>
