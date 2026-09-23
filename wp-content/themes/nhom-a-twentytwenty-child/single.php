<?php
/**
 * Entry point bắt buộc của WordPress cho trang chi tiết bài viết.
 */

$single_template = get_stylesheet_directory() . '/modules/module-06/single-template.php';

if ( is_readable( $single_template ) ) {
	require $single_template;
	return;
}

require get_template_directory() . '/singular.php';
