<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="div flex-direction-vertical grid-gap size-width-full equipment-page_under-slider">
	<div class="div flex-direction-horizontal size-width-full equipment-article">
		<div class="div flex-direction-vertical size-width-full border-radius equipment-article__card">
			<div class="div flex-direction-horizontal size-width-full equipment-article__top">
				<div class="div flex-direction-vertical size-width-full equipment-article__content">
					<?php echo lvl_neva_get_equipment_article_content( get_the_ID() ); ?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</section>
