<?php

/**
 * Module 22 (tự chọn): Related posts - Bài viết liên quan
 *
 * 3 bài cùng chuyên mục (không tính bài đang xem), dạng thẻ: ảnh, chuyên mục,
 * tiêu đề, ngày đăng. 3 cột trên máy tính, rớt xuống 1 cột trên điện thoại.
 */

if (! defined('ABSPATH')) {
	exit;
}

$module22_query = new WP_Query(array(
	'post_type'           => 'post',
	'posts_per_page'      => 3,
	'category__in'        => wp_get_post_categories(get_the_ID()),
	'post__not_in'        => array(get_the_ID()),
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
));

if (! $module22_query->have_posts()) {
	return;
}
?>
<section class="module22-related">
	<h2 class="module22-related__title">Bài viết liên quan</h2>

	<div class="module22-related__grid">
		<?php while ($module22_query->have_posts()) : $module22_query->the_post(); ?>
			<?php $module22_categories = get_the_category(); ?>
			<a class="module22-related__card" href="<?php the_permalink(); ?>">
				<span class="module22-related__thumb">
					<?php if (has_post_thumbnail()) : ?>
						<?php the_post_thumbnail('medium_large', array('loading' => 'lazy')); ?>
					<?php else : ?>
						<?php // Chưa có ảnh đại diện: hiện chữ cái đầu của tiêu đề. ?>
						<span class="module22-related__noimg" aria-hidden="true"><?php echo esc_html(mb_substr(get_the_title(), 0, 1)); ?></span>
					<?php endif; ?>
				</span>
				<span class="module22-related__body">
					<?php if ($module22_categories) : ?>
						<span class="module22-related__cat"><?php echo esc_html($module22_categories[0]->name); ?></span>
					<?php endif; ?>
					<strong class="module22-related__name"><?php the_title(); ?></strong>
					<time class="module22-related__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('d/m/Y')); ?></time>
				</span>
			</a>
		<?php endwhile; ?>
	</div>
	<?php wp_reset_postdata(); ?>
</section>
