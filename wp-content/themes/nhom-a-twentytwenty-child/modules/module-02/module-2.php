<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Lấy 10 bài viết đã xuất bản mới nhất.
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
                <?php $module02_image_url = nhom_a_module02_post_image_url( get_the_ID() ); ?>
                <article class="news-item">
                    <a class="module02-post-image-link" href="<?php echo esc_url( get_permalink() ); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
                        <?php if ( $module02_image_url ) : ?>
                            <img class="module02-post-image" src="<?php echo esc_url( $module02_image_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" decoding="async">
                        <?php else : ?>
                            <span class="module02-image-placeholder"><?php esc_html_e( 'Chưa có ảnh', 'nhom-a-twentytwenty-child' ); ?></span>
                        <?php endif; ?>
                    </a>
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
