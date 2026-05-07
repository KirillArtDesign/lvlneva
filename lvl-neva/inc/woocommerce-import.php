<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function lvl_neva_has_non_ascii_path( $path ) {
	return 1 === preg_match( '/[^\x20-\x7E]/', (string) $path );
}

function lvl_neva_is_woocommerce_product_import_request() {
	if ( ! is_admin() ) {
		return false;
	}

	$page      = isset( $_REQUEST['page'] ) ? sanitize_key( wp_unslash( $_REQUEST['page'] ) ) : '';
	$post_type = isset( $_REQUEST['post_type'] ) ? sanitize_key( wp_unslash( $_REQUEST['post_type'] ) ) : '';
	$action    = isset( $_REQUEST['action'] ) ? sanitize_key( wp_unslash( $_REQUEST['action'] ) ) : '';

	if ( 'product_importer' === $page && 'product' === $post_type ) {
		return true;
	}

	return wp_doing_ajax() && 'woocommerce_do_ajax_product_import' === $action;
}

function lvl_neva_get_woocommerce_import_temp_dir() {
	return trailingslashit( wp_normalize_path( sys_get_temp_dir() ) ) . 'lvl-neva-woocommerce-imports';
}

function lvl_neva_use_ascii_temp_dir_for_woocommerce_imports( $uploads ) {
	if ( ! lvl_neva_is_woocommerce_product_import_request() || ! lvl_neva_has_non_ascii_path( ABSPATH ) ) {
		return $uploads;
	}

	// WooCommerce normalizes import file paths through parse_url(), which breaks local multibyte paths.
	$temp_dir = lvl_neva_get_woocommerce_import_temp_dir();

	if ( ! is_dir( $temp_dir ) ) {
		wp_mkdir_p( $temp_dir );
	}

	$uploads['basedir'] = $temp_dir;
	$uploads['baseurl'] = content_url( 'uploads/wc-imports-temp' );
	$uploads['path']    = $temp_dir . ( $uploads['subdir'] ?? '' );
	$uploads['url']     = $uploads['baseurl'] . ( $uploads['subdir'] ?? '' );

	return $uploads;
}
add_filter( 'upload_dir', 'lvl_neva_use_ascii_temp_dir_for_woocommerce_imports', 5 );

function lvl_neva_get_product_images_csv_path() {
	return (string) apply_filters( 'lvl_neva_product_images_csv_path', '/Users/kirill/Downloads/wc-product23.csv' );
}

function lvl_neva_can_repair_product_images() {
	return current_user_can( 'manage_woocommerce' ) || current_user_can( 'manage_options' );
}

function lvl_neva_get_product_images_csv_signature( $csv_path ) {
	if ( ! is_readable( $csv_path ) ) {
		return '';
	}

	return md5( $csv_path . '|' . (string) filesize( $csv_path ) . '|' . (string) filemtime( $csv_path ) );
}

function lvl_neva_get_product_import_csv_value( $row, $keys ) {
	foreach ( $keys as $key ) {
		if ( isset( $row[ $key ] ) ) {
			return trim( (string) $row[ $key ] );
		}
	}

	return '';
}

function lvl_neva_get_upload_relative_path_from_file( $file_path ) {
	$uploads = wp_get_upload_dir();
	$basedir = trailingslashit( wp_normalize_path( $uploads['basedir'] ) );
	$path    = wp_normalize_path( $file_path );

	if ( 0 !== strpos( $path, $basedir ) ) {
		return '';
	}

	return ltrim( substr( $path, strlen( $basedir ) ), '/' );
}

function lvl_neva_find_attachment_id_by_upload_relative_path( $relative_path ) {
	global $wpdb;

	$relative_path = trim( (string) $relative_path );

	if ( '' === $relative_path ) {
		return 0;
	}

	return (int) $wpdb->get_var(
		$wpdb->prepare(
			"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_wp_attached_file' AND meta_value = %s LIMIT 1",
			$relative_path
		)
	);
}

function lvl_neva_resolve_product_image_url_to_file_path( $image_url ) {
	$image_url = trim( (string) $image_url );

	if ( '' === $image_url ) {
		return '';
	}

	$url_path = wp_parse_url( $image_url, PHP_URL_PATH );

	if ( ! is_string( $url_path ) || '' === $url_path ) {
		return '';
	}

	$url_path = rawurldecode( $url_path );
	$marker   = '/wp-content/uploads/';
	$position = strpos( $url_path, $marker );

	if ( false === $position ) {
		return '';
	}

	return wp_normalize_path( ABSPATH . ltrim( substr( $url_path, $position + 1 ), '/' ) );
}

