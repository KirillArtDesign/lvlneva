<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'lvl_neva_get_primary_menu_items' ) ) {
	function lvl_neva_get_primary_menu_items() {
		$locations = get_nav_menu_locations();

		if ( empty( $locations['primary'] ) ) {
			return array();
		}

		$menu_items = wp_get_nav_menu_items( $locations['primary'] );

		if ( ! is_array( $menu_items ) ) {
			return array();
		}

		usort(
			$menu_items,
			static function ( $left, $right ) {
				return (int) $left->menu_order <=> (int) $right->menu_order;
			}
		);

		return array_values(
			array_filter(
				$menu_items,
				static function ( $item ) {
					return $item instanceof WP_Post && empty( $item->menu_item_parent );
				}
			)
		);
	}
}

$primary_menu_items  = lvl_neva_get_primary_menu_items();
$shop_archive_url    = function_exists( 'lvl_neva_get_shop_archive_url' ) ? lvl_neva_get_shop_archive_url() : home_url( '/' );
$services_archive_id = function_exists( 'lvl_neva_get_archive_page_for_post_type' ) ? lvl_neva_get_archive_page_for_post_type( 'services' ) : 0;
$services_archive_url = $services_archive_id ? get_permalink( $services_archive_id ) : home_url( '/' );
$site_phone          = function_exists( 'get_field' ) ? trim( (string) get_field( 'nomer_telefona', 'option' ) ) : '';
$site_email          = function_exists( 'get_field' ) ? trim( (string) get_field( 'pochta', 'option' ) ) : '';
$cart_count_badge    = function_exists( 'lvl_neva_render_cart_drawer_count_badge' ) ? lvl_neva_render_cart_drawer_count_badge() : '';

if ( '' === $site_phone ) {
	$site_phone = '+7 812 250-73-78';
}

if ( '' === $site_email ) {
	$site_email = 'info@lvlneva.ru';
}

$site_phone_href = preg_replace( '/[^0-9+]/', '', $site_phone );
$site_email_href = sanitize_email( $site_email );

if ( '' === $site_phone_href ) {
	$site_phone_href = '+78122507378';
}

if ( '' === $site_email_href ) {
	$site_email_href = 'info@lvlneva.ru';
}

$transparent_header = (bool) apply_filters(
	'lvl_neva_is_transparent_header',
	is_front_page() || is_singular( 'services' )
);
$header_classes     = 'div section-header div--u-iqqstow7w is-visible';

