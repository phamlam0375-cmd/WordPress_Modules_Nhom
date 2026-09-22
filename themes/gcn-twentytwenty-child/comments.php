<?php
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="gcn-comments-area">

    <?php if (have_comments()) : ?>

        <h2 class="gcn-comments-title">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                echo '1 bình luận';
            } else {
                echo esc_html($comment_count) . ' bình luận';
            }
            ?>
        </h2>

        <ol class="gcn-comment-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 48,
                'callback'    => 'gcn_custom_comment_template',
            ));
            ?>
        </ol>

        <?php
        the_comments_pagination(array(
            'prev_text' => '← Bình luận trước',
            'next_text' => 'Bình luận sau →',
        ));
        ?>

    <?php endif; ?>

    <?php if (! comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="gcn-comments-closed">Bình luận đã đóng.</p>
    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply'          => 'Để lại bình luận',
        'title_reply_before'   => '<h2 id="reply-title" class="gcn-comment-reply-title">',
        'title_reply_after'    => '</h2>',
        'comment_notes_after'  => '',
        'label_submit'         => 'Gửi bình luận',
        'class_submit'         => 'gcn-submit-btn',
        'comment_field' => '<p class="gcn-comment-form-comment">' .
            '<label for="comment">Bình luận *</label>' .
            '<textarea id="comment" name="comment" cols="45" rows="6" maxlength="5000" required></textarea>' .
            '</p>',
        'fields'               => array(
            'author' => '<p class="gcn-comment-form-author">' .
                '<label for="author">Tên *</label>' .
                '<input id="author" name="author" type="text" maxlength="80" required />' .
                '</p>',
            'email'  => '<p class="gcn-comment-form-email">' .
                '<label for="email">Email *</label>' .
                '<input id="email" name="email" type="email" maxlength="100" required />' .
                '</p>',
            'url'    => '<p class="gcn-comment-form-url">' .
                '<label for="url">Website</label>' .
                '<input id="url" name="url" type="url" maxlength="200" />' .
                '</p>',
        ),
    ));
    ?>

</div>