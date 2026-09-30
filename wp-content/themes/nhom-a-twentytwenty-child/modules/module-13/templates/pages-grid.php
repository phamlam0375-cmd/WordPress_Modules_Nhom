<?php
/**
 * Template danh sách Trang dạng card.
 *
 * Các biến được cung cấp bởi nhom_a_module13_render_pages_cards().
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section
	class="module13-pages"
	<?php if ( '' !== $module13_title ) : ?>
		aria-labelledby="<?php echo esc_attr( $module13_heading_id ); ?>"
	<?php else : ?>
		aria-label="<?php echo esc_attr__( 'Pages', 'nhom-a-twentytwenty-child' ); ?>"
	<?php endif; ?>
>
	<?php if ( '' !== $module13_title ) : ?>
		<h2 id="<?php echo esc_attr( $module13_heading_id ); ?>" class="module13-title"><?php echo esc_html( $module13_title ); ?></h2>
	<?php endif; ?>

	<?php if ( $module13_query->have_posts() ) : ?>
		<div class="module13-grid">
			<?php while ( $module13_query->have_posts() ) : ?>
				<?php
				$module13_query->the_post();
				$page_id         = absint( get_the_ID() );
				$page_title      = get_the_title( $page_id );
				$page_url        = get_permalink( $page_id );
				$manual_excerpt  = trim( (string) get_post_field( 'post_excerpt', $page_id ) );

				if ( '' !== $manual_excerpt ) {
					$page_summary = wp_trim_words( wp_strip_all_tags( strip_shortcodes( get_the_excerpt( $page_id ) ) ), 20, '…' );
				} else {
					$page_content = strip_shortcodes( (string) get_post_field( 'post_content', $page_id ) );
					$page_summary = wp_trim_words( wp_strip_all_tags( $page_content ), 20, '…' );
				}
				?>
				<article class="module13-card">
					<a class="module13-media-link" href="<?php echo esc_url( $page_url ); ?>" aria-label="<?php echo esc_attr( $page_title ); ?>">
						<?php if ( has_post_thumbnail( $page_id ) ) : ?>
							<?php
							echo wp_kses_post(
								get_the_post_thumbnail(
									$page_id,
									'medium_large',
									array(
										'alt'     => $page_title,
										'class'   => 'module13-card-image',
										'loading' => 'lazy',
									)
								)
							);
							?>
						<?php else : ?>
							<span class="module13-image-placeholder"><?php esc_html_e( 'Chưa có ảnh', 'nhom-a-twentytwenty-child' ); ?></span>
						<?php endif; ?>
					</a>
					<div class="module13-card-body">
						<h3 class="module13-card-title">
							<a href="<?php echo esc_url( $page_url ); ?>"><?php echo esc_html( $page_title ); ?></a>
						</h3>
						<?php if ( '' !== $page_summary ) : ?>
							<p class="module13-card-summary"><?php echo esc_html( $page_summary ); ?></p>
						<?php endif; ?>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
	<?php else : ?>
		<p class="module13-empty-message"><?php esc_html_e( 'Chưa có Trang nào để hiển thị.', 'nhom-a-twentytwenty-child' ); ?></p>
	<?php endif; ?>
</section>
