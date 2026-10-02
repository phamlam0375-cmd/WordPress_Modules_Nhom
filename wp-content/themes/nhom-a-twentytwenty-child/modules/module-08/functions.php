<?php

/**
 * Module 08: Comments Form
 * - Chưa đăng nhập: Form comment truyền thống (Hình 1 - thiết kế lại đẹp hơn)
 * - Đã đăng nhập: Form comment kiểu mạng xã hội (Hình 2)
 */

if (! defined('ABSPATH')) {
    exit;
}

if (! function_exists('gcn_render_module_08_comments')) {
    function gcn_render_module_08_comments()
    {
        if (! comments_open() && get_comments_number() == 0) {
            return;
        }

        $is_logged_in = is_user_logged_in();
        $current_user = wp_get_current_user();
        $post_id      = get_the_ID();
?>
        <div class="gcn-module-08-comments <?php echo $is_logged_in ? 'is-logged-in' : 'is-guest'; ?>">

            <?php if ($is_logged_in) : ?>
                <!-- ===== GIAO DIỆN HÌNH 2: ĐÃ ĐĂNG NHẬP ===== -->
                <div class="gcn-comment-social-box">
                    <div class="gcn-comment-tabs">
                        <span class="gcn-tab-active">Make a Post</span>
                    </div>

                    <!-- Form thật, submit trực tiếp bằng POST -->
                    <form action="<?php echo esc_url(site_url('/wp-comments-post.php')); ?>" method="post" id="gcn-social-comment-form" class="gcn-social-comment-form">

                        <div class="gcn-comment-input-wrapper">
                            <textarea
                                id="gcn-comment-input"
                                name="comment"
                                class="gcn-comment-textarea"
                                placeholder="What are you thinking..."
                                rows="3"
                                required></textarea>
                        </div>

                        <div class="gcn-comment-actions">
                            <button type="submit" class="gcn-btn-share">share</button>
                        </div>

                        <!-- Các trường bắt buộc của WordPress -->
                        <input type="hidden" name="comment_post_ID" value="<?php echo esc_attr($post_id); ?>" />
                        <input type="hidden" name="comment_parent" value="0" />
                        <?php wp_nonce_field('comment_form', 'gcn_comment_nonce'); ?>

                        <!-- Honeypot chống spam (tùy chọn) -->
                        <p style="display:none;">
                            <label>Đừng điền vào đây<input type="text" name="url" value="" /></label>
                        </p>
                    </form>
                </div>

            <?php else : ?>
                <!-- ===== GIAO DIỆN HÌNH 1: CHƯA ĐĂNG NHẬP (THIẾT KẾ LẠI) ===== -->
                <div class="gcn-comment-guest-box">
                    <h3 class="gcn-comment-title">Leave a comment</h3>
                    <p class="gcn-comment-note">
                        Email của bạn sẽ không được công khai. Các trường bắt buộc được đánh dấu <span class="required">*</span>
                    </p>

                    <form action="<?php echo esc_url(site_url('/wp-comments-post.php')); ?>" method="post" id="gcn-guest-comment-form" class="gcn-guest-comment-form">

                        <div class="gcn-form-row">
                            <label for="comment">Bình luận <span class="required">*</span></label>
                            <textarea id="comment" name="comment" rows="6" required placeholder="Nhập bình luận của bạn..."></textarea>
                        </div>

                        <div class="gcn-form-row-inline">
                            <div class="gcn-form-col">
                                <label for="author">Tên <span class="required">*</span></label>
                                <input type="text" id="author" name="author" required placeholder="Tên của bạn" />
                            </div>
                            <div class="gcn-form-col">
                                <label for="email">Email <span class="required">*</span></label>
                                <input type="email" id="email" name="email" required placeholder="email@example.com" />
                            </div>
                        </div>

                        <div class="gcn-form-row">
                            <label for="url">Website</label>
                            <input type="url" id="url" name="url" placeholder="https://..." />
                        </div>

                        <div class="gcn-form-actions">
                            <button type="submit" class="gcn-btn-post-comment">Post Comment</button>
                        </div>

                        <input type="hidden" name="comment_post_ID" value="<?php echo esc_attr($post_id); ?>" />
                        <input type="hidden" name="comment_parent" value="0" />
                        <?php wp_nonce_field('comment_form', 'gcn_comment_nonce'); ?>
                    </form>
                </div>
            <?php endif; ?>

        </div>
<?php
    }
}
