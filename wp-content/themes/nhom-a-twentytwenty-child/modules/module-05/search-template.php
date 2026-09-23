<?php
/** Trang kết quả tìm kiếm: ảnh - ngày - tiêu đề - tóm tắt. */
get_header();
?>
<main id="site-content" class="gcn-search" role="main">
	<div class="gcn-wrap">
		<header class="gcn-search-header">
			<h1>Kết quả tìm kiếm cho “<?php echo esc_html( get_search_query( false ) ); ?>”</h1>
			<p>Chọn một bài viết để xem nội dung đầy đủ.</p>
			<?php get_search_form(); ?>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="gcn-results">
				<?php while ( have_posts() ) : the_post(); ?>
					<article <?php post_class( 'gcn-result-card' ); ?> id="post-<?php the_ID(); ?>">
						<a class="gcn-result-image" href="<?php echo esc_url( get_permalink() ); ?>" aria-label="Xem bài: <?php echo esc_attr( get_the_title() ); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'medium', array( 'loading' => 'lazy' ) ); ?>
							<?php else : ?>
								<span class="gcn-image-placeholder">Góc Công Nghệ</span>
							<?php endif; ?>
						</a>
						<div class="gcn-result-date">
							<time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>">
								<strong><?php echo esc_html( get_the_date( 'd' ) ); ?></strong>
								<span>THÁNG <?php echo esc_html( get_the_date( 'm' ) ); ?><br><?php echo esc_html( get_the_date( 'Y' ) ); ?></span>
							</time>
						</div>
						<div class="gcn-result-text">
							<h2><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a></h2>
							<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 28, '…' ) ); ?></p>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination( array( 'prev_text' => '← Trang trước', 'next_text' => 'Trang sau →' ) ); ?>
		<?php else : ?>
			<p class="gcn-no-results">Không tìm thấy bài viết phù hợp. Hãy thử từ khóa khác.</p>
		<?php endif; ?>
	</div>
</main>
<?php get_footer(); ?>
