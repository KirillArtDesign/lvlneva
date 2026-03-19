<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function lvl_neva_asset_url( $path ) {
	return trailingslashit( get_template_directory_uri() ) . 'assets/' . ltrim( $path, '/' );
}

function lvl_neva_trim_text( $text, $words = 18 ) {
	return wp_trim_words( wp_strip_all_tags( (string) $text ), $words, '...' );
}

function lvl_neva_get_archive_url( $post_type, $fallback = '/' ) {
	$url = get_post_type_archive_link( $post_type );

	if ( $url ) {
		return $url;
	}

	return home_url( $fallback );
}

function lvl_neva_get_blog_url() {
	$posts_page_id = (int) get_option( 'page_for_posts' );

	if ( $posts_page_id ) {
		return get_permalink( $posts_page_id );
	}

	return home_url( '/blog/' );
}

function lvl_neva_get_shop_url() {
	if ( function_exists( 'wc_get_page_permalink' ) ) {
		$shop_url = wc_get_page_permalink( 'shop' );

		if ( $shop_url ) {
			return $shop_url;
		}
	}

	return home_url( '/shop/' );
}

function lvl_neva_format_price( $price ) {
	if ( '' === $price || null === $price ) {
		return __( 'По запросу', 'lvl-neva' );
	}

	if ( function_exists( 'wc_price' ) ) {
		return wp_strip_all_tags( wc_price( (float) $price ) );
	}

	return number_format_i18n( (float) $price, 0 ) . ' ₽';
}

function lvl_neva_get_default_sizes() {
	return array( '1м', '2м', '3м', '4.5м', '6м', '7м', '8м', '9м' );
}

function lvl_neva_get_default_service_cards() {
	return array(
		array(
			'title'   => 'Проектирование и расчёт нагрузок',
			'excerpt' => 'Для создания правильных и надежных конструкций',
			'number'  => '01',
			'url'     => lvl_neva_get_archive_url( 'service', '/services/' ),
		),
		array(
			'title'   => 'Производство конструкций из ЛВЛ',
			'excerpt' => 'Изготовим конструкции любой сложности',
			'number'  => '02',
			'url'     => lvl_neva_get_archive_url( 'service', '/services/' ),
		),
		array(
			'title'   => 'Изготовление стропильных систем и перекрытий',
			'excerpt' => 'Закрыть кровлю и перекрытия «под ключ»',
			'number'  => '03',
			'url'     => lvl_neva_get_archive_url( 'service', '/services/' ),
		),
		array(
			'title'   => 'Изготовление стропильных ферм',
			'excerpt' => 'Чтобы перекрывать пролёты быстрее и точнее',
			'number'  => '04',
			'url'     => lvl_neva_get_archive_url( 'service', '/services/' ),
		),
		array(
			'title'   => 'Монтаж конструкций',
			'excerpt' => 'Собрать всё на объекте без лишних подрядчиков',
			'number'  => '05',
			'url'     => lvl_neva_get_archive_url( 'service', '/services/' ),
		),
	);
}

function lvl_neva_get_default_related_services() {
	return array(
		array(
			'title'   => 'Проектирование и расчёт нагрузок',
			'excerpt' => 'Для создания правильных и надежных конструкций',
			'number'  => '01',
			'url'     => lvl_neva_get_archive_url( 'service', '/services/' ),
		),
		array(
			'title'   => 'Изготовление стропильных систем и перекрытий',
			'excerpt' => 'Для надежных кровельных и межэтажных решений',
			'number'  => '02',
			'url'     => lvl_neva_get_archive_url( 'service', '/services/' ),
		),
		array(
			'title'   => 'Монтаж конструкций',
			'excerpt' => 'Для быстрой и точной установки готовых элементов',
			'number'  => '03',
			'url'     => lvl_neva_get_archive_url( 'service', '/services/' ),
		),
	);
}

