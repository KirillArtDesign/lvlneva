<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$content_filter = lvl_neva_get_content_filter_config( $args ?? array() );

if ( empty( $content_filter ) ) {
	return;
}
?>
<section class="section section-news background-light-grey">
	<div class="div padding-global section-news_padding padding-top-0">
		<div
			class="div flex-direction-vertical section_title-gap"
			data-content-filter
			data-archive-url="<?php echo esc_url( get_pagenum_link( 1 ) ); ?>"
			data-post-type="<?php echo esc_attr( $content_filter['post_type'] ); ?>"
			data-taxonomy="<?php echo esc_attr( $content_filter['taxonomy'] ); ?>"
			data-posts-per-page="<?php echo esc_attr( $content_filter['posts_per_page'] ); ?>"
		>
			<div class="div flex-direction-horizontal content-tags" role="radiogroup" aria-label="Фильтр контента">
				<label class="content-tags__item border-radius">
					<input
						class="content-tags__input"
						type="radio"
						name="<?php echo esc_attr( $content_filter['input_name'] ); ?>"
						value="all"
						<?php checked( 0, (int) $content_filter['current_term_id'] ); ?>
					>
					<span class="content-tags__button div flex-center-all border-radius">
						<span class="text-style-body content-tags__text">Все</span>
					</span>
				</label>

				<?php foreach ( $content_filter['terms'] as $term ) : ?>
					<?php if ( (int) $term->count < 1 ) : ?>
						<?php continue; ?>
					<?php endif; ?>
					<label class="content-tags__item border-radius">
						<input
							class="content-tags__input"
							type="radio"
							name="<?php echo esc_attr( $content_filter['input_name'] ); ?>"
							value="<?php echo esc_attr( $term->term_id ); ?>"
							<?php checked( (int) $term->term_id, (int) $content_filter['current_term_id'] ); ?>
						>
						<span class="content-tags__button div flex-center-all border-radius">
							<span class="text-style-body content-tags__text"><?php echo esc_html( $term->name ); ?></span>
						</span>
					</label>
				<?php endforeach; ?>
			</div>
