<?php

/**
 * Thiết lập stylesheet và nạp chức năng của các module trong theme nhóm A.
 */

if (! defined('ABSPATH')) {
	exit;
}

if (! function_exists('gcn_twentytwenty_enqueue_styles')) {
	/** Nạp stylesheet của theme cha, theme con và bố cục dùng chung. */
	function gcn_twentytwenty_enqueue_styles()
	{
		$parent_theme   = wp_get_theme('twentytwenty');
		$child_theme    = wp_get_theme();
		$layout_path    = get_stylesheet_directory() . '/assets/css/layout.css';
		$layout_version = is_readable($layout_path) ? (string) filemtime($layout_path) : $child_theme->get('Version');

		wp_enqueue_style(
			'gcn-twentytwenty-parent',
			get_template_directory_uri() . '/style.css',
			array(),
			$parent_theme->get('Version')
		);

		wp_enqueue_style(
			'nhom-a-twentytwenty-child',
			get_stylesheet_uri(),
			array('gcn-twentytwenty-parent'),
			$child_theme->get('Version')
		);

		wp_enqueue_style(
			'gcn-search-detail',
			get_stylesheet_directory_uri() . '/assets/css/layout.css',
			array('nhom-a-twentytwenty-child'),
			$layout_version
		);

		$module_header_path    = get_stylesheet_directory() . '/modules/module-01/header.css';
		$module_header_version = is_readable($module_header_path) ? (string) filemtime($module_header_path) : $child_theme->get('Version');

		wp_enqueue_style(
			'gcn-module-01-bootstrap',
			'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css',
			array('gcn-search-detail'),
			'3.3.0'
		);

		wp_enqueue_style(
			'gcn-module-01-header',
			get_stylesheet_directory_uri() . '/modules/module-01/header.css',
			array('gcn-module-01-bootstrap'),
			$module_header_version
		);

		$module_comments_path    = get_stylesheet_directory() . '/modules/module-14/comments.css';
		$module_comments_version = is_readable($module_comments_path) ? (string) filemtime($module_comments_path) : $child_theme->get('Version');

		wp_enqueue_style(
			'gcn-module-14-comments',
			get_stylesheet_directory_uri() . '/modules/module-14/comments.css',
			array('gcn-module-01-header'),
			$module_comments_version
		);

		// Nạp CSS cho Module 07
		$module_07_css_path    = get_stylesheet_directory() . '/modules/module-07/style.css';
		$module_07_css_version = is_readable($module_07_css_path) ? (string) filemtime($module_07_css_path) : $child_theme->get('Version');

		wp_enqueue_style(
			'gcn-module-07-prevnext',
			get_stylesheet_directory_uri() . '/modules/module-07/style.css',
			array('nhom-a-twentytwenty-child'),
			$module_07_css_version
		);

		wp_enqueue_script('jquery');
		wp_enqueue_script(
			'gcn-module-01-bootstrap',
			'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js',
			array('jquery'),
			'3.3.0',
			true
		);
		// Nạp CSS cho Module 11 (Archive)
		$module_11_css_path    = get_stylesheet_directory() . '/modules/module-11/style.css';
		$module_11_css_version = is_readable($module_11_css_path) ? (string) filemtime($module_11_css_path) : $child_theme->get('Version');

		wp_enqueue_style(
			'gcn-module-11-archive',
			get_stylesheet_directory_uri() . '/modules/module-11/style.css',
			array('nhom-a-twentytwenty-child'),
			$module_11_css_version
		);
	}
}

if (! has_action('wp_enqueue_scripts', 'gcn_twentytwenty_enqueue_styles')) {
	add_action('wp_enqueue_scripts', 'gcn_twentytwenty_enqueue_styles', 20);
}

if (! function_exists('nhom_a_load_module_functions')) {
	/** Nạp file functions.php của module nếu module đó đã có code PHP. */
	function nhom_a_load_module_functions()
	{
		for ($module_number = 1; $module_number <= 20; $module_number++) {
			$module_file = get_stylesheet_directory() . sprintf(
				'/modules/module-%02d/functions.php',
				$module_number
			);

			if (is_readable($module_file)) {
				require_once $module_file;
			}
		}
	}
}
nhom_a_load_module_functions();
