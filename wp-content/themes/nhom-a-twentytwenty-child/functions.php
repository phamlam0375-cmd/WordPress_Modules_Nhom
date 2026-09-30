<?php

/**
 * Thiết lập stylesheet và nạp chức năng của các module trong theme nhóm A.
 */

if (! defined('ABSPATH')) {
	exit;
}

if (! function_exists('gcn_twentytwenty_enqueue_styles')) {
	/** Nạp stylesheet của theme cha, theme con và bố cục dùng chung. */
	function gcn_twentytwenty_enqueue_styles()
	{
		$parent_theme   = wp_get_theme('twentytwenty');
		$child_theme    = wp_get_theme();
		$layout_path    = get_stylesheet_directory() . '/assets/css/layout.css';
		$layout_version = is_readable($layout_path) ? (string) filemtime($layout_path) : $child_theme->get('Version');

		wp_enqueue_style(
			'gcn-twentytwenty-parent',
			get_template_directory_uri() . '/style.css',
			array(),
			$parent_theme->get('Version')
		);

		wp_enqueue_style(
			'nhom-a-twentytwenty-child',
			get_stylesheet_uri(),
			array('gcn-twentytwenty-parent'),
			$child_theme->get('Version')
		);

		wp_enqueue_style(
			'gcn-search-detail',
			get_stylesheet_directory_uri() . '/assets/css/layout.css',
			array('nhom-a-twentytwenty-child'),
			$layout_version
		);

		$module_header_path    = get_stylesheet_directory() . '/modules/module-01/header.css';
		$module_header_version = is_readable($module_header_path) ? (string) filemtime($module_header_path) : $child_theme->get('Version');

		wp_enqueue_style(
			'gcn-module-01-bootstrap',
			'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css',
			array('gcn-search-detail'),
			'3.3.0'
		);

		wp_enqueue_style(
			'gcn-module-01-header',
			get_stylesheet_directory_uri() . '/modules/module-01/header.css',
			array('gcn-module-01-bootstrap'),
			$module_header_version
		);

		$module_comments_path    = get_stylesheet_directory() . '/modules/module-14/comments.css';
		$module_comments_version = is_readable($module_comments_path) ? (string) filemtime($module_comments_path) : $child_theme->get('Version');

		wp_enqueue_style(
			'gcn-module-14-comments',
			get_stylesheet_directory_uri() . '/modules/module-14/comments.css',
			array('gcn-module-01-header'),
			$module_comments_version
		);

		// Nạp CSS cho Module 07
		$module_07_css_path    = get_stylesheet_directory() . '/modules/module-07/style.css';
		$module_07_css_version = is_readable($module_07_css_path) ? (string) filemtime($module_07_css_path) : $child_theme->get('Version');

		wp_enqueue_style(
			'gcn-module-07-prevnext',
			get_stylesheet_directory_uri() . '/modules/module-07/style.css',
			array('nhom-a-twentytwenty-child'),
			$module_07_css_version
		);
		wp_enqueue_script('jquery');
		wp_enqueue_script(
			'gcn-module-01-bootstrap',
			'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js',
			array('jquery'),
			'3.3.0',
			true
		);
		// Nạp CSS cho Module 11 (Archive)
		$module_11_css_path    = get_stylesheet_directory() . '/modules/module-11/style.css';
		$module_11_css_version = is_readable($module_11_css_path) ? (string) filemtime($module_11_css_path) : $child_theme->get('Version');

		wp_enqueue_style(
			'gcn-module-11-archive',
			get_stylesheet_directory_uri() . '/modules/module-11/style.css',
			array('nhom-a-twentytwenty-child'),
			$module_11_css_version
		);
	}
}

if (! has_action('wp_enqueue_scripts', 'gcn_twentytwenty_enqueue_styles')) {
	add_action('wp_enqueue_scripts', 'gcn_twentytwenty_enqueue_styles', 20);
}

if (! function_exists('nhom_a_load_module_functions')) {
	/** Nạp file functions.php của module nếu module đó đã có code PHP. */
	function nhom_a_load_module_functions()
	{
		for ($module_number = 1; $module_number <= 20; $module_number++) {
			$module_file = get_stylesheet_directory() . sprintf(
				'/modules/module-%02d/functions.php',
				$module_number
			);

			if (is_readable($module_file)) {
				require_once $module_file;
			}
		}
	}
}
nhom_a_load_module_functions();

