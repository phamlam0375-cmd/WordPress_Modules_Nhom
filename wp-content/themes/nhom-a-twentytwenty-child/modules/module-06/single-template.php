<?php

/** Trang chi tiết bài viết: khung nội dung và vòng tròn ngày đăng. */
get_header();
?>
<main id="site-content" class="gcn-single" role="main">
	<div class="gcn-wrap">
		<?php while (have_posts()) : the_post(); ?>
			<article <?php post_class('gcn-detail-card'); ?> id="post-<?php the_ID(); ?>">
				<header class="gcn-detail-header">
					<h1><?php echo esc_html(get_the_title()); ?></h1>
					<time class="gcn-date-badge" datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>">
						<strong><?php echo esc_html(get_the_date('d')); ?></strong>
						<span>THÁNG <?php echo esc_html(get_the_date('m')); ?></span>
						<span><?php echo esc_html(get_the_date('Y')); ?></span>
					</time>
				</header>
				<?php if (has_post_thumbnail()) : ?>
					<figure class="gcn-detail-image"><?php the_post_thumbnail('large'); ?></figure>
				<?php endif; ?>
				<div class="gcn-detail-content">
					<?php the_content(); ?>
					<?php wp_link_pages(array('before' => '<nav class="gcn-page-links">Trang:', 'after' => '</nav>')); ?>
				</div>
				<footer class="gcn-detail-footer">
					<span>Danh mục: <?php the_category(', '); ?></span>
					<a href="<?php echo esc_url(home_url('/')); ?>">← Về trang chủ</a>
				</footer>
			</article>

			<!-- Module 07: Prev/Next Post -->
			<?php
			if (function_exists('gcn_render_module_07_prev_next')) {
				gcn_render_module_07_prev_next();
			}
			?>

			<!-- Module 17: Author Box -->
			<?php
			$module_17_path = get_stylesheet_directory() . '/modules/module-17/author-box.php';
			if (file_exists($module_17_path)) {
				include $module_17_path;
			}
			?>

			<!-- Module 14: Comments -->
			<?php if (comments_open() || get_comments_number()) : ?>
				<div class="gcn-comments">
					<?php
					$module_comments = get_stylesheet_directory() . '/modules/module-14/comments.php';
					if (is_readable($module_comments)) {
						require $module_comments;
					}
					?>
				</div>
			<?php endif; ?>
		<?php endwhile; ?>
	</div>
</main>
<?php get_footer(); ?>