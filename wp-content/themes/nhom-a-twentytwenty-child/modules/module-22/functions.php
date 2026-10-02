<?php

/**
 * Module 22 (tự chọn): Related posts - Bài viết liên quan
 * Hiển thị trên khung bình luận của trang chi tiết (hook nhom_a_single_before_comments).
 */

if (! defined('ABSPATH')) {
	exit;
}

if (! function_exists('module22_render_related_posts')) {
	/** In 3 bài cùng chuyên mục với bài đang xem. */
	function module22_render_related_posts()
	{
		include __DIR__ . '/related-posts.php';
	}
}
add_action('nhom_a_single_before_comments', 'module22_render_related_posts');

if (! function_exists('module22_enqueue_styles')) {
	/** Nạp CSS của module trên trang chi tiết bài viết. */
	function module22_enqueue_styles()
	{
		if (! is_singular('post')) {
			return;
		}

		$css_path = __DIR__ . '/style.css';

		wp_enqueue_style(
			'module22-related-posts',
			get_stylesheet_directory_uri() . '/modules/module-22/style.css',
			array('gcn-search-detail'),
			is_readable($css_path) ? (string) filemtime($css_path) : '1.0.0'
		);
	}
}
add_action('wp_enqueue_scripts', 'module22_enqueue_styles', 30);
