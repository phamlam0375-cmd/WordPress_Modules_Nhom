<?php
/**
 * Chức năng hỗ trợ trang tìm kiếm bài viết.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gcn_twentytwenty_search_posts_only' ) ) {
	/** Chỉ tìm bài viết, không đưa các trang tĩnh vào danh sách kết quả. */
	function gcn_twentytwenty_search_posts_only( $query ) {
		if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
			$query->set( 'post_type', 'post' );
		}
	}
}

if ( ! has_action( 'pre_get_posts', 'gcn_twentytwenty_search_posts_only' ) ) {
	add_action( 'pre_get_posts', 'gcn_twentytwenty_search_posts_only' );
}
