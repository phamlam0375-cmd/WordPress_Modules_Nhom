<?php

/**
 * Module 23 (tự chọn): Tags - Đám mây thẻ
 *
 * 20 thẻ được dùng nhiều nhất, kèm số bài viết. Thẻ có nhiều bài hơn thì đậm màu hơn.
 */

if (! defined('ABSPATH')) {
	exit;
}

$module23_tags = get_tags(array(
	'orderby'    => 'count',
	'order'      => 'DESC',
	'number'     => 20,
	'hide_empty' => true,
));

if (! $module23_tags) {
	return;
}

$module23_max = max(wp_list_pluck($module23_tags, 'count'));

// Lấy theo số bài nhiều nhất, sau đó xếp lại theo tên cho dễ tìm.
usort($module23_tags, function ($a, $b) {
	return strcasecmp($a->name, $b->name);
});
?>
<section class="module23-tags">
	<h2 class="module23-tags__title">Tags</h2>

	<ul class="module23-tags__list">
		<?php foreach ($module23_tags as $module23_tag) : ?>
			<?php $module23_level = (int) ceil(3 * $module23_tag->count / $module23_max); // Mức độ 1-3. ?>
			<li>
				<a class="module23-tags__item module23-tags__item--<?php echo esc_attr($module23_level); ?>" href="<?php echo esc_url(get_tag_link($module23_tag)); ?>">
					#<?php echo esc_html($module23_tag->name); ?>
					<span class="module23-tags__count"><?php echo esc_html($module23_tag->count); ?></span>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
