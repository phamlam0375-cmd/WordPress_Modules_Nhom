<?php

/**
 * Module 09: Categories
 * Tham khảo: http://fit.tdc.edu.vn
 *
 * Tiêu đề đậm + vạch sọc, khung trắng, chấm tròn vàng, kẻ ngang giữa các dòng.
 * Dữ liệu lấy từ database (get_categories).
 */

if (! defined('ABSPATH')) {
	exit;
}

$module09_categories = get_categories(array(
	'orderby'    => 'name',
	'hide_empty' => false,
));

$module09_current = is_singular('post') ? wp_get_post_categories(get_the_ID()) : array();
?>
<section class="module09-categories">
	<h2 class="module09-categories__title">Categories</h2>

	<div class="module09-categories__box">
		<?php if ($module09_categories) : ?>
			<ul class="module09-categories__list">
				<?php foreach ($module09_categories as $module09_cat) : ?>
					<li class="module09-categories__item<?php echo in_array($module09_cat->term_id, $module09_current, true) ? ' is-current' : ''; ?>">
						<a href="<?php echo esc_url(get_category_link($module09_cat)); ?>">
							<?php echo esc_html($module09_cat->name); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<p class="module09-categories__empty">Chưa có chuyên mục.</p>
		<?php endif; ?>
	</div>
</section>
