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
				<?php
				// ⬇️ NÚT CHIA SẺ + DROPDOWN.
				get_template_part('template-parts/share-dropdown');
				?>
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
			</article>

			<?php
			// Lấy danh sách bài viết cùng chuyên mục (trừ bài hiện tại).
			$current_id = get_the_ID();
			$categories = get_the_category();
			$cat_ids    = array();

			if (! empty($categories)) {
				foreach ($categories as $cat) {
					$cat_ids[] = $cat->term_id;
				}
			}

			// Chỉ chạy query nếu bài viết có chuyên mục.
			if (! empty($cat_ids)) :

				$related_args = array(
					'post_type'           => 'post',
					'posts_per_page'      => 8,
					'post__not_in'        => array($current_id),
					'category__in'        => $cat_ids,
					'orderby'             => 'date',
					'order'               => 'DESC',
					'no_found_rows'       => true,
					'update_post_meta_cache' => false,
					'update_post_term_cache' => false,
				);

				$related_query = new WP_Query($related_args);

				if ($related_query->have_posts()) : ?>

					<section class="gcn-related-posts" aria-label="Bài viết cùng chuyên mục">

						<h2 class="gcn-related-title">Bài viết cùng chuyên mục</h2>

						<div class="gcn-post-list">
							<?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
								<?php get_template_part('template-parts/item-list'); ?>
							<?php endwhile; ?>
						</div>

					</section>

				<?php endif; ?>
				<?php wp_reset_postdata();
				?>
			<?php endif; ?>

			<?php if (comments_open() || get_comments_number()) : ?>
				<div class="gcn-comments"><?php comments_template(); ?></div>
			<?php endif; ?>
		<?php endwhile; ?>
	</div>
</main>
<?php get_footer(); ?>