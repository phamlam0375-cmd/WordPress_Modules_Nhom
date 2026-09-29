<?php
// Hàm đăng ký Widget cho Module 12
function register_module_12_widget() {
    register_sidebar( array(
        'name'          => 'Module #12 - Comments',
        'id'            => 'module-12-comments',
        'description'   => 'Khu vực Comments bên cột phải',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'register_module_12_widget' );