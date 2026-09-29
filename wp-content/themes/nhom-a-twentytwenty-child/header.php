<?php
/**
 * Nạp header module 01 trên mọi template dùng get_header().
 */

if ( ! function_exists( 'nhom_a_module_01_header' ) ) {
	function nhom_a_module_01_header() {
		$module_header = get_stylesheet_directory() . '/modules/module-01/header.php';

		if ( is_readable( $module_header ) ) {
			require $module_header;
		}
	}
}

add_action( 'wp_body_open', 'nhom_a_module_01_header', 5 );

require get_template_directory() . '/header.php';
