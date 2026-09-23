<?php
$number = 0;

if (isset($args['number'])) {
    $number = (int) $args['number'];
} else {
    $number = (int) get_query_var('gcn_popular_number', 0);
}
?>
<article <?php post_class('gcn-popular-item'); ?> id="popular-post-<?php the_ID(); ?>">

    <div class="gcn-popular-number" aria-hidden="true">
        <?php echo esc_html($number); ?>
    </div>

    <h3 class="gcn-popular-item-title">
        <a href="<?php echo esc_url(get_permalink()); ?>">
            <?php echo esc_html(get_the_title()); ?>
        </a>
        <?php
        $comment_count = get_comments_number();
        if ($comment_count > 0) :
        ?>
            <span class="gcn-popular-comment-count"><?php echo esc_html($comment_count); ?></span>
        <?php endif; ?>
    </h3>

</article>