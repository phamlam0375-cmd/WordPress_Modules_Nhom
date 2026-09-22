<?php

/**
 * Giữ giao diện và footer của Twenty Twenty, chỉ bổ sung hai trang bài tập.
 */

if (! defined('ABSPATH')) {
	exit;
}

function gcn_twentytwenty_enqueue_styles()
{
	// Twenty Twenty có thể tải style.css của theme đang hoạt động.
	// Tải rõ stylesheet của theme gốc để giao diện con luôn giữ thiết kế 2020.
	wp_enqueue_style(
		'gcn-twentytwenty-parent',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme('twentytwenty')->get('Version')
	);

	wp_enqueue_style(
		'gcn-search-detail',
		get_stylesheet_directory_uri() . '/assets/css/layout.css',
		array('gcn-twentytwenty-parent'),
		'1.0.0'
	);
	wp_enqueue_style(
		'gcn-post-list',
		get_stylesheet_directory_uri() . '/assets/css/post-list.css',
		array('gcn-search-detail'),
		'1.0.0'
	);
}
add_action('wp_enqueue_scripts', 'gcn_twentytwenty_enqueue_styles', 20);

/** Chỉ tìm bài viết, không đưa các trang tĩnh vào danh sách kết quả. */
function gcn_twentytwenty_search_posts_only($query)
{
	if (! is_admin() && $query->is_main_query() && $query->is_search()) {
		$query->set('post_type', 'post');
	}
}
add_action('pre_get_posts', 'gcn_twentytwenty_search_posts_only');
