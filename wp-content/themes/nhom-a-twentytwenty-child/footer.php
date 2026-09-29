<?php
/**
 * Footer tùy chỉnh sử dụng Module 03 cho Child Theme
 */

// Đường dẫn tới file footer.php trong module-03
$module_03_footer = get_stylesheet_directory() . '/modules/module-03/footer.php';

if ( file_exists( $module_03_footer ) ) {
    include $module_03_footer;
} else {
    // Fallback nếu chưa tìm thấy module-03 thì dùng footer gốc của theme cha
    require get_template_directory() . '/footer.php';
}