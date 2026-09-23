<?php
get_header();
?>

<main id="site-content" class="gcn-archive" role="main">
    <div class="gcn-wrap">

        <header class="gcn-archive-header">
            <h1><?php the_archive_title(); ?></h1>
            <?php the_archive_description('<div class="gcn-archive-desc">', '</div>'); ?>
        </header>

        <?php
        // ⬇️ KHỐI "XEM NHIỀU" — hiển thị phía trên danh sách chính.
        get_template_part('template-parts/popular-posts');
        ?>

        <?php if (have_posts()) : ?>

            <div class="gcn-post-list">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/item-list'); ?>
                <?php endwhile; ?>
            </div>

            <?php
            the_posts_pagination(array(
                'prev_text' => '← Trang trước',
                'next_text' => 'Trang sau →',
            ));
            ?>

        <?php else : ?>
            <p class="gcn-no-results">Chưa có bài viết nào trong chuyên mục này.</p>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>