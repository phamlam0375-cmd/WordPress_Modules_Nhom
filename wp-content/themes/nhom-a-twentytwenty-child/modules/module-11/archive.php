<?php

/**
 * Module 11: Archive (Xem nhiều)
 * Hiển thị 8 bài viết mới nhất - dạng 2 cột, có số thứ tự.
 */

if (! defined('ABSPATH')) {
    exit;
}

$archive_query = new WP_Query(array(
    'post_type'           => 'post',
    'posts_per_page'      => 8,
    'orderby'             => 'date',
    'order'               => 'DESC',
    'ignore_sticky_posts' => 1,
));

if (! $archive_query->have_posts()) {
    return;
}
?>
<div class="gcn-module-11-archive">
    <h3 class="gcn-archive-title">Xem nhiều</h3>

    <div class="gcn-archive-grid">
        <?php
        $post_index = 1;
        while ($archive_query->have_posts()) :
            $archive_query->the_post();
        ?>
            <div class="gcn-archive-item">
                <span class="gcn-archive-number"><?php echo esc_html($post_index); ?></span>
                <a href="<?php the_permalink(); ?>" class="gcn-archive-link">
                    <?php the_title(); ?>
                </a>
            </div>
        <?php
            $post_index++;
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
</div>