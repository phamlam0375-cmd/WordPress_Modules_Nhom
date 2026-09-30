<?php
/**
 * Module 17: Tác giả bài viết (Author Box)
 */

// Nhúng file CSS của module-17
wp_enqueue_style(
    'module-17-css', 
    get_stylesheet_directory_uri() . '/modules/module-17/author-box.css',
    array(),
    '1.0.0'
);

// Lấy ID tác giả của bài viết hiện tại
$author_id = get_the_author_meta('ID');
$author_name = get_the_author_meta('display_name');
$author_bio = get_the_author_meta('description');
$author_posts_url = get_author_posts_url($author_id);
$author_post_count = count_user_posts($author_id);
?>

<div class="module-author-box">
    <div class="author-avatar">
        <a href="<?php echo esc_url($author_posts_url); ?>">
            <?php echo get_avatar($author_id, 90); ?>
        </a>
    </div>
    
    <div class="author-info">
        <span class="author-label">TÁC GIẢ BÀI VIẾT</span>
        <h4 class="author-name">
            <a href="<?php echo esc_url($author_posts_url); ?>">
                <?php echo esc_html($author_name); ?>
            </a>
        </h4>
        
        <p class="author-bio">
            <?php 
            if (!empty($author_bio)) {
                echo esc_html($author_bio);
            } else {
                echo 'Tác giả chưa cập nhật tiểu sử. Chúc bạn đọc bài viết vui vẻ!';
            }
            ?>
        </p>

        <div class="author-meta">
            <span class="post-count">
                Đã đăng: <strong><?php echo $author_post_count; ?></strong> bài viết
            </span>
            <a href="<?php echo esc_url($author_posts_url); ?>" class="view-more-posts">
                Xem tất cả bài viết »
            </a>
        </div>
    </div>
</div>