function lvl_neva_get_default_product_cards() {
	$sizes = lvl_neva_get_default_sizes();
	$image = lvl_neva_asset_url( 'img/card.jpg' );
	$url   = lvl_neva_get_shop_url();

	return array(
		array(
			'title'       => 'Клееный брус ЛВЛ 27X400',
			'description' => 'Идеален для лёгких несущих конструкций, элементов перегородок, кровельных систем и усиления стен',
			'price'       => 'От 1000₽',
			'sizes'       => $sizes,
			'image'       => $image,
			'url'         => $url,
		),
		array(
			'title'       => 'Клееный брус ЛВЛ 27X400',
			'description' => 'Идеален для лёгких несущих конструкций, элементов перегородок, кровельных систем и усиления стен',
			'price'       => 'От 1000₽',
			'sizes'       => $sizes,
			'image'       => $image,
			'url'         => $url,
		),
		array(
			'title'       => 'Клееный брус ЛВЛ 27X400',
			'description' => 'Идеален для лёгких несущих конструкций, элементов перегородок, кровельных систем и усиления стен',
			'price'       => 'От 1000₽',
			'sizes'       => $sizes,
			'image'       => $image,
			'url'         => $url,
		),
		array(
			'title'       => 'Клееный брус ЛВЛ 27X400',
			'description' => 'Идеален для лёгких несущих конструкций, элементов перегородок, кровельных систем и усиления стен',
			'price'       => 'От 1000₽',
			'sizes'       => $sizes,
			'image'       => $image,
			'url'         => $url,
		),
	);
}

function lvl_neva_get_default_project_cards() {
	$image = lvl_neva_asset_url( 'img/pr.jpg' );
	$url   = lvl_neva_get_archive_url( 'project', '/projects/' );

	return array(
		array(
			'title'       => 'Игровой комплекс в национальной библиотеке',
			'description' => 'Задача организации, в особенности же постоянный количественный рост и сфера нашей активности способствует подготовки и реализации дальнейших направлений развития.',
			'image'       => $image,
			'url'         => $url,
		),
		array(
			'title'       => 'Игровой комплекс в национальной библиотеке',
			'description' => 'Задача организации, в особенности же постоянный количественный рост и сфера нашей активности способствует подготовки и реализации дальнейших направлений развития.',
			'image'       => $image,
			'url'         => $url,
		),
		array(
			'title'       => 'Игровой комплекс в национальной библиотеке',
			'description' => 'Задача организации, в особенности же постоянный количественный рост и сфера нашей активности способствует подготовки и реализации дальнейших направлений развития.',
			'image'       => $image,
			'url'         => $url,
		),
		array(
			'title'       => 'Игровой комплекс в национальной библиотеке',
			'description' => 'Задача организации, в особенности же постоянный количественный рост и сфера нашей активности способствует подготовки и реализации дальнейших направлений развития.',
			'image'       => $image,
			'url'         => $url,
		),
	);
}

function lvl_neva_get_default_news_cards() {
	$image = lvl_neva_asset_url( 'img/main.jpg' );
	$url   = lvl_neva_get_blog_url();

	return array(
		array(
			'title'    => 'Потолки и стены LVL-бруса: современный подход к строительству',
			'category' => 'Выставка',
			'image'    => $image,
			'url'      => $url,
		),
		array(
			'title'    => 'Потолки и стены LVL-бруса: современный подход к строительству',
			'category' => 'Выставка',
			'image'    => $image,
			'url'      => $url,
		),
		array(
			'title'    => 'Потолки и стены LVL-бруса: современный подход к строительству',
			'category' => 'Выставка',
			'image'    => $image,
			'url'      => $url,
		),
		array(
			'title'    => 'Потолки и стены LVL-бруса: современный подход к строительству',
			'category' => 'Выставка',
			'image'    => $image,
			'url'      => $url,
		),
		array(
			'title'    => 'Потолки и стены LVL-бруса: современный подход к строительству',
			'category' => 'Выставка',
			'image'    => $image,
			'url'      => $url,
		),
	);
}

