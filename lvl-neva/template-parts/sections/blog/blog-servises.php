<?php
if (!defined('ABSPATH')) {
    exit;
}

$blog_services_ids = get_field('uslugi_v_state', get_the_ID());

if (empty($blog_services_ids) || !is_array($blog_services_ids)) {
    return;
}

$blog_services_ids = array_values(
    array_filter(
        array_map('absint', $blog_services_ids)
    )
);

if (empty($blog_services_ids)) {
    return;
}

$blog_services = get_posts(
    array(
        'post_type' => 'services',
        'post_status' => 'publish',
        'posts_per_page' => count($blog_services_ids),
        'post__in' => $blog_services_ids,
        'orderby' => 'post__in',
    )
);

if (empty($blog_services)) {
    return;
}
?>
<section class="section padding-global">
    <div class="div flex-direction-vertical grid-gap size-width-full art-conteiner">
        <div class="div flex-direction-horizontal size-width-full equipment-article">
            <div class="div flex-direction-vertical size-width-full border-radius equipment-article__card">
                <div class="div flex-direction-horizontal size-width-full equipment-article__top">
                    <div class="div flex-direction-vertical size-width-full border-radius services-suitable-block">
                        <div class="div flex-direction-vertical services-suitable-block__heading">
                            <div class="services-suitable-block__title">Вам подойдут услуги</div>
                        </div>

                        <div class="div flex-direction-vertical size-width-full services-suitable-block__list">
                            <?php
                            $service_index = 1;

                            foreach ($blog_services as $service_post):
                                get_template_part(
                                    'template-parts/cards/blog-servise-card',
                                    null,
                                    array(
                                        'service_post' => $service_post,
                                        'service_index' => $service_index,
                                    )
                                );

                                $service_index++;
                            endforeach;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>