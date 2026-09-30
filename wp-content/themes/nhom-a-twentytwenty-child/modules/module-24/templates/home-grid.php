<?php
/**
 * Main posts page grid template for Module 24.
 *
 * @package Nhom_A_TwentyTwenty_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="site-content" class="module24-home" role="main">
	<section class="module24-home-section" aria-label="<?php echo esc_attr__( 'Danh sách bài viết', 'nhom-a-twentytwenty-child' ); ?>">
		<div class="module24-container">
			<?php if ( have_posts() ) : ?>
				<div class="module24-grid">
					<?php
					while ( have_posts() ) :
						the_post();

						$module24_card_template = __DIR__ . '/post-card.php';

						if ( is_readable( $module24_card_template ) ) {
							require $module24_card_template;
						}
					endwhile;
					?>
				</div>

				<?php
				$module24_pagination = get_the_posts_pagination(
					array(
						'mid_size'  => 1,
						'prev_text' => esc_html__( 'Bài mới hơn', 'nhom-a-twentytwenty-child' ),
						'next_text' => esc_html__( 'Bài cũ hơn', 'nhom-a-twentytwenty-child' ),
					)
				);
				?>

				<?php if ( $module24_pagination ) : ?>
					<div class="module24-pagination">
						<?php echo wp_kses_post( $module24_pagination ); ?>
					</div>
				<?php endif; ?>
			<?php else : ?>
				<p class="module24-empty"><?php esc_html_e( 'Chưa có bài viết nào.', 'nhom-a-twentytwenty-child' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php
get_template_part( 'template-parts/footer-menus-widgets' );
get_footer();
