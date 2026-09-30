<?php
/**
 * Module 18: Like/Bỏ Like bài viết bằng WordPress AJAX.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'module18_normalize_user_ids' ) ) {
	/**
	 * Chuẩn hóa danh sách ID người dùng được lưu trong post meta.
	 *
	 * @param mixed $value Giá trị post meta cần chuẩn hóa.
	 * @return int[]
	 */
	function module18_normalize_user_ids( $value ) {
		if ( ! is_array( $value ) ) {
			return array();
		}

		$user_ids = array_map( 'absint', $value );
		$user_ids = array_filter( $user_ids );
		$user_ids = array_unique( $user_ids, SORT_NUMERIC );

		return array_values( $user_ids );
	}
}

if ( ! function_exists( 'module18_get_liked_users' ) ) {
	/**
	 * Lấy danh sách ID đã Like một bài viết.
	 *
	 * @param int $post_id ID bài viết.
	 * @return int[]
	 */
	function module18_get_liked_users( $post_id ) {
		$liked_users = get_post_meta( absint( $post_id ), '_nhom_a_module18_liked_users', true );

		return module18_normalize_user_ids( $liked_users );
	}
}

if ( ! function_exists( 'module18_get_like_count_text' ) ) {
	/**
	 * Tạo chuỗi hiển thị tổng lượt thích.
	 *
	 * @param int $count Tổng lượt thích.
	 * @return string
	 */
	function module18_get_like_count_text( $count ) {
		$count = absint( $count );

		return sprintf(
			/* translators: %s: number of likes. */
			_n( '%s lượt thích', '%s lượt thích', $count, 'nhom-a-twentytwenty-child' ),
			number_format_i18n( $count )
		);
	}
}

if ( ! function_exists( 'module18_get_like_button_html' ) ) {
	/**
	 * Render nút Like cho một bài viết.
	 *
	 * @param int $post_id ID bài viết.
	 * @return string
	 */
	function module18_get_like_button_html( $post_id ) {
		$post_id  = absint( $post_id );
		$template = get_stylesheet_directory() . '/modules/module-18/templates/like-button.php';

		if ( ! $post_id || 'post' !== get_post_type( $post_id ) || ! is_readable( $template ) ) {
			return '';
		}

		$module18_post_id      = $post_id;
		$module18_liked_users  = module18_get_liked_users( $post_id );
		$module18_like_count   = count( $module18_liked_users );
		$module18_current_user = absint( get_current_user_id() );
		$module18_is_liked     = $module18_current_user > 0 && in_array( $module18_current_user, $module18_liked_users, true );
		$module18_login_url    = wp_login_url( get_permalink( $post_id ) );

		ob_start();
		require $template;

		return (string) ob_get_clean();
	}
}

if ( ! function_exists( 'module18_append_like_button' ) ) {
	/**
	 * Thêm nút Like sau nội dung bài viết trong main loop.
	 *
	 * @param string $content Nội dung bài viết.
	 * @return string
	 */
	function module18_append_like_button( $content ) {
		$is_rest_request = defined( 'REST_REQUEST' ) && REST_REQUEST;
		$is_json_request = function_exists( 'wp_is_json_request' ) && wp_is_json_request();
		$is_ajax_request = function_exists( 'wp_doing_ajax' ) && wp_doing_ajax();

		if (
			is_admin()
			|| $is_rest_request
			|| $is_json_request
			|| $is_ajax_request
			|| ! is_singular( 'post' )
			|| ! in_the_loop()
			|| ! is_main_query()
		) {
			return $content;
		}

		$post_id = absint( get_the_ID() );

		if ( ! $post_id || 'post' !== get_post_type( $post_id ) ) {
			return $content;
		}

		return $content . module18_get_like_button_html( $post_id );
	}
}

if ( ! has_filter( 'the_content', 'module18_append_like_button' ) ) {
	add_filter( 'the_content', 'module18_append_like_button', 20 );
}

