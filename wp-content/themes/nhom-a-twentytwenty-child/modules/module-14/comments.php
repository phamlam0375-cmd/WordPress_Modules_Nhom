<?php
/**
 * Module 14: danh sách bình luận và form gửi bình luận.
 */

if ( post_password_required() ) {
	return;
}

$module_comments = get_comments(
	array(
		'post_id' => get_the_ID(),
		'status'  => 'approve',
		'order'  => 'ASC',
	)
);
?>
<section class="module-14-comments" aria-labelledby="module-14-comments-title">
	<h2 id="module-14-comments-title" class="module-14-comments-title">
		<?php comments_number( 'Chưa có bình luận', '1 bình luận', '% bình luận' ); ?>
	</h2>

	<?php if ( ! empty( $module_comments ) ) : ?>
		<ol class="module-14-comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 50,
				),
				$module_comments
			);
			?>
		</ol>

		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php if ( comments_open() ) : ?>
		<div class="module-14-comment-form">
			<?php
			comment_form(
				array(
					'title_reply'          => 'Để lại bình luận',
					'label_submit'         => 'Gửi bình luận',
					'comment_notes_before' => '',
					'comment_field'        => '<p class="comment-form-comment"><label for="comment">Bình luận <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="6" required></textarea></p>',
				)
			);
			?>
		</div>
	<?php endif; ?>
</section>
