<?php

/**
 * Module 25 (tự chọn): Thống kê website
 *
 * 4 ô số liệu lấy từ database: bài viết, chuyên mục, bình luận, thẻ
 * + ngày cập nhật bài mới nhất. Icon dùng Font Awesome đã được theme nạp sẵn.
 */

if (! defined('ABSPATH')) {
	exit;
}

$module25_stats = array(
	array(
		'icon'  => 'fa-solid fa-newspaper',
		'value' => wp_count_posts('post')->publish,
		'label' => 'Bài viết',
	),
	array(
		'icon'  => 'fa-solid fa-folder-open',
		'value' => wp_count_terms(array('taxonomy' => 'category')),
		'label' => 'Chuyên mục',
	),
	array(
		'icon'  => 'fa-solid fa-comments',
		'value' => wp_count_comments()->approved,
		'label' => 'Bình luận',
	),
	array(
		'icon'  => 'fa-solid fa-tags',
		'value' => wp_count_terms(array('taxonomy' => 'post_tag')),
		'label' => 'Thẻ',
	),
);

$module25_latest = get_posts(array(
	'numberposts' => 1,
	'post_type'   => 'post',
));
?>
<section class="module25-stats" id="module25-stats">
	<h2 class="module25-stats__title">Thống kê website</h2>

	<ul class="module25-stats__grid">
		<?php foreach ($module25_stats as $module25_stat) : ?>
			<li class="module25-stats__item">
				<i class="module25-stats__icon <?php echo esc_attr($module25_stat['icon']); ?>" aria-hidden="true"></i>
				<strong class="module25-stats__value"><?php echo esc_html(number_format_i18n((int) $module25_stat['value'])); ?></strong>
				<span class="module25-stats__label"><?php echo esc_html($module25_stat['label']); ?></span>
			</li>
		<?php endforeach; ?>
	</ul>

	<?php if ($module25_latest) : ?>
		<p class="module25-stats__updated">
			Cập nhật lần cuối: <?php echo esc_html(get_the_date('d/m/Y', $module25_latest[0])); ?>
			– <a href="<?php echo esc_url(get_permalink($module25_latest[0])); ?>"><?php echo esc_html(get_the_title($module25_latest[0])); ?></a>
		</p>
	<?php endif; ?>
</section>
