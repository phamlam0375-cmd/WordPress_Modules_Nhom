<?php

/**
 * Module 16: Social Share
 * Chia sẻ bài viết lên Facebook, Zalo, Twitter/X, LinkedIn, Telegram, Pinterest, Email, Copy Link
 */

if (! defined('ABSPATH')) {
    exit;
}

if (! function_exists('gcn_render_module_16_social_share')) {
    function gcn_render_module_16_social_share()
    {
        // Chỉ hiển thị ở trang chi tiết bài viết
        if (! is_singular('post')) {
            return;
        }

        $post_id    = get_the_ID();
        $post_url   = get_permalink($post_id);
        $post_title = get_the_title($post_id);
        $post_thumb = get_the_post_thumbnail_url($post_id, 'large');

        // Nếu không có ảnh đại diện thì dùng ảnh mặc định
        if (! $post_thumb) {
            $post_thumb = get_stylesheet_directory_uri() . '/assets/images/default-share.jpg';
        }

        // Encode dữ liệu để chèn vào URL
        $url_encoded   = rawurlencode($post_url);
        $title_encoded = rawurlencode($post_title);
        $thumb_encoded = rawurlencode($post_thumb);

        // Danh sách các kênh chia sẻ
        $share_links = array(
            'facebook' => array(
                'label' => 'Facebook',
                'url'   => 'https://www.facebook.com/sharer/sharer.php?u=' . $url_encoded,
                'color' => '#1877f2',
                'icon'  => 'fab fa-facebook-f',
            ),
            'zalo' => array(
                'label' => 'Zalo',
                'url'   => 'https://zalo.me/share?u=' . $url_encoded . '&t=' . $title_encoded,
                'color' => '#0068ff',
                'icon'  => 'fas fa-comment-dots',
            ),
            'twitter' => array(
                'label' => 'Twitter',
                'url'   => 'https://twitter.com/intent/tweet?url=' . $url_encoded . '&text=' . $title_encoded,
                'color' => '#000000',
                'icon'  => 'fab fa-x-twitter',
            ),
            'linkedin' => array(
                'label' => 'LinkedIn',
                'url'   => 'https://www.linkedin.com/sharing/share-offsite/?url=' . $url_encoded,
                'color' => '#0a66c2',
                'icon'  => 'fab fa-linkedin-in',
            ),
            'telegram' => array(
                'label' => 'Telegram',
                'url'   => 'https://t.me/share/url?url=' . $url_encoded . '&text=' . $title_encoded,
                'color' => '#229ed9',
                'icon'  => 'fab fa-telegram-plane',
            ),
            'pinterest' => array(
                'label' => 'Pinterest',
                'url'   => 'https://pinterest.com/pin/create/button/?url=' . $url_encoded . '&media=' . $thumb_encoded . '&description=' . $title_encoded,
                'color' => '#e60023',
                'icon'  => 'fab fa-pinterest-p',
            ),
            'email' => array(
                'label' => 'Email',
                'url'   => 'mailto:?subject=' . $title_encoded . '&body=' . $url_encoded,
                'color' => '#666666',
                'icon'  => 'fas fa-envelope',
            ),
        );
?>
        <div class="gcn-module-16-share">
            <h3 class="gcn-share-title">Chia sẻ bài viết</h3>

            <div class="gcn-share-buttons">
                <?php foreach ($share_links as $key => $item) : ?>
                    <a
                        href="<?php echo esc_url($item['url']); ?>"
                        class="gcn-share-btn gcn-share-<?php echo esc_attr($key); ?>"
                        target="_blank"
                        rel="noopener nofollow"
                        title="Chia sẻ lên <?php echo esc_attr($item['label']); ?>"
                        style="--share-color: <?php echo esc_attr($item['color']); ?>;">
                        <i class="<?php echo esc_attr($item['icon']); ?>"></i>
                        <span><?php echo esc_html($item['label']); ?></span>
                    </a>
                <?php endforeach; ?>

                <!-- Nút Copy Link -->
                <button
                    type="button"
                    class="gcn-share-btn gcn-share-copy"
                    data-url="<?php echo esc_url($post_url); ?>"
                    title="Sao chép liên kết"
                    style="--share-color: #4caf50;">
                    <i class="fas fa-link"></i>
                    <span>Copy Link</span>
                </button>
            </div>
        </div>
<?php
    }
}
