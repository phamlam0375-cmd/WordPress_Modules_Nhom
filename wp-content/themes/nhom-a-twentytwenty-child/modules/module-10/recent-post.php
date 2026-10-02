<?php

/**
 * Module 10: Recent post
 * Tham khảo: http://fit.tdc.edu.vn
 *
 * Nền xanh ngọc, ngày đăng dạng phân số (ngày/tháng + năm), tiêu đề,
 * nút "XEM TẤT CẢ TIN TỨC" ở cuối. Không lặp lại bài đang xem.
 */

if (! defined('ABSPATH')) {
	exit;
}

$module10_query = new WP_Query(array(
	'post_type'           => 'post',
	'posts_per_page'      => 5,
	'post__not_in'        => is_singular('post') ? array(get_the_ID()) : array(),
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
));
?>
<section class="module10-recent">
	<h2 class="screen-reader-text">Bài viết mới nhất</h2>

	<?php if ($module10_query->have_posts()) : ?>
		<ul class="module10-recent__list">
			<?php while ($module10_query->have_posts()) : $module10_query->the_post(); ?>
				<li class="module10-recent__item">
					<?php echo module10_fraction_date(); // Đã escape trong hàm. ?>
					<a class="module10-recent__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</li>
			<?php endwhile; ?>
		</ul>
		<?php wp_reset_postdata(); ?>
	<?php else : ?>
		<p class="module10-recent__empty">Chưa có bài viết.</p>
	<?php endif; ?>

	<a class="module10-recent__all" href="<?php echo esc_url(module10_all_posts_url()); ?>">Xem tất cả tin tức</a>
</section>
