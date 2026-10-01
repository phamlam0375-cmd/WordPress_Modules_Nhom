<?php

/** Trang chi tiết bài viết: khung nội dung và vòng tròn ngày đăng. */
get_header();

// Cột trái / phải của trang chi tiết (vd: Module 09, Module 10) gắn qua hook.
$single_has_left_column  = false !== has_action('nhom_a_single_left_column');
$single_has_right_column = false !== has_action('nhom_a_single_right_column');
$single_has_columns      = $single_has_left_column || $single_has_right_column;
?>
<main id="site-content" class="gcn-single<?php echo $single_has_columns ? ' gcn-single--has-columns' : ''; ?>" role="main">
	<div class="gcn-wrap">
		<?php while (have_posts()) : the_post(); ?>
			<?php do_action('nhom_a_single_before_content'); ?>

			<?php if ($single_has_columns) : ?>
			<div class="nhom-a-single-layout">
				<?php if ($single_has_left_column) : ?>
					<aside class="nhom-a-single-left">
						<?php do_action('nhom_a_single_left_column'); ?>
					</aside>
				<?php endif; ?>
			<?php endif; ?>

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
				<!-- Module 16: Social Share -->
				<?php
				if (function_exists('gcn_render_module_16_social_share')) {
					gcn_render_module_16_social_share();
				}
				?>

				<!-- Module 07: Prev/Next Post -->
				<?php
				if (function_exists('gcn_render_module_07_prev_next')) {
					gcn_render_module_07_prev_next();
				}
				?>
			</article>

			<?php if ($single_has_columns) : ?>
				<?php if ($single_has_right_column) : ?>
					<aside class="nhom-a-single-right">
						<?php do_action('nhom_a_single_right_column'); ?>
					</aside>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<div class="nhom-a-single-bottom">
			<!-- Module 07: Prev/Next Post -->
			<?php
			if (function_exists('gcn_render_module_07_prev_next')) {
				gcn_render_module_07_prev_next();
			}
			?>

			<!-- GẮN MODULE 17 (TÁC GIẢ BÀI VIẾT) Ở ĐÂY -->
			<?php
			$module_17_path = get_stylesheet_directory() . '/modules/module-17/author-box.php';
			if (file_exists($module_17_path)) {
				include $module_17_path;
			}
			?>

			<?php do_action('nhom_a_single_before_comments'); ?>

			<!-- Module 08: Comments Form -->
			<?php
			if (function_exists('gcn_render_module_08_comments')) {
				gcn_render_module_08_comments();
			}
			?>
			</div>
		<?php endwhile; ?>
	</div>
</main>
<?php get_footer(); ?>