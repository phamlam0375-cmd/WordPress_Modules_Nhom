<?php
if (! defined('ABSPATH')) {
    exit;
}

class GCN_Widget_Test_4 extends WP_Widget
{

    /**
     * Constructor — khai báo tên, mô tả widget.
     */
    public function __construct()
    {
        parent::__construct(
            'widget_test_4',                     // ID widget (bắt buộc đúng tên).
            'Widget Test 4 (GCN)',               // Tên hiển thị trong admin.
            array(
                'description' => 'Hiển thị danh sách bài viết dạng card ngang — ảnh trái, tiêu đề + meta + mô tả bên phải.',
                'classname'   => 'gcn-widget-test-4',
            )
        );
    }

    /**
     * Form cấu hình widget trong admin.
     */
    public function form($instance)
    {
        $title        = isset($instance['title'])        ? $instance['title']        : 'Tin tức mới';
        $number       = isset($instance['number'])       ? (int) $instance['number'] : 4;
        $category     = isset($instance['category'])     ? (int) $instance['category'] : 0;
?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                Tiêu đề widget:
            </label>
            <input class="widefat"
                id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                type="text"
                value="<?php echo esc_attr($title); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>">
                Số bài viết hiển thị:
            </label>
            <input class="tiny-text"
                id="<?php echo esc_attr($this->get_field_id('number')); ?>"
                name="<?php echo esc_attr($this->get_field_name('number')); ?>"
                type="number"
                min="1"
                max="20"
                value="<?php echo esc_attr($number); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('category')); ?>">
                Chuyên mục (để trống = tất cả):
            </label>
            <?php
            wp_dropdown_categories(array(
                'id'               => $this->get_field_id('category'),
                'name'             => $this->get_field_name('category'),
                'selected'         => $category,
                'show_option_none' => '-- Tất cả --',
                'option_none_value' => 0,
                'class'            => 'widefat',
            ));
            ?>
        </p>
    <?php
    }

    /**
     * Lưu cấu hình khi bấm Save.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();

        $instance['title']    = sanitize_text_field($new_instance['title'] ?? '');
        $instance['number']   = absint($new_instance['number'] ?? 4);
        $instance['category'] = absint($new_instance['category'] ?? 0);

        if ($instance['number'] < 1) {
            $instance['number'] = 4;
        }
        if ($instance['number'] > 20) {
            $instance['number'] = 20;
        }

        return $instance;
    }

    /**
     * Hiển thị widget ra frontend.
     */
    public function widget($args, $instance)
    {
        $title    = isset($instance['title'])    ? $instance['title']    : 'Tin tức mới';
        $number   = isset($instance['number'])   ? (int) $instance['number'] : 4;
        $category = isset($instance['category']) ? (int) $instance['category'] : 0;

        // Query bài viết.
        $query_args = array(
            'post_type'              => 'post',
            'posts_per_page'         => $number,
            'orderby'                => 'date',
            'order'                  => 'DESC',
            'ignore_sticky_posts'    => true,
            'no_found_rows'          => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        );

        if ($category > 0) {
            $query_args['cat'] = $category;
        }

        $posts_query = new WP_Query($query_args);

        if (! $posts_query->have_posts()) {
            return;
        }

        // Output bắt đầu.
        echo $args['before_widget'];

        // Tiêu đề widget.
        if (! empty($title)) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }
    ?>

        <div class="gcn-widget-test-4-list">
            <?php
            while ($posts_query->have_posts()) :
                $posts_query->the_post();
            ?>
                <article class="gcn-w4-item">

                    <a class="gcn-w4-thumb" href="<?php echo esc_url(get_permalink()); ?>" aria-label="Xem bài: <?php echo esc_attr(get_the_title()); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium', array('loading' => 'lazy')); ?>
                        <?php else : ?>
                            <span class="gcn-w4-thumb-placeholder">Góc Công Nghệ</span>
                        <?php endif; ?>
                    </a>

                    <div class="gcn-w4-content">

                        <h3 class="gcn-w4-title">
                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                <?php echo esc_html(get_the_title()); ?>
                            </a>
                        </h3>

                        <div class="gcn-w4-meta">
                            <?php
                            // Lấy category đầu tiên làm "nguồn".
                            $cats = get_the_category();
                            if (! empty($cats)) :
                                $first_cat = $cats[0];
                            ?>
                                <a class="gcn-w4-source" href="<?php echo esc_url(get_category_link($first_cat->term_id)); ?>">
                                    <span class="gcn-w4-source-dot" aria-hidden="true"></span>
                                    <span class="gcn-w4-source-name"><?php echo esc_html($first_cat->name); ?></span>
                                </a>
                            <?php endif; ?>

                            <span class="gcn-w4-time">
                                <?php echo esc_html(human_time_diff(get_the_time('U'), current_time('timestamp'))); ?> trước
                            </span>

                            <?php
                            $comment_count = (int) get_comments_number();
                            if ($comment_count > 0) :
                            ?>
                                <span class="gcn-w4-comments"><?php echo esc_html($comment_count); ?> bình luận</span>
                            <?php else : ?>
                                <span class="gcn-w4-comments">0 bình luận</span>
                            <?php endif; ?>
                        </div>

                        <p class="gcn-w4-excerpt">
                            <?php echo esc_html(wp_trim_words(wp_strip_all_tags(get_the_excerpt()), 24, '…')); ?>
                        </p>

                    </div>

                </article>
            <?php endwhile; ?>
        </div>

<?php
        // Output kết thúc.
        echo $args['after_widget'];

        wp_reset_postdata();
    }
}
