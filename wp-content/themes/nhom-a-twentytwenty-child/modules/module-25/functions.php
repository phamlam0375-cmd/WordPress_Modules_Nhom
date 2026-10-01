<?php

/**
 * Module 25 (tự chọn): Thống kê website
 * Hiển thị trên trang chủ, dưới hàng 11 | 02 | 12 (hook nhom_a_home_after_columns).
 */

if (! defined('ABSPATH')) {
	exit;
}

if (! function_exists('module25_render_statistics')) {
	/** In 4 ô số liệu của website. */
	function module25_render_statistics()
	{
		include __DIR__ . '/statistics.php';
	}
}
add_action('nhom_a_home_after_columns', 'module25_render_statistics');

if (! function_exists('module25_enqueue_styles')) {
	/** Nạp CSS của module trên trang chủ. */
	function module25_enqueue_styles()
	{
		if (! is_home() && ! is_front_page()) {
			return;
		}

		$css_path = __DIR__ . '/style.css';

		wp_enqueue_style(
			'module25-statistics',
			get_stylesheet_directory_uri() . '/modules/module-25/style.css',
			array('nhom-a-twentytwenty-child'),
			is_readable($css_path) ? (string) filemtime($css_path) : '1.0.0'
		);
	}
}
add_action('wp_enqueue_scripts', 'module25_enqueue_styles', 30);