if ( ! function_exists( 'module18_enqueue_assets' ) ) {
	/** Nạp CSS, JavaScript và dữ liệu AJAX chỉ trên trang chi tiết bài viết. */
	function module18_enqueue_assets() {
		if ( is_admin() || ! is_singular( 'post' ) ) {
			return;
		}

		$css_path = get_stylesheet_directory() . '/modules/module-18/assets/css/like-button.css';
		$js_path  = get_stylesheet_directory() . '/modules/module-18/assets/js/like-button.js';
		$css_ver  = is_readable( $css_path ) ? (string) filemtime( $css_path ) : '1.0.0';
		$js_ver   = is_readable( $js_path ) ? (string) filemtime( $js_path ) : '1.0.0';
		$post_id  = absint( get_queried_object_id() );

		wp_enqueue_style(
			'module18-like-button',
			get_stylesheet_directory_uri() . '/modules/module-18/assets/css/like-button.css',
			array( 'nhom-a-twentytwenty-child' ),
			$css_ver
		);

		wp_enqueue_script(
			'module18-like-button',
			get_stylesheet_directory_uri() . '/modules/module-18/assets/js/like-button.js',
			array(),
			$js_ver,
			true
		);

		wp_localize_script(
			'module18-like-button',
			'module18Like',
			array(
				'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
				'action'   => 'module18_toggle_like',
				'nonce'    => wp_create_nonce( 'module18_toggle_like' ),
				'loginUrl' => wp_login_url( get_permalink( $post_id ) ),
				'messages' => array(
					'requestFailed'  => esc_html__( 'Không thể cập nhật lượt thích. Vui lòng thử lại.', 'nhom-a-twentytwenty-child' ),
					'invalidResponse' => esc_html__( 'Phản hồi không hợp lệ. Vui lòng thử lại.', 'nhom-a-twentytwenty-child' ),
					'loginRequired'  => esc_html__( 'Bạn cần đăng nhập để thích bài viết.', 'nhom-a-twentytwenty-child' ),
					'loginAction'    => esc_html__( 'Đăng nhập', 'nhom-a-twentytwenty-child' ),
				),
			)
		);
	}
}

if ( ! has_action( 'wp_enqueue_scripts', 'module18_enqueue_assets' ) ) {
	add_action( 'wp_enqueue_scripts', 'module18_enqueue_assets', 40 );
}

if ( ! function_exists( 'module18_toggle_like' ) ) {
	/** Xử lý Like/Bỏ Like bằng WordPress AJAX. */
	function module18_toggle_like() {
		if ( false === check_ajax_referer( 'module18_toggle_like', 'nonce', false ) ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Phiên làm việc đã hết hạn. Vui lòng tải lại trang.', 'nhom-a-twentytwenty-child' ) ),
				403
			);
		}

		$post_id = isset( $_POST['post_id'] ) ? absint( wp_unslash( $_POST['post_id'] ) ) : 0;
		$post    = $post_id ? get_post( $post_id ) : null;

		if ( ! $post instanceof WP_Post || 'post' !== $post->post_type ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Bài viết không hợp lệ.', 'nhom-a-twentytwenty-child' ) ),
				400
			);
		}

		if ( ! is_user_logged_in() ) {
			wp_send_json_error(
				array(
					'message'       => esc_html__( 'Bạn cần đăng nhập để thích bài viết.', 'nhom-a-twentytwenty-child' ),
					'loginRequired' => true,
					'loginUrl'      => wp_login_url( get_permalink( $post_id ) ),
				),
				401
			);
		}

		if ( ! current_user_can( 'read_post', $post_id ) ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Bạn không có quyền đọc bài viết này.', 'nhom-a-twentytwenty-child' ) ),
				403
			);
		}

		$user_id     = absint( get_current_user_id() );
		$liked_users = module18_get_liked_users( $post_id );
		$is_liked    = in_array( $user_id, $liked_users, true );

		if ( $is_liked ) {
			$liked_users = array_diff( $liked_users, array( $user_id ) );
			$is_liked    = false;
		} else {
			$liked_users[] = $user_id;
			$is_liked      = true;
		}

		$liked_users = module18_normalize_user_ids( $liked_users );
		$updated     = update_post_meta( $post_id, '_nhom_a_module18_liked_users', $liked_users );

		if ( false === $updated ) {
			wp_send_json_error(
				array( 'message' => esc_html__( 'Không thể lưu lượt thích. Vui lòng thử lại.', 'nhom-a-twentytwenty-child' ) ),
				500
			);
		}

		$like_count = count( $liked_users );

		wp_send_json_success(
			array(
				'liked'     => $is_liked,
				'count'     => $like_count,
				'countText' => module18_get_like_count_text( $like_count ),
				'label'     => $is_liked
					? esc_html__( 'Đã thích', 'nhom-a-twentytwenty-child' )
					: esc_html__( 'Thích', 'nhom-a-twentytwenty-child' ),
				'message'   => $is_liked
					? esc_html__( 'Đã thích bài viết.', 'nhom-a-twentytwenty-child' )
					: esc_html__( 'Đã bỏ thích bài viết.', 'nhom-a-twentytwenty-child' ),
			)
		);
	}
}

if ( ! has_action( 'wp_ajax_module18_toggle_like', 'module18_toggle_like' ) ) {
	add_action( 'wp_ajax_module18_toggle_like', 'module18_toggle_like' );
}

if ( ! has_action( 'wp_ajax_nopriv_module18_toggle_like', 'module18_toggle_like' ) ) {
	add_action( 'wp_ajax_nopriv_module18_toggle_like', 'module18_toggle_like' );
}
