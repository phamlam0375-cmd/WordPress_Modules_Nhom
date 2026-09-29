<?php
/**
 * Trang hiển thị bài viết với Module 02
 */

get_header(); // Gọi header của theme
?>

<main id="site-content" role="main">
    <div class="section-inner">
        <?php 
        // Gọi module 02 từ thư mục modules
        include(get_stylesheet_directory() . '/modules/module-02/module-2.php'); 
        ?>
    </div>
</main>

<?php 
get_footer(); // Gọi footer của theme