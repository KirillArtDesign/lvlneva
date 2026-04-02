<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="section padding-global">
    <div class="div flex-direction-vertical grid-gap size-width-full art-conteiner">
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
</section>
