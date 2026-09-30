<?php
/**
 * Module 13: Danh sách Trang dạng card responsive.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'nhom_a_module13_add_page_excerpt_support' ) ) {
	/** Bổ sung trường excerpt cho post type Page. */
	function nhom_a_module13_add_page_excerpt_support() {
		add_post_type_support( 'page', 'excerpt' );
	}
}

if ( ! has_action( 'init', 'nhom_a_module13_add_page_excerpt_support' ) ) {
	add_action( 'init', 'nhom_a_module13_add_page_excerpt_support' );
}

if ( ! function_exists( 'nhom_a_module13_add_thumbnail_support' ) ) {
	/** Bảo đảm child theme hỗ trợ ảnh đại diện. */
	function nhom_a_module13_add_thumbnail_support() {
		if ( ! current_theme_supports( 'post-thumbnails' ) ) {
			add_theme_support( 'post-thumbnails' );
		}
}
}

if ( ! has_action( 'after_setup_theme', 'nhom_a_module13_add_thumbnail_support' ) ) {
	add_action( 'after_setup_theme', 'nhom_a_module13_add_thumbnail_support', 20 );
}

if ( ! function_exists( 'nhom_a_module13_sanitize_limit' ) ) {
	/**
	 * Giới hạn số Trang trong khoảng 1–12.
	 *
	 * @param mixed $limit Giá trị cần chuẩn hóa.
	 * @return int
	 */
	function nhom_a_module13_sanitize_limit( $limit ) {
		$limit = absint( $limit );

		if ( $limit < 1 ) {
			return 1;
		}

		return min( 12, $limit );
	}
}

if ( ! function_exists( 'nhom_a_module13_render_pages_cards' ) ) {
	/**
	 * Render danh sách Trang dùng chung cho shortcode và widget.
	 *
	 * @param array $settings Thiết lập title và limit.
	 * @return string
	 */
	function nhom_a_module13_render_pages_cards( $settings = array() ) {
		static $render_instance = 0;

		$settings = wp_parse_args(
			$settings,
			array(
				'title' => esc_html__( 'Pages', 'nhom-a-twentytwenty-child' ),
				'limit' => 3,
			)
		);

		$title    = sanitize_text_field( $settings['title'] );
		$limit    = nhom_a_module13_sanitize_limit( $settings['limit'] );
		$template = get_stylesheet_directory() . '/modules/module-13/templates/pages-grid.php';

		if ( ! is_readable( $template ) ) {
			return '';
		}

		$query_args = array(
			'post_type'           => 'page',
			'post_status'         => 'publish',
			'posts_per_page'      => $limit,
			'orderby'             => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
			'order'               => 'ASC',
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		);

		if ( is_singular( 'page' ) ) {
			$current_page_id = absint( get_queried_object_id() );

			if ( $current_page_id > 0 ) {
				$query_args['post__not_in'] = array( $current_page_id );
			}
		}

		$module13_query      = new WP_Query( $query_args );
		$render_instance++;
		$module13_title      = $title;
		$module13_heading_id = 'module13-pages-title-' . $render_instance;

		ob_start();
		require $template;
		$output = (string) ob_get_clean();

		wp_reset_postdata();

		return $output;
	}
}

if ( ! function_exists( 'nhom_a_module13_pages_shortcode' ) ) {
	/**
	 * Shortcode [module13_pages].
	 *
	 * @param array $attributes Thuộc tính shortcode.
	 * @return string
	 */
	function nhom_a_module13_pages_shortcode( $attributes ) {
		$attributes = shortcode_atts(
			array(
				'limit' => 3,
				'title' => esc_html__( 'Pages', 'nhom-a-twentytwenty-child' ),
			),
			$attributes,
			'module13_pages'
		);

		return nhom_a_module13_render_pages_cards(
			array(
				'limit' => nhom_a_module13_sanitize_limit( $attributes['limit'] ),
				'title' => sanitize_text_field( $attributes['title'] ),
			)
		);
	}
}

add_shortcode( 'module13_pages', 'nhom_a_module13_pages_shortcode' );

if ( ! function_exists( 'nhom_a_module13_enqueue_assets' ) ) {
	/** Nạp stylesheet của module ở giao diện người dùng. */
	function nhom_a_module13_enqueue_assets() {
		if ( is_admin() ) {
			return;
		}

		$css_path = get_stylesheet_directory() . '/modules/module-13/assets/css/pages-grid.css';
		$version  = is_readable( $css_path ) ? (string) filemtime( $css_path ) : '1.0.0';

		wp_enqueue_style(
			'nhom-a-module13-pages-grid',
			get_stylesheet_directory_uri() . '/modules/module-13/assets/css/pages-grid.css',
			array( 'nhom-a-twentytwenty-child' ),
			$version
		);
	}
}

if ( ! has_action( 'wp_enqueue_scripts', 'nhom_a_module13_enqueue_assets' ) ) {
	add_action( 'wp_enqueue_scripts', 'nhom_a_module13_enqueue_assets', 35 );
}

if ( ! function_exists( 'nhom_a_module13_register_widget' ) ) {
	/** Nạp và đăng ký custom widget của Module 13. */
	function nhom_a_module13_register_widget() {
		$widget_file = get_stylesheet_directory() . '/modules/module-13/includes/class-module13-pages-widget.php';

		if ( is_readable( $widget_file ) ) {
			require_once $widget_file;
		}

		if ( class_exists( 'Nhom_A_Module13_Pages_Widget' ) ) {
			register_widget( 'Nhom_A_Module13_Pages_Widget' );
		}
	}
}

if ( ! has_action( 'widgets_init', 'nhom_a_module13_register_widget' ) ) {
	add_action( 'widgets_init', 'nhom_a_module13_register_widget', 20 );
}
