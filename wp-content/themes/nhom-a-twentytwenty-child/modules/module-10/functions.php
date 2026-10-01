<?php

/**
 * Module 10: Recent post
 * Hiển thị ở cột phải trang chi tiết bài viết (hook nhom_a_single_right_column).
 */

if (! defined('ABSPATH')) {
	exit;
}

if (! function_exists('module10_fraction_date')) {
	/**
	 * Ngày đăng dạng phân số: ngày / tháng + năm (vd: 13/08 23).
	 *
	 * @param int|WP_Post|null $post Bài viết.
	 * @return string HTML đã escape.
	 */
	function module10_fraction_date($post = null)
	{
		return sprintf(
			'<span class="module10-date" aria-label="%4$s"><span class="module10-date__frac"><span class="module10-date__day">%1$s</span><span class="module10-date__month">%2$s</span></span><span class="module10-date__year">%3$s</span></span>',
			esc_html(get_the_date('d', $post)),
			esc_html(get_the_date('m', $post)),
			esc_html(get_the_date('y', $post)),
			esc_attr(get_the_date('d/m/Y', $post))
		);
	}
}

if (! function_exists('module10_all_posts_url')) {
	/** URL trang danh sách tất cả bài viết (nút "Xem tất cả tin tức"). */
	function module10_all_posts_url()
	{
		$page_for_posts = (int) get_option('page_for_posts');

		return $page_for_posts ? get_permalink($page_for_posts) : home_url('/');
	}
}

if (! function_exists('module10_render_recent_posts')) {
	/** In danh sách bài viết mới nhất. */
	function module10_render_recent_posts()
	{
		include __DIR__ . '/recent-post.php';
	}
}
add_action('nhom_a_single_right_column', 'module10_render_recent_posts');

if (! function_exists('module10_enqueue_styles')) {
	/** Nạp CSS của module trên trang chi tiết bài viết. */
	function module10_enqueue_styles()
	{
		if (! is_singular('post')) {
			return;
		}

		$css_path = __DIR__ . '/style.css';

		wp_enqueue_style(
			'module10-recent-post',
			get_stylesheet_directory_uri() . '/modules/module-10/style.css',
			array('gcn-search-detail'),
			is_readable($css_path) ? (string) filemtime($css_path) : '1.0.0'
		);
	}
}
add_action('wp_enqueue_scripts', 'module10_enqueue_styles', 30);