function lvl_neva_get_or_create_product_image_attachment( $file_path, $parent_id = 0 ) {
	$file_path     = wp_normalize_path( $file_path );
	$relative_path = lvl_neva_get_upload_relative_path_from_file( $file_path );

	if ( '' === $relative_path || ! file_exists( $file_path ) ) {
		return 0;
	}

	$existing_attachment_id = lvl_neva_find_attachment_id_by_upload_relative_path( $relative_path );

	if ( $existing_attachment_id > 0 ) {
		return $existing_attachment_id;
	}

	if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
		require_once ABSPATH . 'wp-admin/includes/image.php';
	}

	$uploads     = wp_get_upload_dir();
	$mime_type   = wp_check_filetype( wp_basename( $file_path ), null );
	$title       = preg_replace( '/\.[^.]+$/', '', wp_basename( $file_path ) );
	$attachment  = array(
		'guid'           => trailingslashit( $uploads['baseurl'] ) . $relative_path,
		'post_mime_type' => ! empty( $mime_type['type'] ) ? $mime_type['type'] : 'image/jpeg',
		'post_title'     => $title,
		'post_content'   => '',
		'post_status'    => 'inherit',
		'post_parent'    => (int) $parent_id,
	);
	$attachment_id = wp_insert_attachment( $attachment, $file_path, $parent_id, true );

	if ( is_wp_error( $attachment_id ) ) {
		return 0;
	}

	update_attached_file( $attachment_id, $file_path );

	$metadata = wp_generate_attachment_metadata( $attachment_id, $file_path );

	if ( ! empty( $metadata ) ) {
		wp_update_attachment_metadata( $attachment_id, $metadata );
	}

	return (int) $attachment_id;
}

function lvl_neva_read_product_images_csv_rows( $csv_path ) {
	$handle = fopen( $csv_path, 'r' );

	if ( false === $handle ) {
		return new WP_Error( 'csv_open_failed', __( 'Не удалось открыть CSV файл с товарами.', 'lvl-neva' ) );
	}

	$header = fgetcsv( $handle );

	if ( ! is_array( $header ) || empty( $header ) ) {
		fclose( $handle );
		return new WP_Error( 'csv_header_failed', __( 'В CSV не найдена строка заголовков.', 'lvl-neva' ) );
	}

	$header = array_map(
		static function ( $value ) {
			$value = trim( (string) $value );

			return preg_replace( '/^\xEF\xBB\xBF/', '', $value );
		},
		$header
	);

	$rows = array();

	while ( ( $data = fgetcsv( $handle ) ) !== false ) {
		if ( empty( array_filter( $data, 'strlen' ) ) ) {
			continue;
		}

		$data = array_pad( $data, count( $header ), '' );
		$rows[] = array_combine( $header, $data );
	}

	fclose( $handle );

	return $rows;
}

function lvl_neva_repair_product_images_from_csv( $csv_path ) {
	$rows = lvl_neva_read_product_images_csv_rows( $csv_path );

	if ( is_wp_error( $rows ) ) {
		return array(
			'status'  => 'error',
			'message' => $rows->get_error_message(),
		);
	}

	$result = array(
		'status'               => 'success',
		'message'              => '',
		'processed_products'   => 0,
		'updated_products'     => 0,
		'created_attachments'  => 0,
		'reused_attachments'   => 0,
		'missing_products'     => array(),
		'missing_files'        => array(),
	);

	foreach ( $rows as $row ) {
		$image_urls = lvl_neva_get_product_import_csv_value(
			$row,
			array( 'Изображения', 'Images', 'images' )
		);

		if ( '' === $image_urls ) {
			continue;
		}

		$product_id = 0;
		$sku        = lvl_neva_get_product_import_csv_value( $row, array( 'Артикул', 'SKU', 'Sku' ) );
		$csv_id     = absint( lvl_neva_get_product_import_csv_value( $row, array( 'ID', 'Id', 'id' ) ) );

		if ( '' !== $sku && function_exists( 'wc_get_product_id_by_sku' ) ) {
			$product_id = (int) wc_get_product_id_by_sku( $sku );
		}

		if ( $product_id < 1 && $csv_id > 0 && 'product' === get_post_type( $csv_id ) ) {
			$product_id = $csv_id;
		}

		if ( $product_id < 1 ) {
			$result['missing_products'][] = '' !== $sku ? $sku : (string) $csv_id;
			continue;
		}

		$result['processed_products']++;
		$attachment_ids = array();

		foreach ( array_map( 'trim', explode( ',', $image_urls ) ) as $image_url ) {
			if ( '' === $image_url ) {
				continue;
			}

			$file_path = lvl_neva_resolve_product_image_url_to_file_path( $image_url );

			if ( '' === $file_path || ! file_exists( $file_path ) ) {
				$result['missing_files'][] = $image_url;
				continue;
			}

			$relative_path        = lvl_neva_get_upload_relative_path_from_file( $file_path );
			$existing_attachment  = lvl_neva_find_attachment_id_by_upload_relative_path( $relative_path );
			$attachment_id        = lvl_neva_get_or_create_product_image_attachment( $file_path, $product_id );

			if ( $attachment_id < 1 ) {
				$result['missing_files'][] = $image_url;
				continue;
			}

			if ( $existing_attachment > 0 ) {
				$result['reused_attachments']++;
			} else {
				$result['created_attachments']++;
			}

			$attachment_ids[] = $attachment_id;
		}

		$attachment_ids = array_values( array_unique( array_filter( array_map( 'absint', $attachment_ids ) ) ) );

		if ( empty( $attachment_ids ) ) {
			continue;
		}

		$new_thumbnail_id = $attachment_ids[0];
		$new_gallery      = implode( ',', array_slice( $attachment_ids, 1 ) );
		$was_updated      = false;

		if ( (int) get_post_thumbnail_id( $product_id ) !== $new_thumbnail_id ) {
			set_post_thumbnail( $product_id, $new_thumbnail_id );
			$was_updated = true;
		}

		if ( (string) get_post_meta( $product_id, '_product_image_gallery', true ) !== $new_gallery ) {
			update_post_meta( $product_id, '_product_image_gallery', $new_gallery );
			$was_updated = true;
		}

		if ( $was_updated ) {
			$result['updated_products']++;
			wc_delete_product_transients( $product_id );
		}
	}

	$result['missing_products'] = array_values( array_unique( array_filter( $result['missing_products'] ) ) );
	$result['missing_files']    = array_values( array_unique( array_filter( $result['missing_files'] ) ) );
	$result['message']          = sprintf(
		'Товары обработаны: %1$d. Обновлены: %2$d. Новых вложений: %3$d. Переиспользовано вложений: %4$d.',
		(int) $result['processed_products'],
		(int) $result['updated_products'],
		(int) $result['created_attachments'],
		(int) $result['reused_attachments']
	);

	return $result;
}

