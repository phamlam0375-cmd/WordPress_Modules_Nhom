<?php
// Nhúng file CSS của module-12
wp_enqueue_style( 
    'module-12-css', 
    get_stylesheet_directory_uri() . '/modules/module-12/comments.css',
    array(),
    '1.0.0'
);
?>

<div class="module-12-container">
    <h3 class="module-12-title">Comments</h3>
    
    <?php if ( is_active_sidebar( 'module-12-comments' ) ) : ?>
        <?php dynamic_sidebar( 'module-12-comments' ); ?>
    <?php else : ?>
        <!-- Tự động lấy danh sách bình luận mới nhất từ Database -->
        <ul class="module-12-list">
            <?php
            $comments = get_comments( array(
                'number' => 5,
                'status' => 'approve'
            ) );

            if ( ! empty( $comments ) ) :
                foreach ( $comments as $comment ) : ?>
                    <li>
                        <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                            <?php echo esc_html( wp_trim_words( $comment->comment_content, 6, '...' ) ); ?>
                        </a>
                    </li>
                <?php endforeach;
            else : ?>
                <li><a href="#">Bài viết hay quá</a></li>
                <li><a href="#">Cảm ơn tác giả</a></li>
                <li><a href="#">Bài viết thật hữu ích</a></li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>
</div>