function lvl_neva_get_default_product_specs() {
	return array(
		array( 'label' => 'Тип', 'value' => 'Брус ЛВЛ' ),
		array( 'label' => 'Применение', 'value' => 'Лобовая доска, стропила' ),
		array( 'label' => 'Порода древесины', 'value' => 'Сосна, Ель обыкновенная' ),
		array( 'label' => 'Особенности', 'value' => 'Клееный брус слоями шпона' ),
		array( 'label' => 'Толщина (мм)', 'value' => '45' ),
		array( 'label' => 'Ширина (мм)', 'value' => '240' ),
		array( 'label' => 'Длина (м)', 'value' => 'до 10,0' ),
		array( 'label' => 'Влажность', 'value' => '9-12%' ),
		array( 'label' => 'Плотность (кг/м3)', 'value' => '480' ),
		array( 'label' => 'Вес, кг/м', 'value' => '6,5' ),
	);
}

function lvl_neva_get_default_project_specs() {
	return array(
		array( 'label' => 'Объект', 'value' => 'Дом Михайлова' ),
		array( 'label' => 'Заказчик', 'value' => 'ООО «Газпром»' ),
		array( 'label' => 'Срок исполнения', 'value' => '2 недели' ),
		array( 'label' => 'Адрес', 'value' => 'Санкт-Петербург, Невский проспект, 130' ),
		array( 'label' => 'Стоимость проекта', 'value' => '1 231 000 руб.' ),
	);
}

function lvl_neva_get_default_gallery_images() {
	return array(
		array(
			'src' => lvl_neva_asset_url( 'img/pr.jpg' ),
			'alt' => 'LVL Neva gallery image 1',
		),
		array(
			'src' => lvl_neva_asset_url( 'img/pr2.JPG' ),
			'alt' => 'LVL Neva gallery image 2',
		),
		array(
			'src' => lvl_neva_asset_url( 'img/pr.jpg' ),
			'alt' => 'LVL Neva gallery image 3',
		),
		array(
			'src' => lvl_neva_asset_url( 'img/pr2.JPG' ),
			'alt' => 'LVL Neva gallery image 4',
		),
	);
}

function lvl_neva_map_service_post_to_card( $post, $index = 1 ) {
	return array(
		'title'   => get_the_title( $post ),
		'excerpt' => has_excerpt( $post ) ? get_the_excerpt( $post ) : lvl_neva_trim_text( get_post_field( 'post_content', $post ), 14 ),
		'number'  => sprintf( '%02d', (int) $index ),
		'url'     => get_permalink( $post ),
	);
}

function lvl_neva_map_project_post_to_card( $post ) {
	return array(
		'title'       => get_the_title( $post ),
		'description' => has_excerpt( $post ) ? get_the_excerpt( $post ) : lvl_neva_trim_text( get_post_field( 'post_content', $post ), 20 ),
		'image'       => get_the_post_thumbnail_url( $post, 'large' ) ?: lvl_neva_asset_url( 'img/pr.jpg' ),
		'url'         => get_permalink( $post ),
	);
}

function lvl_neva_map_post_to_news_card( $post ) {
	$categories = get_the_category( $post );

	return array(
		'title'    => get_the_title( $post ),
		'category' => ! empty( $categories ) ? $categories[0]->name : 'Новости',
		'image'    => get_the_post_thumbnail_url( $post, 'large' ) ?: lvl_neva_asset_url( 'img/main.jpg' ),
		'url'      => get_permalink( $post ),
	);
}

function lvl_neva_map_wc_product_to_card( $product ) {
	if ( ! $product ) {
		return array();
	}

	return array(
		'title'       => $product->get_name(),
		'description' => $product->get_short_description() ? lvl_neva_trim_text( $product->get_short_description(), 18 ) : 'Идеален для лёгких несущих конструкций, элементов перегородок, кровельных систем и усиления стен',
		'price'       => $product->get_price() ? lvl_neva_format_price( $product->get_price() ) : 'По запросу',
		'sizes'       => lvl_neva_get_default_sizes(),
		'image'       => wp_get_attachment_image_url( $product->get_image_id(), 'large' ) ?: lvl_neva_asset_url( 'img/card.jpg' ),
		'url'         => get_permalink( $product->get_id() ),
	);
}

