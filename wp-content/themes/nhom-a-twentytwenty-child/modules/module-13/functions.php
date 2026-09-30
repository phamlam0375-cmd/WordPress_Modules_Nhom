<?php
/**
 * Module 13: Compact copies of the current main search results.
 *
 * @package Nhom_A_TwentyTwenty_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'nhom_a_module13_get_main_search_posts' ) ) {
	/**
	 * Read the posts already selected by the current main search query.
	 *
	 * This function does not run a query or change the main loop pointer.
	 *
	 * @return WP_Post[]
	 */
	function nhom_a_module13_get_main_search_posts() {
		global $wp_query;

		if ( ! is_search() || ! $wp_query instanceof WP_Query || ! $wp_query->is_search() ) {
			return array();
		}

		$search_posts = array();

		foreach ( (array) $wp_query->posts as $search_post ) {
			if ( $search_post instanceof WP_Post ) {
				$search_posts[] = $search_post;
			}
		}

		return $search_posts;
	}
}

if ( ! function_exists( 'nhom_a_module13_get_search_excerpt' ) ) {
	/**
	 * Build a short plain-text description without rendering shortcodes.
	 *
	 * @param WP_Post $search_post Search-result post.
	 * @return string
	 */
	function nhom_a_module13_get_search_excerpt( $search_post ) {
		if ( ! $search_post instanceof WP_Post ) {
			return '';
		}

		$summary_source = trim( (string) $search_post->post_excerpt );

		if ( '' === $summary_source ) {
			$summary_source = (string) $search_post->post_content;
		}

		$summary_source = strip_shortcodes( $summary_source );
		$summary_source = preg_replace( '/\[[^\]]*\]/u', '', $summary_source );
		$summary_source = is_string( $summary_source ) ? $summary_source : '';

		return wp_trim_words( wp_strip_all_tags( $summary_source ), 20, '…' );
	}
}

if ( ! function_exists( 'nhom_a_module13_render_search_cards' ) ) {
	/**
	 * Render a compact view of the current page of main search results.
	 *
	 * @return string
	 */
	function nhom_a_module13_render_search_cards() {
		$module13_posts = nhom_a_module13_get_main_search_posts();
		$template       = get_stylesheet_directory() . '/modules/module-13/templates/search-column.php';

		if ( empty( $module13_posts ) || ! is_readable( $template ) ) {
			return '';
		}

		ob_start();
		require $template;

		return (string) ob_get_clean();
	}
}

if ( ! function_exists( 'nhom_a_module13_render_search_left_column' ) ) {
	/** Render Module 13 in the search-results left column only. */
	function nhom_a_module13_render_search_left_column() {
		if ( is_admin() || ! is_search() ) {
			return;
		}

		echo wp_kses_post( nhom_a_module13_render_search_cards() );
	}
}

if ( false === has_action( 'nhom_a_search_left_column', 'nhom_a_module13_render_search_left_column' ) ) {
	add_action( 'nhom_a_search_left_column', 'nhom_a_module13_render_search_left_column' );
}

if ( ! function_exists( 'nhom_a_module13_enqueue_search_assets' ) ) {
	/** Enqueue Module 13 CSS on search-result requests only. */
	function nhom_a_module13_enqueue_search_assets() {
		if ( is_admin() || ! is_search() ) {
			return;
		}

		$relative_path = '/modules/module-13/assets/css/search-column.css';
		$css_path      = get_stylesheet_directory() . $relative_path;
		$version       = is_readable( $css_path ) ? (string) filemtime( $css_path ) : '1.0.0';

		wp_enqueue_style(
			'nhom-a-module13-search-column',
			get_stylesheet_directory_uri() . $relative_path,
			array( 'gcn-search-detail' ),
			$version
		);
	}
}

if ( false === has_action( 'wp_enqueue_scripts', 'nhom_a_module13_enqueue_search_assets' ) ) {
	add_action( 'wp_enqueue_scripts', 'nhom_a_module13_enqueue_search_assets', 35 );
}
