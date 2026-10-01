<?php

/**
 * Module 15: Last posts
 * Hiển thị bên dưới kết quả tìm kiếm (hook nhom_a_search_after_columns).
 */

if (! defined('ABSPATH')) {
	exit;
}

if (! function_exists('module15_render_last_posts')) {
	/** In timeline bài viết mới nhất. */
	function module15_render_last_posts()
	{
		include __DIR__ . '/last-posts.php';
	}
}
add_action('nhom_a_search_after_columns', 'module15_render_last_posts', 10);

if (! function_exists('module15_enqueue_styles')) {
	/** Nạp CSS của module trên trang tìm kiếm. */
	function module15_enqueue_styles()
	{
		if (! is_search()) {
			return;
		}

		$css_path = __DIR__ . '/style.css';

		wp_enqueue_style(
			'module15-last-posts',
			get_stylesheet_directory_uri() . '/modules/module-15/style.css',
			array('gcn-search-detail'),
			is_readable($css_path) ? (string) filemtime($css_path) : '1.0.0'
		);
	}
}
add_action('wp_enqueue_scripts', 'module15_enqueue_styles', 30);
