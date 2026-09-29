<?php
/**
 * Trang hiển thị sơ đồ 3 cột: Module 11 - Module 02 - Module 12
 */

get_header(); // Gọi header (Module 01)
?>

<main id="site-content" role="main">
    <div class="section-inner main-layout-flex">
        
        <!-- Cột trái: Module 11 (Archive) -->
        <aside class="sidebar-left">
            <?php 
            $module_11_path = get_stylesheet_directory() . '/modules/module-11/archive.php';
            if ( file_exists( $module_11_path ) ) {
                include $module_11_path;
            }
            ?>
        </aside>

        <!-- Cột giữa: Module 02 (Content) -->
        <div class="main-content-area">
            <?php 
            $module_02_path = get_stylesheet_directory() . '/modules/module-02/module-2.php';
            if ( file_exists( $module_02_path ) ) {
                include $module_02_path;
            }
            ?>
        </div>

        <!-- Cột phải: Module 12 (Comments) -->
        <aside class="sidebar-right">
            <?php 
            $module_12_path = get_stylesheet_directory() . '/modules/module-12/comments.php';
            if ( file_exists( $module_12_path ) ) {
                include $module_12_path;
            }
            ?>
        </aside>

    </div>
</main>

<?php 
get_footer(); // Gọi footer (Module 03)