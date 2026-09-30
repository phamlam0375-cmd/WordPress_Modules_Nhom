<?php
// Nhúng file CSS của module 02
wp_enqueue_style('module-02-css', get_stylesheet_directory_uri() . '/modules/module-02/module-2.css');

// Lấy danh sách bài viết mới nhất (mặc định 3 bài)
$args = array(
    'post_type'      => 'post',
    'posts_per_page' => 10,
    'post_status'    => 'publish',
);

$query = new WP_Query($args);
?>

<div class="module-02-container">
    <?php if ($query->have_posts()) : ?>
        <div class="news-list">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <article class="news-item">
                    <div class="news-date">
                        <span class="day"><?php echo get_the_date('d'); ?></span>
                        <span class="month">THÁNG <?php echo get_the_date('m'); ?></span>
                    </div>
                    <div class="news-content">
                        <h3 class="news-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="news-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 25, '[...]'); ?>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <p>Không có bài viết nào.</p>
    <?php endif; ?>
</div>