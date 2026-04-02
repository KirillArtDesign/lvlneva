<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="section section-cover">
	<div class="div page-cover_component flex-direction-vertical">
		<div class="div padding-block-large">
			<h1 class="text heading-style-h1 text-color-black heading-style-h1--is-page-cover">
				<?php echo esc_html( lvl_neva_get_context_title() ); ?>
			</h1>
			<?php lvl_neva_render_breadcrumbs(); ?>
		</div>
	</div>
</section>