function lvl_neva_maybe_repair_product_images_from_csv() {
	if (
		! is_admin()
		|| wp_doing_ajax()
		|| lvl_neva_is_woocommerce_product_import_request()
		|| ! lvl_neva_can_repair_product_images()
		|| ! function_exists( 'wc_delete_product_transients' )
	) {
		return;
	}

	$csv_path = lvl_neva_get_product_images_csv_path();

	if ( ! is_readable( $csv_path ) ) {
		return;
	}

	$signature = lvl_neva_get_product_images_csv_signature( $csv_path );

	if ( '' === $signature ) {
		return;
	}

	$force_run = isset( $_GET['lvl_neva_rerun_product_image_repair'] );

	if ( $force_run ) {
		check_admin_referer( 'lvl_neva_rerun_product_image_repair' );
	}

	$stored_signature = (string) get_option( 'lvl_neva_product_images_csv_signature', '' );

	if ( ! $force_run && $stored_signature === $signature ) {
		return;
	}

	$result = lvl_neva_repair_product_images_from_csv( $csv_path );

	update_option( 'lvl_neva_product_images_csv_signature', $signature, false );
	set_transient( 'lvl_neva_product_images_csv_repair_result', $result, HOUR_IN_SECONDS );

	if ( $force_run && ! headers_sent() ) {
		wp_safe_redirect( admin_url( 'edit.php?post_type=product' ) );
		exit;
	}
}
add_action( 'admin_init', 'lvl_neva_maybe_repair_product_images_from_csv', 20 );

function lvl_neva_render_product_images_repair_notice() {
	if ( ! is_admin() || ! lvl_neva_can_repair_product_images() ) {
		return;
	}

	$result = get_transient( 'lvl_neva_product_images_csv_repair_result' );

	if ( ! is_array( $result ) || empty( $result['message'] ) ) {
		return;
	}

	delete_transient( 'lvl_neva_product_images_csv_repair_result' );

	$notice_class = 'notice notice-success';

	if ( ! empty( $result['status'] ) && 'error' === $result['status'] ) {
		$notice_class = 'notice notice-error';
	}

	$rerun_url = wp_nonce_url(
		admin_url( 'edit.php?post_type=product&lvl_neva_rerun_product_image_repair=1' ),
		'lvl_neva_rerun_product_image_repair'
	);
	?>
	<div class="<?php echo esc_attr( $notice_class ); ?>">
		<p><?php echo esc_html( $result['message'] ); ?></p>
		<?php if ( ! empty( $result['missing_products'] ) ) : ?>
			<p><?php echo esc_html( 'Не найдены товары: ' . implode( ', ', array_slice( $result['missing_products'], 0, 10 ) ) ); ?></p>
		<?php endif; ?>
		<?php if ( ! empty( $result['missing_files'] ) ) : ?>
			<p><?php echo esc_html( 'Не найдены файлы: ' . implode( ', ', array_slice( $result['missing_files'], 0, 5 ) ) ); ?></p>
		<?php endif; ?>
		<p><a class="button button-secondary" href="<?php echo esc_url( $rerun_url ); ?>">Запустить восстановление еще раз</a></p>
	</div>
	<?php
}
add_action( 'admin_notices', 'lvl_neva_render_product_images_repair_notice' );