/** In 1 bình luận (gốc hoặc câu trả lời) cho cột phải trang tìm kiếm. */
function m14_render_side_item($c, $current_url, $is_reply = false)
{
	$parent = $is_reply ? get_comment($c->comment_parent) : null;
?>
	<li class="m14-side-item<?php echo $is_reply ? ' is-reply' : ''; ?>">
		<div class="m14-side-avatar"><?php echo get_avatar($c, $is_reply ? 28 : 40); ?></div>
		<div class="m14-side-body">
			<strong class="m14-side-name"><?php echo esc_html($c->comment_author); ?></strong>
			<span class="m14-side-date"><?php echo esc_html(get_comment_date('d.m.Y \l\ú\c H:i', $c)); ?></span>

			<div class="m14-side-text">
				<?php if ($parent) : ?>
					<span class="m14-side-mention">@<?php echo esc_html($parent->comment_author); ?></span>
				<?php endif; ?>
				<?php echo esc_html(wp_trim_words($c->comment_content, 30, '…')); ?>
			</div>

			<?php if (! $is_reply) : ?>
				<a class="m14-side-link" href="<?php echo esc_url(get_comment_link($c)); ?>">
					Trong: <?php echo esc_html(get_the_title($c->comment_post_ID)); ?>
				</a>
			<?php endif; ?>

			<?php if (comments_open($c->comment_post_ID)) : ?>
				<button type="button" class="m14-reply-btn" data-target="m14-reply-<?php echo (int) $c->comment_ID; ?>">Trả lời</button>

				<form class="m14-reply-form" id="m14-reply-<?php echo (int) $c->comment_ID; ?>" method="post" action="<?php echo esc_url(site_url('/wp-comments-post.php')); ?>" hidden>
					<?php if (! is_user_logged_in()) : ?>
						<input type="text" name="author" placeholder="Tên *" required>
						<input type="email" name="email" placeholder="Email *" required>
					<?php endif; ?>
					<textarea name="comment" rows="3" placeholder="Trả lời <?php echo esc_attr($c->comment_author); ?>…" required></textarea>
					<input type="hidden" name="comment_post_ID" value="<?php echo (int) $c->comment_post_ID; ?>">
					<input type="hidden" name="comment_parent" value="<?php echo (int) $c->comment_ID; ?>">
					<input type="hidden" name="gcn_redirect_to" value="<?php echo esc_url($current_url); ?>">
					<button type="submit">Gửi</button>
				</form>
			<?php endif; ?>
		</div>
	</li>
<?php
}

/** Lấy mọi câu trả lời con cháu của 1 bình luận, xếp theo thời gian. */
function m14_get_all_replies($comment_id)
{
	$all   = array();
	$queue = array((int) $comment_id);

	while ($queue) {
		$pid  = array_shift($queue);
		$kids = get_comments(array(
			'status' => 'approve',
			'parent' => $pid,
		));
		foreach ($kids as $k) {
			$all[]   = $k;
			$queue[] = (int) $k->comment_ID;
		}
	}

	usort($all, function ($a, $b) {
		return strcmp($a->comment_date_gmt, $b->comment_date_gmt);
	});

	return $all;
}

/** Cột phải trang tìm kiếm: bình luận mới + câu trả lời (làm phẳng, thụt 1 cấp). */
add_action('nhom_a_search_right_column', function () {
	// Chỉ lấy bình luận gốc; câu trả lời nằm ngay dưới bình luận cha.
	$recent_comments = get_comments(array(
		'status'  => 'approve',
		'parent'  => 0,
		'number'  => 5,
		'orderby' => 'comment_date_gmt',
		'order'   => 'DESC',
	));

	$current_url = add_query_arg('s', get_search_query(false), home_url('/'));
	$paged       = (int) get_query_var('paged');
	if ($paged > 1) {
		$current_url = add_query_arg('paged', $paged, $current_url);
	}
?>
	<section class="module-14-comments m14-side">
		<h2 class="module-14-comments-title">Bình luận mới</h2>
		<?php if ($recent_comments) : ?>
			<ul class="m14-side-list">
				<?php foreach ($recent_comments as $c) : ?>
					<?php m14_render_side_item($c, $current_url); ?>
					<?php
					$replies = m14_get_all_replies($c->comment_ID);
					if ($replies) : ?>
						<li class="m14-side-replies-wrap">
							<ul class="m14-side-children">
								<?php foreach ($replies as $r) {
									m14_render_side_item($r, $current_url, true);
								} ?>
							</ul>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<p>Chưa có bình luận.</p>
		<?php endif; ?>
	</section>
	<script>
		document.addEventListener('click', function(e) {
			var btn = e.target.closest('.m14-reply-btn');
			if (!btn) return;
			var form = document.getElementById(btn.getAttribute('data-target'));
			if (form) form.hidden = !form.hidden;
		});
	</script>
<?php
});

/** Sau khi gửi trả lời từ trang tìm kiếm thì quay lại trang tìm kiếm. */
add_filter('comment_post_redirect', function ($location) {
	if (! empty($_POST['gcn_redirect_to'])) {
		$back = wp_validate_redirect(esc_url_raw(wp_unslash($_POST['gcn_redirect_to'])), '');
		if ($back) {
			return $back;
		}
	}
	return $location;
});
