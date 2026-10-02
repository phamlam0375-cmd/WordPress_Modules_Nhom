<?php

/**
 * Module 15: Last posts
 * Tham khảo: https://bootsnipp.com/snippets/xrKXW
 *
 * Dạng timeline: đường kẻ dọc + vòng tròn, tiêu đề (trái) - ngày đăng (phải),
 * đoạn trích ngắn bên dưới.
 */

if (! defined('ABSPATH')) {
	exit;
}

$module15_query = new WP_Query(array(
	'post_type'           => 'post',
	'posts_per_page'      => 3,
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
));

if (! $module15_query->have_posts()) {
	return;
}
?>
<section class="module15-last-posts">
	<h2 class="module15-last-posts__title">Latest News</h2>

	<ul class="module15-last-posts__timeline">
		<?php while ($module15_query->have_posts()) : $module15_query->the_post(); ?>
			<li class="module15-last-posts__item">
				<div class="module15-last-posts__head">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('j F, Y')); ?></time>
				</div>
				<p class="module15-last-posts__excerpt"><?php echo esc_html(wp_trim_words(wp_strip_all_tags(get_the_excerpt()), 30, '...')); ?></p>
			</li>
		<?php endwhile; ?>
	</ul>
	<?php wp_reset_postdata(); ?>
</section>
