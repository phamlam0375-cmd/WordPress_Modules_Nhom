<?php
/**
 * Thiết lập stylesheet và nạp chức năng của các module trong theme nhóm A.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gcn_twentytwenty_enqueue_styles' ) ) {
	/** Nạp stylesheet của theme cha, theme con và bố cục dùng chung. */
	function gcn_twentytwenty_enqueue_styles() {
		$parent_theme   = wp_get_theme( 'twentytwenty' );
		$child_theme    = wp_get_theme();
		$layout_path    = get_stylesheet_directory() . '/assets/css/layout.css';
		$layout_version = is_readable( $layout_path ) ? (string) filemtime( $layout_path ) : $child_theme->get( 'Version' );

		wp_enqueue_style(
			'gcn-twentytwenty-parent',
			get_template_directory_uri() . '/style.css',
			array(),
			$parent_theme->get( 'Version' )
		);

		wp_enqueue_style(
			'nhom-a-twentytwenty-child',
			get_stylesheet_uri(),
			array( 'gcn-twentytwenty-parent' ),
			$child_theme->get( 'Version' )
		);

		wp_enqueue_style(
			'gcn-search-detail',
			get_stylesheet_directory_uri() . '/assets/css/layout.css',
			array( 'nhom-a-twentytwenty-child' ),
			$layout_version
		);
	}
}

if ( ! has_action( 'wp_enqueue_scripts', 'gcn_twentytwenty_enqueue_styles' ) ) {
	add_action( 'wp_enqueue_scripts', 'gcn_twentytwenty_enqueue_styles', 20 );
}

if ( ! function_exists( 'nhom_a_load_module_functions' ) ) {
	/** Nạp file functions.php của module nếu module đó đã có code PHP. */
	function nhom_a_load_module_functions() {
		for ( $module_number = 1; $module_number <= 20; $module_number++ ) {
			$module_file = get_stylesheet_directory() . sprintf(
				'/modules/module-%02d/functions.php',
				$module_number
			);

			if ( is_readable( $module_file ) ) {
				require_once $module_file;
			}
		}
	}
}
nhom_a_load_module_functions();
