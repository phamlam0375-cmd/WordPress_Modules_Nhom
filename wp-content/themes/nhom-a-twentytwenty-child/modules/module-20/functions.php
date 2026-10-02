<?php

/**
 * Module 20 (tự chọn): Breadcrumb
 * Hiển thị trên đầu trang chi tiết, trước hàng 3 cột (hook nhom_a_single_before_content).
 */

if (! defined('ABSPATH')) {
	exit;
}

if (! function_exists('module20_render_breadcrumb')) {
	/** In đường dẫn Trang chủ › Chuyên mục › Bài viết. */
	function module20_render_breadcrumb()
	{
		include __DIR__ . '/breadcrumb.php';
	}
}
add_action('nhom_a_single_before_content', 'module20_render_breadcrumb');

if (! function_exists('module20_enqueue_styles')) {
	/** Nạp CSS của module trên trang chi tiết bài viết. */
	function module20_enqueue_styles()
	{
		if (! is_singular('post')) {
			return;
		}

		$css_path = __DIR__ . '/style.css';

		wp_enqueue_style(
			'module20-breadcrumb',
			get_stylesheet_directory_uri() . '/modules/module-20/style.css',
			array('gcn-search-detail'),
			is_readable($css_path) ? (string) filemtime($css_path) : '1.0.0'
		);
	}
}
add_action('wp_enqueue_scripts', 'module20_enqueue_styles', 30);
