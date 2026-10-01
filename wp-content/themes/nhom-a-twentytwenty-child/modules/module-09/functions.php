<?php

/**
 * Module 09: Categories
 * Hiển thị ở cột trái trang chi tiết bài viết (hook nhom_a_single_left_column).
 */

if (! defined('ABSPATH')) {
	exit;
}

if (! function_exists('module09_render_categories')) {
	/** In danh sách chuyên mục. */
	function module09_render_categories()
	{
		include __DIR__ . '/categories.php';
	}
}
add_action('nhom_a_single_left_column', 'module09_render_categories');

if (! function_exists('module09_enqueue_styles')) {
	/** Nạp CSS của module trên trang chi tiết bài viết. */
	function module09_enqueue_styles()
	{
		if (! is_singular('post')) {
			return;
		}

		$css_path = __DIR__ . '/style.css';

		wp_enqueue_style(
			'module09-categories',
			get_stylesheet_directory_uri() . '/modules/module-09/style.css',
			array('gcn-search-detail'),
			is_readable($css_path) ? (string) filemtime($css_path) : '1.0.0'
		);
	}
}
add_action('wp_enqueue_scripts', 'module09_enqueue_styles', 30);
