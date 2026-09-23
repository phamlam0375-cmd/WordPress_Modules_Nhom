<?php
$posts_per_page = 8;

$popular_args = array(
    'post_type'              => 'post',
    'posts_per_page'         => $posts_per_page,
    'orderby'                => 'comment_count',
    'order'                  => 'DESC',
    'ignore_sticky_posts'    => true,
    'no_found_rows'          => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
);

$popular_query = new WP_Query($popular_args);

if (! $popular_query->have_posts()) {
    return;
}

$index = 0;
?>

<section class="gcn-popular" aria-label="Bài viết xem nhiều">

    <h2 class="gcn-popular-title">Xem nhiều</h2>

    <div class="gcn-popular-grid">
        <?php
        while ($popular_query->have_posts()) :
            $popular_query->the_post();
            $index++;

            // Cách 1: Query var (tương thích mọi WP).
            set_query_var('gcn_popular_number', $index);

            // Gọi template part — KHÔNG truyền $args để tránh lỗi WP cũ.
            get_template_part('template-parts/item-popular');
        endwhile;
        ?>
    </div>

</section>

<?php
wp_reset_postdata();
