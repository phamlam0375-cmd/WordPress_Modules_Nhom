<?php
/**
 * Compact view of the posts already present in the main search query.
 *
 * @package Nhom_A_TwentyTwenty_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="module13-search-results" aria-label="<?php echo esc_attr__( 'Kết quả tìm kiếm thu gọn', 'nhom-a-twentytwenty-child' ); ?>">
	<div class="module13-search-list">
		<?php foreach ( $module13_posts as $module13_post ) : ?>
			<?php
			$module13_post_id   = absint( $module13_post->ID );
			$module13_title     = get_the_title( $module13_post_id );
			$module13_permalink = get_permalink( $module13_post_id );
			$module13_excerpt   = nhom_a_module13_get_search_excerpt( $module13_post );
			$module13_thumbnail = get_the_post_thumbnail(
				$module13_post_id,
				'medium_large',
				array(
					'alt'      => $module13_title,
					'class'    => 'module13-search-image',
					'decoding' => 'async',
					'loading'  => 'lazy',
				)
			);
			?>

			<article class="module13-search-card" data-post-id="<?php echo esc_attr( (string) $module13_post_id ); ?>">
				<a class="module13-search-link" href="<?php echo esc_url( $module13_permalink ); ?>">
					<span class="module13-search-media">
						<?php if ( $module13_thumbnail ) : ?>
							<?php echo wp_kses_post( $module13_thumbnail ); ?>
						<?php else : ?>
							<img
								class="module13-search-image"
								src="<?php echo esc_url( get_stylesheet_directory_uri() . '/modules/module-13/assets/images/placeholder.svg' ); ?>"
								alt="<?php echo esc_attr__( 'Chưa có ảnh', 'nhom-a-twentytwenty-child' ); ?>"
								loading="lazy"
								decoding="async"
							>
						<?php endif; ?>
					</span>

					<span class="module13-search-content">
						<span class="module13-search-title"><?php echo esc_html( $module13_title ); ?></span>
						<?php if ( '' !== $module13_excerpt ) : ?>
							<span class="module13-search-excerpt"><?php echo esc_html( $module13_excerpt ); ?></span>
						<?php endif; ?>
					</span>
				</a>
			</article>
		<?php endforeach; ?>
	</div>
</section>
