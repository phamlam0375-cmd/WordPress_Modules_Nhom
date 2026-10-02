<?php

/**
 * Module 07: Previous / Next Post
 * - Chưa đăng nhập: Hiển thị Tiêu đề (Hình 1)
 * - Đã đăng nhập: Hiển thị Ngày/Tháng dạng phân số + Năm + Tiêu đề (Hình 2)
 */

if (! defined('ABSPATH')) {
    exit;
}

if (! function_exists('gcn_render_module_07_prev_next')) {
    function gcn_render_module_07_prev_next()
    {
        if (! is_singular('post')) {
            return;
        }

        $prev_post = get_previous_post();
        $next_post = get_next_post();

        if (! $prev_post && ! $next_post) {
            return;
        }

        $is_logged_in = is_user_logged_in();
?>
        <div class="gcn-module-07-prevnext <?php echo $is_logged_in ? 'is-logged-in' : 'is-guest'; ?>">

            <!-- Cột Previous Post (Bên trái) -->
            <div class="gcn-nav-item gcn-nav-prev">
                <?php if ($next_post) :
                    $next_link  = get_permalink($next_post->ID);
                    $next_title = get_the_title($next_post->ID);
                    $next_day   = get_the_date('d', $next_post->ID);
                    $next_month = get_the_date('m', $next_post->ID);
                    $next_year  = get_the_date('y', $next_post->ID);
                ?>
                    <a href="<?php echo esc_url($next_link); ?>" class="gcn-nav-link">
                        <?php if ($is_logged_in) : ?>
                            <div class="gcn-date-wrapper">
                                <div class="gcn-date-fraction">
                                    <span class="gcn-day"><?php echo esc_html($next_day); ?></span>
                                    <span class="gcn-month"><?php echo esc_html($next_month); ?></span>
                                </div>
                                <span class="gcn-year"><?php echo esc_html($next_year); ?></span>
                            </div>
                            <span class="gcn-nav-title"><?php echo esc_html($next_title); ?></span>
                        <?php else : ?>
                            <span class="gcn-nav-label"><span class="gcn-arrow">&larr;</span> Previous post </span>
                            <span class="gcn-nav-title"><?php echo esc_html($next_title); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Cột Next Post (Bên phải) -->
            <div class="gcn-nav-item gcn-nav-next">
                <?php if ($prev_post) :
                    $prev_link  = get_permalink($prev_post->ID);
                    $prev_title = get_the_title($prev_post->ID);
                    $prev_day   = get_the_date('d', $prev_post->ID);
                    $prev_month = get_the_date('m', $prev_post->ID);
                    $prev_year  = get_the_date('y', $prev_post->ID); // Dùng 'y' cho năm 2 số (18)
                ?>
                    <a href="<?php echo esc_url($prev_link); ?>" class="gcn-nav-link">
                        <?php if ($is_logged_in) : ?>
                            <div class="gcn-date-wrapper">
                                <div class="gcn-date-fraction">
                                    <span class="gcn-day"><?php echo esc_html($prev_day); ?></span>
                                    <span class="gcn-month"><?php echo esc_html($prev_month); ?></span>
                                </div>
                                <span class="gcn-year"><?php echo esc_html($prev_year); ?></span>
                            </div>
                            <span class="gcn-nav-title"><?php echo esc_html($prev_title); ?></span>
                        <?php else : ?>
                            <span class="gcn-nav-label"> Next post <span class="gcn-arrow">&rarr;</span></span>
                            <span class="gcn-nav-title"><?php echo esc_html($prev_title); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
            </div>

        </div>
<?php
    }
}
