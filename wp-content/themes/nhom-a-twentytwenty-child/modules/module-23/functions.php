<?php

/**
 * Module 23 (tự chọn): Tags - Đám mây thẻ
 * Hiển thị dưới Module 15 trên trang tìm kiếm (hook nhom_a_search_after_columns, ưu tiên 20).
 */

if (! defined('ABSPATH')) {
	exit;
}

if (! function_exists('module23_render_tags')) {
	/** In đám mây thẻ. */
	function module23_render_tags()
	{
		include __DIR__ . '/tags.php';
	}
}
add_action('nhom_a_search_after_columns', 'module23_render_tags', 20);

if (! function_exists('module23_enqueue_styles')) {
	/** Nạp CSS của module trên trang tìm kiếm. */
	function module23_enqueue_styles()
	{
		if (! is_search()) {
			return;
		}

		$css_path = __DIR__ . '/style.css';

		wp_enqueue_style(
			'module23-tags',
			get_stylesheet_directory_uri() . '/modules/module-23/style.css',
			array('gcn-search-detail'),
			is_readable($css_path) ? (string) filemtime($css_path) : '1.0.0'
		);
	}
}
add_action('wp_enqueue_scripts', 'module23_enqueue_styles', 30);
