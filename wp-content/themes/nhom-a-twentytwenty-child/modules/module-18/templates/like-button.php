<?php
/**
 * Giao diện nút Like của Module 18.
 *
 * Các biến được cung cấp bởi module18_get_like_button_html().
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$module18_count_text = module18_get_like_count_text( $module18_like_count );
$module18_status_id   = 'module18-status-' . absint( $module18_post_id );
$module18_count_id    = 'module18-count-' . absint( $module18_post_id );
?>
<div class="module18-like<?php echo $module18_is_liked ? ' module18-is-liked' : ''; ?>" data-module18-like>
	<div class="module18-like-row">
		<?php if ( is_user_logged_in() ) : ?>
			<button
				type="button"
				class="module18-like-button"
				data-module18-like-button
				data-post-id="<?php echo esc_attr( (string) absint( $module18_post_id ) ); ?>"
				aria-pressed="<?php echo $module18_is_liked ? 'true' : 'false'; ?>"
				aria-describedby="<?php echo esc_attr( $module18_count_id . ' ' . $module18_status_id ); ?>"
			>
				<span class="module18-heart" aria-hidden="true">&#9829;</span>
				<span class="module18-like-label" data-module18-like-label><?php echo esc_html( $module18_is_liked ? 'Đã thích' : 'Thích' ); ?></span>
			</button>
		<?php else : ?>
			<a class="module18-login-link" href="<?php echo esc_url( $module18_login_url ); ?>">
				<span class="module18-heart" aria-hidden="true">&#9829;</span>
				<span><?php esc_html_e( 'Đăng nhập để thích', 'nhom-a-twentytwenty-child' ); ?></span>
			</a>
		<?php endif; ?>

		<span class="module18-separator" aria-hidden="true">&middot;</span>
		<span id="<?php echo esc_attr( $module18_count_id ); ?>" class="module18-like-count" data-module18-like-count><?php echo esc_html( $module18_count_text ); ?></span>
	</div>
	<p id="<?php echo esc_attr( $module18_status_id ); ?>" class="module18-message" data-module18-like-message role="status" aria-live="polite"></p>
</div>
