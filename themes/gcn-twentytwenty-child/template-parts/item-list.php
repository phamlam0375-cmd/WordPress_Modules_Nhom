<article <?php post_class('gcn-post-item'); ?> id="post-<?php the_ID(); ?>">

    <a class="gcn-post-date" href="<?php echo esc_url(get_permalink()); ?>" aria-label="Xem bài: <?php echo esc_attr(get_the_title()); ?>">
        <span class="gcn-date-day"><?php echo esc_html(get_the_date('d')); ?></span>
        <span class="gcn-date-month"><?php echo esc_html(get_the_date('m')); ?></span>
        <span class="gcn-date-year"><?php echo esc_html(get_the_date('y')); ?></span>
    </a>

    <div class="gcn-post-body">
        <h3 class="gcn-post-title">
            <a href="<?php echo esc_url(get_permalink()); ?>">
                <?php echo esc_html(get_the_title()); ?>
            </a>
        </h3>
    </div>

</article>