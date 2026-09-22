<?php

/**
 * Functions cho theme con GCN TwentyTwenty Child.
 * Giữ giao diện Twenty Twenty, bổ sung search + single + comments.
 */

if (! defined('ABSPATH')) {
	exit;
}

/* ============================================================
   1. ENQUEUE CSS
   ============================================================ */

function gcn_twentytwenty_enqueue_styles()
{
	// CSS theme cha
	wp_enqueue_style(
		'gcn-twentytwenty-parent',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme('twentytwenty')->get('Version')
	);

	// CSS layout (search + single)
	wp_enqueue_style(
		'gcn-search-detail',
		get_stylesheet_directory_uri() . '/assets/css/layout.css',
		array('gcn-twentytwenty-parent'),
		'1.0.0'
	);

	// CSS post-list (archive + related)
	wp_enqueue_style(
		'gcn-post-list',
		get_stylesheet_directory_uri() . '/assets/css/post-list.css',
		array('gcn-search-detail'),
		'1.0.0'
	);

	// CSS comments — CHỈ nạp ở trang single post
	if (is_singular('post')) {
		wp_enqueue_style(
			'gcn-comments',
			get_stylesheet_directory_uri() . '/assets/css/comments.css',
			array('gcn-search-detail'),
			'1.0.0'
		);
	}
}
add_action('wp_enqueue_scripts', 'gcn_twentytwenty_enqueue_styles', 20);

/* ============================================================
   2. TEMPLATE COMMENT — Callback cho wp_list_comments
   ============================================================ */

function gcn_custom_comment_template($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
?>
	<li <?php comment_class('gcn-comment-item'); ?> id="comment-<?php comment_ID(); ?>">
		<article class="gcn-comment-body">

			<header class="comment-author vcard">
				<?php echo get_avatar($comment, $args['avatar_size']); ?>
				<?php printf('<b class="fn">%s</b>', get_comment_author_link()); ?>
			</header>

			<div class="comment-metadata">
				<a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
					<time datetime="<?php comment_time('c'); ?>">
						<?php printf('%s lúc %s', get_comment_date(), get_comment_time()); ?>
					</time>
				</a>
				<?php edit_comment_link('Sửa', ' · '); ?>
			</div>

			<div class="comment-content">
				<?php echo wp_kses_post(wpautop(get_comment_text())); ?>
			</div>

			<?php if ('0' == $comment->comment_approved) : ?>
				<p class="gcn-comment-awaiting">Bình luận đang chờ duyệt.</p>
			<?php endif; ?>

			<footer class="reply">
				<?php
				comment_reply_link(array_merge($args, array(
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
				)));
				?>
			</footer>

		</article>
	<?php
	// KHÔNG đóng </li> — WordPress tự đóng.
}

/* ============================================================
   3. SANITIZE COMMENT — Chuẩn hóa nội dung TRƯỚC KHI LƯU
   ============================================================ */

function gcn_sanitize_comment_content($commentdata)
{
	if (empty($commentdata['comment_content'])) {
		return $commentdata;
	}

	$content = $commentdata['comment_content'];

	// 1. Loại bỏ zero-width, BOM, tab, ký tự điều hướng.
	$content = preg_replace('/[\x{200B}-\x{200F}\x{202A}-\x{202E}\x{FEFF}\t]/u', '', $content);

	// 2. Gộp nhiều khoảng trắng liên tiếp thành 1.
	$content = preg_replace('/ {2,}/u', ' ', $content);

	// 3. Gộp nhiều xuống dòng liên tiếp — tối đa 2.
	$content = preg_replace('/\n{3,}/u', "\n\n", $content);

	// 4. Loại bỏ khoảng trắng đầu/cuối mỗi dòng.
	$content = preg_replace('/^[ \t]+|[ \t]+$/mu', '', $content);

	// 5. Trim toàn bộ.
	$content = trim($content);

	$commentdata['comment_content'] = $content;

	return $commentdata;
}
add_filter('preprocess_comment', 'gcn_sanitize_comment_content', 5);

/* ============================================================
   4. REJECT EMPTY COMMENT — Chặn comment rỗng SAU KHI SANITIZE
   ============================================================ */

function gcn_reject_empty_comment($commentdata)
{
	if (empty($commentdata['comment_content'])) {
		wp_die(
			'Bình luận không được để trống.',
			'Lỗi bình luận',
			array('response' => 400, 'back_link' => true)
		);
	}

	// Loại bỏ tất cả khoảng trắng + ký tự vô hình.
	$stripped = preg_replace('/[\s\x{200B}-\x{200F}\x{FEFF}]+/u', '', $commentdata['comment_content']);

	if ('' === $stripped) {
		wp_die(
			'Bình luận không được chỉ chứa khoảng trắng.',
			'Lỗi bình luận',
			array('response' => 400, 'back_link' => true)
		);
	}

	return $commentdata;
}
add_filter('preprocess_comment', 'gcn_reject_empty_comment', 10);

/* ============================================================
   5. FORMAT COMMENT DISPLAY — Chuẩn hóa comment CŨ khi hiển thị
   ============================================================ */

function gcn_format_comment_display($text)
{
	// Gộp nhiều khoảng trắng liên tiếp (giữ tối đa 2).
	$text = preg_replace('/ {3,}/u', '  ', $text);

	// Gộp nhiều xuống dòng liên tiếp — tối đa 2.
	$text = preg_replace('/\n{3,}/u', "\n\n", $text);

	return $text;
}
add_filter('comment_text', 'gcn_format_comment_display', 5);

/* ============================================================
   6. SEARCH — Chỉ tìm bài viết, không tìm page
   ============================================================ */

function gcn_twentytwenty_search_posts_only($query)
{
	if (! is_admin() && $query->is_main_query() && $query->is_search()) {
		$query->set('post_type', 'post');
	}
}
add_action('pre_get_posts', 'gcn_twentytwenty_search_posts_only');
