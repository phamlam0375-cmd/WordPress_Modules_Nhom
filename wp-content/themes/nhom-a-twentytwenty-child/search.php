<?php
/**
 * Entry point bắt buộc của WordPress cho trang kết quả tìm kiếm.
 */

$search_template = get_stylesheet_directory() . '/modules/module-05/search-template.php';

if ( is_readable( $search_template ) ) {
	require $search_template;
	return;
}

require get_template_directory() . '/index.php';
