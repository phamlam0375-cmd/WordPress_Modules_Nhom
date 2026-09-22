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
			$next_post = get_previous_post();
			$prev_post = get_next_post();
			?>

			<?php if ($prev_post || $next_post) : ?>
				<nav class="gcn-post-navigation" aria-label="Điều hướng bài viết">

					<?php if ($prev_post) : ?>
						<a class="gcn-nav-prev" href="<?php echo esc_url(get_permalink($prev_post)); ?>">
							<span class="gcn-nav-label">← Previous post</span>
							<span class="gcn-nav-title"><?php echo esc_html(get_the_title($prev_post)); ?></span>
						</a>
					<?php endif; ?>

					<?php if ($next_post) : ?>
						<a class="gcn-nav-next" href="<?php echo esc_url(get_permalink($next_post)); ?>">
							<span class="gcn-nav-label">Next post →</span>
							<span class="gcn-nav-title"><?php echo esc_html(get_the_title($next_post)); ?></span>
						</a>
					<?php endif; ?>

				</nav>
			<?php endif; ?>

			<?php if (comments_open() || get_comments_number()) : ?>
				<div class="gcn-comments"><?php comments_template(); ?></div>
			<?php endif; ?>
		<?php endwhile; ?>
	</div>
</main>
<?php get_footer(); ?>