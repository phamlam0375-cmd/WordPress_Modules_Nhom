<?php
/**
 * Custom widget Pages Cards của Module 13.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Nhom_A_Module13_Pages_Widget' ) ) {
	/** Hiển thị danh sách Trang dạng card trong widget area. */
	class Nhom_A_Module13_Pages_Widget extends WP_Widget {
		/** Khởi tạo widget. */
		public function __construct() {
			parent::__construct(
				'nhom_a_module13_pages_widget',
				esc_html__( 'Module 13 – Pages Cards', 'nhom-a-twentytwenty-child' ),
				array(
					'classname'                   => 'module13-pages-widget',
					'description'                 => esc_html__( 'Hiển thị các Trang đã xuất bản dưới dạng card responsive.', 'nhom-a-twentytwenty-child' ),
					'customize_selective_refresh' => true,
				)
			);
		}

		/**
		 * Hiển thị widget ở frontend.
		 *
		 * @param array $args     HTML wrapper của widget area.
		 * @param array $instance Cấu hình widget.
		 */
		public function widget( $args, $instance ) {
			$title = isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : '';
			$limit = isset( $instance['limit'] ) ? nhom_a_module13_sanitize_limit( $instance['limit'] ) : 3;
			$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

			echo wp_kses_post( $args['before_widget'] );
			echo wp_kses_post(
				nhom_a_module13_render_pages_cards(
					array(
						'title' => sanitize_text_field( $title ),
						'limit' => $limit,
					)
				)
			);
			echo wp_kses_post( $args['after_widget'] );
		}

		/**
		 * Hiển thị form cấu hình widget.
		 *
		 * @param array $instance Cấu hình widget hiện tại.
		 */
		public function form( $instance ) {
			$title = isset( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : esc_html__( 'Pages', 'nhom-a-twentytwenty-child' );
			$limit = isset( $instance['limit'] ) ? nhom_a_module13_sanitize_limit( $instance['limit'] ) : 3;
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Tiêu đề:', 'nhom-a-twentytwenty-child' ); ?></label>
				<input
					class="module13-widget-field"
					id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
					type="text"
					value="<?php echo esc_attr( $title ); ?>"
				>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Số lượng Trang (1–12):', 'nhom-a-twentytwenty-child' ); ?></label>
				<input
					class="module13-widget-limit"
					id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"
					max="12"
					min="1"
					name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>"
					step="1"
					type="number"
					value="<?php echo esc_attr( (string) $limit ); ?>"
				>
			</p>
			<?php
		}

		/**
		 * Làm sạch cấu hình trước khi lưu.
		 *
		 * @param array $new_instance Cấu hình mới.
		 * @param array $old_instance Cấu hình cũ.
		 * @return array
		 */
		public function update( $new_instance, $old_instance ) {
			unset( $old_instance );

			return array(
				'title' => isset( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '',
				'limit' => isset( $new_instance['limit'] ) ? nhom_a_module13_sanitize_limit( absint( $new_instance['limit'] ) ) : 3,
			);
		}
	}
}
