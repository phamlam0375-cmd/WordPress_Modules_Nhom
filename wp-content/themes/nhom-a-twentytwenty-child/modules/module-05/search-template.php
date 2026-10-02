<?php

/** Trang kết quả tìm kiếm: ảnh - ngày - tiêu đề - tóm tắt. */
get_header();

$module13_has_left_column  = have_posts() && false !== has_action('nhom_a_search_left_column');
$module13_has_right_column = false !== has_action('nhom_a_search_right_column');
$module13_layout_class     = 'module13-search-layout';

if ($module13_has_right_column) {
	$module13_layout_class .= ' module13-search-layout--has-right';
}

if (! $module13_has_left_column) {
	$module13_layout_class .= ' module13-search-layout--without-left';
}
?>
<main id="site-content" class="gcn-search" role="main">
	<div class="gcn-wrap">
		<header class="gcn-search-header">
			<h1>Kết quả tìm kiếm cho “<?php echo esc_html(get_search_query(false)); ?>”</h1>
			<p>Chọn một bài viết để xem nội dung đầy đủ.</p>
			<?php get_search_form(); ?>
		</header>

		<div class="<?php echo esc_attr($module13_layout_class); ?>">
			<?php if ($module13_has_left_column) : ?>
				<aside class="module13-search-column" aria-label="<?php echo esc_attr__('Kết quả tìm kiếm thu gọn', 'nhom-a-twentytwenty-child'); ?>">
					<?php do_action('nhom_a_search_left_column'); ?>
				</aside>
			<?php endif; ?>

			<section class="module13-search-main" aria-label="<?php echo esc_attr__('Kết quả tìm kiếm', 'nhom-a-twentytwenty-child'); ?>">
				<?php if (have_posts()) : ?>
					<div class="gcn-results">
						<?php while (have_posts()) : the_post(); ?>
							<article <?php post_class('gcn-result-card'); ?> id="post-<?php the_ID(); ?>">
								<a class="gcn-result-image" href="<?php echo esc_url(get_permalink()); ?>" aria-label="Xem bài: <?php echo esc_attr(get_the_title()); ?>">
									<?php if (has_post_thumbnail()) : ?>
										<?php the_post_thumbnail('medium', array('loading' => 'lazy')); ?>
									<?php else : ?>
										<span class="gcn-image-placeholder">Góc Công Nghệ</span>
									<?php endif; ?>
								</a>
								<div class="gcn-result-date">
									<time datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>">
										<strong><?php echo esc_html(get_the_date('d')); ?></strong>
										<span>THÁNG <?php echo esc_html(get_the_date('m')); ?><br><?php echo esc_html(get_the_date('Y')); ?></span>
									</time>
								</div>
								<div class="gcn-result-text">
									<h2><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></h2>
									<p><?php echo esc_html(wp_trim_words(wp_strip_all_tags(get_the_excerpt()), 28, '…')); ?></p>
								</div>
							</article>
						<?php endwhile; ?>
					</div>
					<?php the_posts_pagination(array('prev_text' => '← Trang trước', 'next_text' => 'Trang sau →')); ?>
				<?php else : ?>
					<p class="gcn-no-results">Không tìm thấy bài viết phù hợp. Hãy thử từ khóa khác.</p>
				<?php endif; ?>
			</section>

			<?php if ($module13_has_right_column) : ?>
				<aside class="module13-search-right">
					<?php do_action('nhom_a_search_right_column'); ?>
				</aside>
			<?php endif; ?>
		</div>

		<?php if (false !== has_action('nhom_a_search_after_columns')) : ?>
			<div class="module13-search-bottom">
				<?php do_action('nhom_a_search_after_columns'); ?>
			</div>
		<?php endif; ?>
	</div>
</main>

<style>
	/* ===== Trang tìm kiếm: 3 cột cùng một mức ===== */
	.module13-search-layout {
		margin-top: 24px;
		align-items: flex-start;
	}

	.gcn-search .module13-search-layout>aside,
	.gcn-search .module13-search-layout>section {
		margin-top: 0 !important;
		padding-top: 0 !important;
	}

	/* Cột trái và cột giữa: phần tử đầu tiên không bị đẩy xuống */
	.gcn-search .module13-search-column>*,
	.gcn-search .module13-search-column>*:first-child>*:first-child,
	.gcn-search .module13-search-main>*:first-child,
	.gcn-search .module13-search-main .gcn-results {
		margin-top: 0 !important;
	}

	/* Cột phải: giữ đủ padding cho khung Bình luận mới */
	.gcn-search .module13-search-layout>.module13-search-right>* {
		margin-top: 0 !important;
		padding: 16px !important;
		box-sizing: border-box;
	}

	.gcn-search .module13-search-right .module-14-comments-title {
		margin: 0 0 16px;
		padding-top: 0 !important;
		padding-bottom: 12px;
	}

	.gcn-search .module13-search-right,
	.gcn-search .module13-search-right .m14-side {
		overflow: visible;
	}

	.gcn-search .module13-search-right .m14-side-list {
		overflow-y: auto;
		overflow-x: hidden;
	}

	/* Cột trái: bắt đầu ngang cột giữa */
	.gcn-search .module13-search-layout>.module13-search-column {
		align-self: flex-start !important;
		margin: 0 !important;
		padding-top: 0 !important;
		top: 0 !important;
		transform: none !important;
		position: static !important;
		display: block !important;
	}

	/* Mọi phần tử đầu tiên ở các cấp bên trong cột trái */
	.gcn-search .module13-search-column :first-child {
		margin-top: 0 !important;
		top: 0 !important;
		transform: none !important;
	}

	/* Tiêu đề hoặc khối rỗng đứng trước card đầu tiên (nếu có) */
	.gcn-search .module13-search-column>h2:empty,
	.gcn-search .module13-search-column>h3:empty,
	.gcn-search .module13-search-column>div:empty {
		display: none;
	}

	/* Dùng grid, ghi đè flex cũ */
	.gcn-search .module13-search-layout {
		display: grid !important;
		grid-template-columns: 210px minmax(0, 1fr) 380px;
		gap: 20px;
		align-items: start !important;
	}

	.gcn-search .module13-search-layout--without-left {
		grid-template-columns: minmax(0, 1fr) 380px;
	}

	.gcn-search .module13-search-layout>.module13-search-column,
	.gcn-search .module13-search-layout>.module13-search-main,
	.gcn-search .module13-search-layout>.module13-search-right {
		width: auto !important;
		flex: none !important;
		align-self: start !important;
		margin: 0 !important;
	}

	/* Khối bên trong cột trái */
	.gcn-search .module13-search-results,
	.gcn-search .module13-search-list {
		margin: 0 !important;
		padding: 0 !important;
		top: 0 !important;
		position: static !important;
		transform: none !important;
	}

	@media (max-width: 1100px) {
		.gcn-search .module13-search-layout {
			grid-template-columns: minmax(0, 1fr) 380px;
		}
	}

	@media (max-width: 900px) {
		.gcn-search .module13-search-layout {
			grid-template-columns: minmax(0, 1fr);
		}
	}
</style>

<?php get_footer(); ?>