if ( ! $transparent_header ) {
	$header_classes .= ' section-header--light-static';
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="mosaic-wrap">
	<div class="root">
		<div class="div page-wrapper">
			<header class="<?php echo esc_attr( $header_classes ); ?>">
				<div class="header_component text-color-white">
					<div class="padding-global header_pading">
						<nav class="space-between flex-direction-horizontal" aria-label="<?php esc_attr_e( 'Primary navigation', 'lvl-neva' ); ?>">
							<div class="flex-direction-horizontal size-width-auto">
								<a class="link-block logo_component" data-action-element="" href="<?php echo esc_url( home_url( '/' ) ); ?>">
									<div class="flex-direction-horizontal flex-align-center logo_gap">
										<div class="logo_img border-radius background-light-grey text-color-black">
											<div class="embed icon_full flex-center-all">
												<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
													<rect width="40" height="40" rx="3" fill="white" />
													<path d="M19.7773 8.2959L12.8887 13.4443L12.8516 32.0928L19.7959 32.083L19.7773 34.1484H6V15.9258L19.7773 6V8.2959ZM24.5186 9.11133V34.1484H20.2217V6L24.5186 9.11133ZM29.2588 12.5186V34.1484H24.9629V9.40723L29.2588 12.5186ZM34 15.9258V34.1475H29.7041V12.8145L34 15.9258Z" fill="#31572C" />
												</svg>
											</div>
										</div>
										<div class="logo_text">
											<div class="embed logo_text-svg flex-align-center flex-direction-horizontal">
												<span class="text heading-style-h6 text-color-white">LVL Neva</span>
											</div>
										</div>
									</div>
								</a>

								<div class="show-on-desktop">
									<div class="hedaer_gap-small flex-direction-horizontal">
										<a class="nav-btn text-style-body flex-align-center" href="<?php echo esc_url( $shop_archive_url ); ?>">
											<span class="nav-btn__label" data-label="Каталог">
												<span class="nav-btn__label-text">Каталог</span>
											</span>
											<span class="nav-btn__icon" aria-hidden="true">
												<svg class="nav-btn__icon-svg nav-btn__icon-svg--default" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M13 7V10.5859L13.4141 11H17V13H13.4141L13 13.4141V17H11V13.4141L10.5859 13H7V11H10.5859L11 10.5859V7H13Z" fill="currentColor"></path>
												</svg>
												<svg class="nav-btn__icon-svg nav-btn__icon-svg--hover" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M13 7V10.5859L13.4141 11H17V13H13.4141L13 13.4141V17H11V13.4141L10.5859 13H7V11H10.5859L11 10.5859V7H13Z" fill="currentColor"></path>
												</svg>
											</span>
										</a>

										<a class="nav-btn text-style-body flex-align-center" href="<?php echo esc_url( $services_archive_url ); ?>">
											<span class="nav-btn__label" data-label="Услуги">
												<span class="nav-btn__label-text">Услуги</span>
											</span>
											<span class="nav-btn__icon" aria-hidden="true">
												<svg class="nav-btn__icon-svg nav-btn__icon-svg--default" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M13 7V10.5859L13.4141 11H17V13H13.4141L13 13.4141V17H11V13.4141L10.5859 13H7V11H10.5859L11 10.5859V7H13Z" fill="currentColor"></path>
												</svg>
												<svg class="nav-btn__icon-svg nav-btn__icon-svg--hover" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M13 7V10.5859L13.4141 11H17V13H13.4141L13 13.4141V17H11V13.4141L10.5859 13H7V11H10.5859L11 10.5859V7H13Z" fill="currentColor"></path>
												</svg>
											</span>
										</a>
									</div>
								</div>
							</div>

							<div class="show-on-desktop size-width-auto">
								<div class="header_gap-large flex-direction-horizontal flex-align-center">
									<div class="site-nav__right is-desktop">
										<div class="site-nav__links flex-align-center">
											<a class="roll-link text-style-body" href="tel:<?php echo esc_attr( $site_phone_href ); ?>" data-label="<?php echo esc_attr( $site_phone ); ?>">
												<span class="roll-link__text"><?php echo esc_html( $site_phone ); ?></span>
											</a>
										</div>
									</div>

									<div class="site-nav__right is-desktop">
										<div class="site-nav__links flex-align-center">
											<?php foreach ( $primary_menu_items as $menu_item ) : ?>
												<a
													class="roll-link text-style-body"
													href="<?php echo esc_url( $menu_item->url ); ?>"
													data-label="<?php echo esc_attr( $menu_item->title ); ?>"
												>
													<span class="roll-link__text"><?php echo esc_html( $menu_item->title ); ?></span>
												</a>
											<?php endforeach; ?>
										</div>
									</div>

									<div class="hedaer_gap-small flex-direction-horizontal">
										<button class="nav-btn" type="button" data-search-drawer-open aria-label="Поиск" aria-controls="site-search-drawer-panel" aria-expanded="false">
											<span class="nav-btn__icon" aria-hidden="true">
												<svg class="nav-btn__icon-svg nav-btn__icon-svg--default" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M14.7793 3.47266L15.8613 4.55566L17.6562 8.8877V10.4189L15.8613 14.751L15.7129 14.8994L22.3994 21.5859L20.9854 23.001L14.0996 16.1143L10.4473 17.6279H8.91602L4.58398 15.833L3.50098 14.751L1.70703 10.4189V8.8877L3.50098 4.55566L4.58398 3.47266L8.91602 1.67871H10.4473L14.7793 3.47266ZM5.34961 5.32129L3.55469 9.65332L5.34961 13.9854L9.68164 15.7803L14.0137 13.9854L15.8086 9.65332L14.0137 5.32129L9.68164 3.52637L5.34961 5.32129Z" fill="white" style="fill: currentColor; fill-opacity: 1" />
												</svg>
												<svg class="nav-btn__icon-svg nav-btn__icon-svg--hover" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M14.7793 3.47266L15.8613 4.55566L17.6562 8.8877V10.4189L15.8613 14.751L15.7129 14.8994L22.3994 21.5859L20.9854 23.001L14.0996 16.1143L10.4473 17.6279H8.91602L4.58398 15.833L3.50098 14.751L1.70703 10.4189V8.8877L3.50098 4.55566L4.58398 3.47266L8.91602 1.67871H10.4473L14.7793 3.47266ZM5.34961 5.32129L3.55469 9.65332L5.34961 13.9854L9.68164 15.7803L14.0137 13.9854L15.8086 9.65332L14.0137 5.32129L9.68164 3.52637L5.34961 5.32129Z" fill="white" style="fill: currentColor; fill-opacity: 1" />
												</svg>
											</span>
										</button>

										<button class="nav-btn site-cart-trigger" type="button" data-cart-drawer-open aria-label="Корзина" aria-controls="site-cart-drawer-panel" aria-expanded="false">
											<span class="nav-btn__icon" aria-hidden="true">
												<svg class="nav-btn__icon-svg nav-btn__icon-svg--default" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M2.05078 2.0498H4.05078L6.71078 14.4698C6.80836 14.9247 7.06145 15.3313 7.42649 15.6197C7.79153 15.908 8.24569 16.0602 8.71078 16.0498H18.4908C18.946 16.0491 19.3873 15.8931 19.7418 15.6076C20.0964 15.3222 20.3429 14.9243 20.4408 14.4798L22.0908 7.0498H5.12078M9.00073 20.9998C9.00073 21.552 8.55302 21.9998 8.00073 21.9998C7.44845 21.9998 7.00073 21.552 7.00073 20.9998C7.00073 20.4475 7.44845 19.9998 8.00073 19.9998C8.55302 19.9998 9.00073 20.4475 9.00073 20.9998ZM20.0007 20.9998C20.0007 21.552 19.553 21.9998 19.0007 21.9998C18.4484 21.9998 18.0007 21.552 18.0007 20.9998C18.0007 20.4475 18.4484 19.9998 19.0007 19.9998C19.553 19.9998 20.0007 20.4475 20.0007 20.9998Z" stroke="white" style="stroke: currentColor; stroke-opacity: 1" stroke-width="2" stroke-linejoin="bevel" />
												</svg>
												<svg class="nav-btn__icon-svg nav-btn__icon-svg--hover" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M2.05078 2.0498H4.05078L6.71078 14.4698C6.80836 14.9247 7.06145 15.3313 7.42649 15.6197C7.79153 15.908 8.24569 16.0602 8.71078 16.0498H18.4908C18.946 16.0491 19.3873 15.8931 19.7418 15.6076C20.0964 15.3222 20.3429 14.9243 20.4408 14.4798L22.0908 7.0498H5.12078M9.00073 20.9998C9.00073 21.552 8.55302 21.9998 8.00073 21.9998C7.44845 21.9998 7.00073 21.552 7.00073 20.9998C7.00073 20.4475 7.44845 19.9998 8.00073 19.9998C8.55302 19.9998 9.00073 20.4475 9.00073 20.9998ZM20.0007 20.9998C20.0007 21.552 19.553 21.9998 19.0007 21.9998C18.4484 21.9998 18.0007 21.552 18.0007 20.9998C18.0007 20.4475 18.4484 19.9998 19.0007 19.9998C19.553 19.9998 20.0007 20.4475 20.0007 20.9998Z" stroke="white" style="stroke: currentColor; stroke-opacity: 1" stroke-width="2" stroke-linejoin="bevel" />
												</svg>
											</span>
											<?php echo $cart_count_badge; ?>
										</button>

										<button class="nav-btn text-style-body flex-align-center" type="button" data-contact-drawer-open aria-controls="site-contact-drawer-panel" aria-expanded="false">
											<span class="nav-btn__label" data-label="Связаться с нами">
												<span class="nav-btn__label-text">Связаться с нами</span>
											</span>
											<span class="nav-btn__icon" aria-hidden="true">
												<svg class="nav-btn__icon-svg nav-btn__icon-svg--default" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M13 7V10.5859L13.4141 11H17V13H13.4141L13 13.4141V17H11V13.4141L10.5859 13H7V11H10.5859L11 10.5859V7H13Z" fill="currentColor"></path>
												</svg>
												<svg class="nav-btn__icon-svg nav-btn__icon-svg--hover" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M13 7V10.5859L13.4141 11H17V13H13.4141L13 13.4141V17H11V13.4141L10.5859 13H7V11H10.5859L11 10.5859V7H13Z" fill="currentColor"></path>
												</svg>
											</span>
										</button>
									</div>
								</div>
							</div>

							<div class="mobile hedaer_gap-small show-on-tablet">
								<button class="nav-btn" type="button" data-search-drawer-open aria-label="Поиск" aria-controls="site-search-drawer-panel" aria-expanded="false">
									<span class="nav-btn__icon" aria-hidden="true">
										<svg class="nav-btn__icon-svg nav-btn__icon-svg--default" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M14.7793 3.47266L15.8613 4.55566L17.6562 8.8877V10.4189L15.8613 14.751L15.7129 14.8994L22.3994 21.5859L20.9854 23.001L14.0996 16.1143L10.4473 17.6279H8.91602L4.58398 15.833L3.50098 14.751L1.70703 10.4189V8.8877L3.50098 4.55566L4.58398 3.47266L8.91602 1.67871H10.4473L14.7793 3.47266ZM5.34961 5.32129L3.55469 9.65332L5.34961 13.9854L9.68164 15.7803L14.0137 13.9854L15.8086 9.65332L14.0137 5.32129L9.68164 3.52637L5.34961 5.32129Z" fill="white" style="fill: currentColor; fill-opacity: 1" />
										</svg>
										<svg class="nav-btn__icon-svg nav-btn__icon-svg--hover" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M14.7793 3.47266L15.8613 4.55566L17.6562 8.8877V10.4189L15.8613 14.751L15.7129 14.8994L22.3994 21.5859L20.9854 23.001L14.0996 16.1143L10.4473 17.6279H8.91602L4.58398 15.833L3.50098 14.751L1.70703 10.4189V8.8877L3.50098 4.55566L4.58398 3.47266L8.91602 1.67871H10.4473L14.7793 3.47266ZM5.34961 5.32129L3.55469 9.65332L5.34961 13.9854L9.68164 15.7803L14.0137 13.9854L15.8086 9.65332L14.0137 5.32129L9.68164 3.52637L5.34961 5.32129Z" fill="white" style="fill: currentColor; fill-opacity: 1" />
										</svg>
									</span>
								</button>

								<button class="nav-btn site-cart-trigger" type="button" data-cart-drawer-open aria-label="Корзина" aria-controls="site-cart-drawer-panel" aria-expanded="false">
									<span class="nav-btn__icon" aria-hidden="true">
										<svg class="nav-btn__icon-svg nav-btn__icon-svg--default" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M2.05078 2.0498H4.05078L6.71078 14.4698C6.80836 14.9247 7.06145 15.3313 7.42649 15.6197C7.79153 15.908 8.24569 16.0602 8.71078 16.0498H18.4908C18.946 16.0491 19.3873 15.8931 19.7418 15.6076C20.0964 15.3222 20.3429 14.9243 20.4408 14.4798L22.0908 7.0498H5.12078M9.00073 20.9998C9.00073 21.552 8.55302 21.9998 8.00073 21.9998C7.44845 21.9998 7.00073 21.552 7.00073 20.9998C7.00073 20.4475 7.44845 19.9998 8.00073 19.9998C8.55302 19.9998 9.00073 20.4475 9.00073 20.9998ZM20.0007 20.9998C20.0007 21.552 19.553 21.9998 19.0007 21.9998C18.4484 21.9998 18.0007 21.552 18.0007 20.9998C18.0007 20.4475 18.4484 19.9998 19.0007 19.9998C19.553 19.9998 20.0007 20.4475 20.0007 20.9998Z" stroke="white" style="stroke: currentColor; stroke-opacity: 1" stroke-width="2" stroke-linejoin="bevel" />
										</svg>
										<svg class="nav-btn__icon-svg nav-btn__icon-svg--hover" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M2.05078 2.0498H4.05078L6.71078 14.4698C6.80836 14.9247 7.06145 15.3313 7.42649 15.6197C7.79153 15.908 8.24569 16.0602 8.71078 16.0498H18.4908C18.946 16.0491 19.3873 15.8931 19.7418 15.6076C20.0964 15.3222 20.3429 14.9243 20.4408 14.4798L22.0908 7.0498H5.12078M9.00073 20.9998C9.00073 21.552 8.55302 21.9998 8.00073 21.9998C7.44845 21.9998 7.00073 21.552 7.00073 20.9998C7.00073 20.4475 7.44845 19.9998 8.00073 19.9998C8.55302 19.9998 9.00073 20.4475 9.00073 20.9998ZM20.0007 20.9998C20.0007 21.552 19.553 21.9998 19.0007 21.9998C18.4484 21.9998 18.0007 21.552 18.0007 20.9998C18.0007 20.4475 18.4484 19.9998 19.0007 19.9998C19.553 19.9998 20.0007 20.4475 20.0007 20.9998Z" stroke="white" style="stroke: currentColor; stroke-opacity: 1" stroke-width="2" stroke-linejoin="bevel" />
										</svg>
									</span>
									<?php echo $cart_count_badge; ?>
								</button>

								<button class="nav-btn text-style-body flex-align-center hedaer_gap-small" type="button" data-menu-trigger="open">
									<span class="nav-btn__label" data-label="Меню">
										<span class="nav-btn__label-text">Меню</span>
									</span>
									<span class="nav-btn__icon" aria-hidden="true">
										<svg class="nav-btn__icon-svg nav-btn__icon-svg--default" fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
											<path d="M17.5 15.835H2.5V14.168H17.5V15.835ZM17.5 10.835H2.5V9.16797H17.5V10.835ZM17.5 5.83496H2.5V4.16797H17.5V5.83496Z" fill="currentColor"></path>
										</svg>
										<svg class="nav-btn__icon-svg nav-btn__icon-svg--hover" fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
											<path d="M17.5 15.835H2.5V14.168H17.5V15.835ZM17.5 10.835H2.5V9.16797H17.5V10.835ZM17.5 5.83496H2.5V4.16797H17.5V5.83496Z" fill="currentColor"></path>
										</svg>
									</span>
								</button>
							</div>
						</nav>
					</div>
				</div>
			</header>

			<nav modal-menu="" class="div size-full-screen menu_component background-light-grey mobile-menu-v2" aria-hidden="true">
				<div class="div size-height-full flex-direction-vertical mobile-menu-v2__wrap">
					<div class="div flex-direction-vertical size-width-full mobile-menu-v2__main">
						<div class="div flex-direction-horizontal space-between mobile-menu-v2__top">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" data-action-element="" class="link-block logo_component mobile-menu-v2__logo">
								<div class="div flex-direction-horizontal flex-align-center mobile-menu-v2__logo-row">
									<div class="div logo_img border-radius background-brand mobile-menu-v2__logo-icon">
										<div class="embed icon_full text-color-white flex-center-all">
											<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
												<rect width="30" height="30" rx="2.25" fill="#31572C" />
												<path d="M14.8329 6.22128L9.66687 10.0826L9.63855 24.068L14.8475 24.0611L14.8329 25.61H4.49988V11.943L14.8329 4.4996V6.22128ZM18.3885 6.83261V25.61H15.1659V4.4996L18.3885 6.83261ZM21.9442 9.38828V25.61H18.7225V7.05527L21.9442 9.38828ZM25.5009 11.9439V25.61H22.2782V9.61093L25.5009 11.9439Z" fill="white" />
											</svg>
										</div>
									</div>
									<div class="div logo_text mobile-menu-v2__logo-text">
										<div class="embed logo_text-svg flex-direction-horizontal flex-align-center">
											<span class="text heading-style-h6">LVL Neva</span>
										</div>
									</div>
								</div>
							</a>

							<button type="button" menu-trigger="close" class="mobile-menu-v2__close">
								<span class="mobile-menu-v2__close-text">Закрыть</span>
								<span class="mobile-menu-v2__close-icon" aria-hidden="true">
									<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M4.33337 11.6667L8.00004 7.99999M11.6667 4.33333L8.00004 7.99999M8.00004 7.99999L4.33337 4.33333M8.00004 7.99999L11.6667 11.6667" stroke="#010101" stroke-width="1.33333" />
									</svg>
								</span>
							</button>
						</div>

						<div class="div flex-direction-vertical size-width-full mobile-menu-v2__content">
							<div class="div flex-direction-vertical size-width-full mobile-menu-v2__links">
								<a href="<?php echo esc_url( $shop_archive_url ); ?>" class="link-block mobile-menu-v2__card mobile-menu-v2__card--accent">
									<span class="mobile-menu-v2__card-text">Каталог</span>
								</a>
								<a href="<?php echo esc_url( $services_archive_url ); ?>" class="link-block mobile-menu-v2__card mobile-menu-v2__card--accent">
									<span class="mobile-menu-v2__card-text">Услуги</span>
								</a>

								<div class="div flex-direction-vertical size-width-full mobile-menu-v2__stack">
									<?php foreach ( $primary_menu_items as $menu_index => $menu_item ) : ?>
										<a href="<?php echo esc_url( $menu_item->url ); ?>" class="link-block mobile-menu-v2__row">
											<span class="mobile-menu-v2__row-text"><?php echo esc_html( $menu_item->title ); ?></span>
										</a>
										<?php if ( $menu_index < count( $primary_menu_items ) - 1 ) : ?>
											<div class="mobile-menu-v2__divider"></div>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							</div>

							<div class="div flex-direction-vertical size-width-full mobile-menu-v2__actions">
								<div class="div flex-direction-horizontal size-width-full mobile-menu-v2__action-row">
									<button type="button" class="mobile-menu-v2__icon-button" data-search-drawer-open aria-label="Поиск" aria-controls="site-search-drawer-panel" aria-expanded="false">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M14.7803 3.47266L15.8623 4.55566L17.6572 8.8877V10.4189L15.8623 14.751L15.7139 14.8994L22.4004 21.5859L20.9863 23.001L14.1006 16.1143L10.4482 17.6279H8.91699L4.58496 15.833L3.50195 14.751L1.70801 10.4189V8.8877L3.50195 4.55566L4.58496 3.47266L8.91699 1.67871H10.4482L14.7803 3.47266ZM5.35059 5.32129L3.55566 9.65332L5.35059 13.9854L9.68262 15.7803L14.0146 13.9854L15.8096 9.65332L14.0146 5.32129L9.68262 3.52637L5.35059 5.32129Z" fill="#010101" />
										</svg>
									</button>

									<button type="button" class="mobile-menu-v2__icon-button site-cart-trigger" data-cart-drawer-open aria-label="Корзина" aria-controls="site-cart-drawer-panel" aria-expanded="false">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M2.05005 2.05005H4.05005L6.71005 14.47C6.80763 14.9249 7.06072 15.3315 7.42576 15.6199C7.7908 15.9083 8.24495 16.0604 8.71005 16.05H18.49C18.9452 16.0493 19.3865 15.8933 19.7411 15.6079C20.0956 15.3224 20.3422 14.9246 20.4401 14.48L22.09 7.05005H5.12005M9 21C9 21.5523 8.55228 22 8 22C7.44772 22 7 21.5523 7 21C7 20.4477 7.44772 20 8 20C8.55228 20 9 20.4477 9 21ZM20 21C20 21.5523 19.5523 22 19 22C18.4477 22 18 21.5523 18 21C18 20.4477 18.4477 20 19 20C19.5523 20 20 20.4477 20 21Z" stroke="#010101" stroke-width="2" stroke-linejoin="bevel" />
										</svg>
										<?php echo $cart_count_badge; ?>
									</button>
								</div>

								<button type="button" class="mobile-menu-v2__cta" data-contact-drawer-open aria-controls="site-contact-drawer-panel" aria-expanded="false">
									<span>Связаться с нами</span>
									<span aria-hidden="true">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M7.48999 16.3875L11 12.8775L11 12L11 11.1225L7.48999 7.61249" stroke="#31572C" stroke-width="2" />
											<path d="M13 16.3875L16.51 12.8775L16.51 12L16.51 11.1225L13 7.61249" stroke="#31572C" stroke-width="2" />
										</svg>
									</span>
								</button>
							</div>
						</div>
					</div>

					<div class="div flex-direction-horizontal space-between size-width-full mobile-menu-v2__bottom">
						<a href="tel:<?php echo esc_attr( $site_phone_href ); ?>" class="mobile-menu-v2__contact"><?php echo esc_html( $site_phone ); ?></a>
						<a href="mailto:<?php echo esc_attr( $site_email_href ); ?>" class="mobile-menu-v2__contact"><?php echo esc_html( $site_email ); ?></a>
					</div>
				</div>
			</nav>
			<main class="div main-wrapper">
