<?php

/**
 * Module 20 (tự chọn): Breadcrumb
 *
 * Trang chủ › Chuyên mục › Tên bài viết. Dữ liệu lấy từ database.
 */

if (! defined('ABSPATH')) {
	exit;
}

$module20_crumbs = array(
	array(
		'label' => 'Trang chủ',
		'url'   => home_url('/'),
	),
);

$module20_categories = get_the_category();
if ($module20_categories) {
	$module20_crumbs[] = array(
		'label' => $module20_categories[0]->name,
		'url'   => get_category_link($module20_categories[0]),
	);
}

$module20_crumbs[] = array(
	'label' => get_the_title(),
	'url'   => '',
);
?>
<nav class="module20-breadcrumb" aria-label="Breadcrumb">
	<ol class="module20-breadcrumb__list">
		<?php foreach ($module20_crumbs as $module20_crumb) : ?>
			<li class="module20-breadcrumb__item">
				<?php if ($module20_crumb['url']) : ?>
					<a href="<?php echo esc_url($module20_crumb['url']); ?>"><?php echo esc_html($module20_crumb['label']); ?></a>
				<?php else : ?>
					<span aria-current="page"><?php echo esc_html($module20_crumb['label']); ?></span>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ol>
</nav>
