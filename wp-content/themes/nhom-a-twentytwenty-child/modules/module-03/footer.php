<?php
// Nhúng Font Awesome Icon
wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');

// Nhúng CSS Module 03
wp_enqueue_style(
    'module-03-css', 
    get_stylesheet_directory_uri() . '/modules/module-03/footer.css', 
    array(), 
    '1.0.0'
);
?>

<footer class="module-03-footer">
    <div class="footer-widgets">
        <!-- CỘT 1: BÌNH LUẬN MỚI -->
        <div class="footer-column">
            <h3 class="widget-title">Bình luận mới</h3>
            <ul class="footer-links">
                <?php
                $comments = get_comments(array('number' => 5, 'status' => 'approve'));
                if (!empty($comments)) :
                    foreach ($comments as $comment) : ?>
                        <li>» <a href="<?php echo get_comment_link($comment->comment_ID); ?>"><?php echo esc_html($comment->comment_author); ?>: <?php echo wp_trim_words($comment->comment_content, 5); ?></a></li>
                    <?php endforeach;
                else : ?>
                    <li>Chưa có bình luận.</li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- CỘT 2: CHUYÊN MỤC -->
        <div class="footer-column">
            <h3 class="widget-title">Chuyên mục</h3>
            <ul class="footer-links">
                <?php
                $categories = get_categories(array('number' => 5, 'orderby' => 'name', 'order' => 'ASC'));
                if (!empty($categories)) :
                    foreach ($categories as $category) : ?>
                        <li>» <a href="<?php echo get_category_link($category->term_id); ?>"><?php echo esc_html($category->name); ?></a></li>
                    <?php endforeach;
                else : ?>
                    <li>Chưa có chuyên mục.</li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- CỘT 3: BÀI VIẾT MỚI -->
        <div class="footer-column">
            <h3 class="widget-title">Bài viết mới</h3>
            <ul class="footer-links">
                <?php
                $recent_posts = wp_get_recent_posts(array('numberposts' => 5, 'post_status' => 'publish'));
                if (!empty($recent_posts)) :
                    foreach ($recent_posts as $post) : ?>
                        <li>» <a href="<?php echo get_permalink($post['ID']); ?>"><?php echo esc_html($post['post_title']); ?></a></li>
                    <?php endforeach;
                    wp_reset_query();
                else : ?>
                    <li>Chưa có bài viết.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- PHẦN SOCIAL & COPYRIGHT -->
    <div class="footer-bottom">
        <div class="social-icons">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-google-plus"></i></a>
            <a href="#"><i class="fa fa-envelope"></i></a>
        </div>
        <p class="copyright-text">
            <u>National Transaction Corporation</u> is a Registered MSP/ISO of Elavon, Inc. Georgia [a wholly owned subsidiary of U.S. Bancorp, Minneapolis, MN]<br>
            © All right Reversed. Sunlimetech
        </p>
    </div>
</footer>

<?php wp_footer(); ?>