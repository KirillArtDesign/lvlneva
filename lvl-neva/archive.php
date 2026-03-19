<?php
get_header();
?>
<main class="div main-wrapper">
	<section section-dark-theme="" class="section section-cover" id="ies2q7q46_0">
		<div class="div page-cover_component flex-direction-vertical" id="i905smb5f_0">
			<div class="div padding-block-large" id="iiyh304i8_0">
				<h1 class="text heading-style-h1 text-color-black heading-style-h1--is-page-cover" id="ijmxwrbg4_0"><?php the_archive_title(); ?></h1>
				<?php the_archive_description( '<div class="text text-style-body text-color-grey">', '</div>' ); ?>
			</div>
		</div>
	</section>

	<section class="section section-news background-light-grey" id="ithc4hsyk_0">
		<div class="div padding-global section-news_padding" id="i8g5iq5ti_0">
			<div class="div flex-direction-vertical section_title-gap" id="i0nrf9qpz_0">
				<div class="collection" id="ijktx60l9_0">
					<div role="list" class="collection__list grid-3 grid-gap grid-3--is-news-page">
						<?php if ( have_posts() ) : ?>
							<?php while ( have_posts() ) : ?>
								<?php the_post(); ?>
								<?php get_template_part( 'template-parts/cards/news-card', null, lvl_neva_map_post_to_news_card( get_post() ) ); ?>
							<?php endwhile; ?>
						<?php else : ?>
							<?php get_template_part( 'template-parts/content', 'none' ); ?>
						<?php endif; ?>
					</div>
					<?php the_posts_pagination(); ?>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