function lvl_neva_get_service_items( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'count'   => 5,
			'exclude' => array(),
		)
	);

	$items = array();
	$query = new WP_Query(
		array(
			'post_type'      => 'service',
			'post_status'    => 'publish',
			'posts_per_page' => (int) $args['count'],
			'post__not_in'   => array_map( 'intval', (array) $args['exclude'] ),
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'DESC',
			),
		)
	);

	if ( $query->have_posts() ) {
		$index = 1;

		while ( $query->have_posts() ) {
			$query->the_post();
			$items[] = lvl_neva_map_service_post_to_card( get_post(), $index );
			++$index;
		}

		wp_reset_postdata();
	}

	if ( empty( $items ) ) {
		$items = lvl_neva_get_default_service_cards();
	}

	return array_slice( $items, 0, (int) $args['count'] );
}

function lvl_neva_get_related_service_items( $args = array() ) {
	$args  = wp_parse_args(
		$args,
		array(
			'count'   => 3,
			'exclude' => array(),
		)
	);
	$items = lvl_neva_get_service_items( $args );

	if ( count( $items ) < (int) $args['count'] ) {
		$items = array_slice(
			array_merge( $items, lvl_neva_get_default_related_services() ),
			0,
			(int) $args['count']
		);
	}

	return $items;
}

function lvl_neva_get_project_items( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'count'   => 4,
			'exclude' => array(),
		)
	);

	$items = array();
	$query = new WP_Query(
		array(
			'post_type'      => 'project',
			'post_status'    => 'publish',
			'posts_per_page' => (int) $args['count'],
			'post__not_in'   => array_map( 'intval', (array) $args['exclude'] ),
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'DESC',
			),
		)
	);

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$items[] = lvl_neva_map_project_post_to_card( get_post() );
		}

		wp_reset_postdata();
	}

	if ( empty( $items ) ) {
		$items = lvl_neva_get_default_project_cards();
	}

	return array_slice( $items, 0, (int) $args['count'] );
}

function lvl_neva_get_news_items( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'count'   => 3,
			'exclude' => array(),
		)
	);

	$items = array();
	$query = new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => (int) $args['count'],
			'post__not_in'        => array_map( 'intval', (array) $args['exclude'] ),
			'ignore_sticky_posts' => true,
		)
	);

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$items[] = lvl_neva_map_post_to_news_card( get_post() );
		}

		wp_reset_postdata();
	}

	if ( empty( $items ) ) {
		$items = lvl_neva_get_default_news_cards();
	}

	return array_slice( $items, 0, (int) $args['count'] );
}

function lvl_neva_get_product_items( $count = 4 ) {
	$count = (int) $count;
	$items = array();

	if ( function_exists( 'wc_get_products' ) ) {
		$products = wc_get_products(
			array(
				'status' => 'publish',
				'limit'  => $count,
				'return' => 'objects',
			)
		);

		if ( ! empty( $products ) ) {
			foreach ( $products as $product ) {
				$items[] = lvl_neva_map_wc_product_to_card( $product );
			}
		}
	}

	if ( empty( $items ) ) {
		$items = lvl_neva_get_default_product_cards();
	}

	return array_slice( $items, 0, $count );
}

function lvl_neva_get_single_product_gallery( $product = null ) {
	if ( $product && function_exists( 'wc_get_product' ) ) {
		$images = array();
		$ids    = array_filter(
			array_merge(
				array( $product->get_image_id() ),
				$product->get_gallery_image_ids()
			)
		);

		foreach ( $ids as $attachment_id ) {
			$src = wp_get_attachment_image_url( $attachment_id, 'large' );

			if ( ! $src ) {
				continue;
			}

			$images[] = array(
				'src' => $src,
				'alt' => get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ?: $product->get_name(),
			);
		}

		if ( ! empty( $images ) ) {
			return $images;
		}
	}

	return lvl_neva_get_default_gallery_images();
}
