<?php
/**
 * Post card template for Module 24.
 *
 * @package Nhom_A_TwentyTwenty_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$module24_post_id   = absint( get_the_ID() );
$module24_title     = get_the_title( $module24_post_id );
$module24_permalink = get_permalink( $module24_post_id );
$module24_image_url = module24_get_post_image_url( $module24_post_id );

if ( '' === $module24_image_url ) {
	$module24_image_url = get_stylesheet_directory_uri() . '/modules/module-24/assets/images/placeholder.svg';
}
?>

<article class="module24-card">
	<a class="module24-card-media" href="<?php echo esc_url( $module24_permalink ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Xem bài viết: %s', 'nhom-a-twentytwenty-child' ), $module24_title ) ); ?>">
		<img class="module24-card-image" src="<?php echo esc_url( $module24_image_url ); ?>" alt="<?php echo esc_attr( $module24_title ); ?>" loading="lazy" decoding="async">
	</a>

	<div class="module24-card-body">
		<h2 class="module24-card-title">
			<a class="module24-card-title-link" href="<?php echo esc_url( $module24_permalink ); ?>"><?php echo esc_html( $module24_title ); ?></a>
		</h2>
	</div>
</article>
