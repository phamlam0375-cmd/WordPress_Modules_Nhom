<?php
/** Image helpers and styles for the homepage post list. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'nhom_a_module02_enqueue_styles' ) ) {
	function nhom_a_module02_enqueue_styles() {
		if ( is_admin() || ! is_home() ) {
			return;
		}
		$path = '/modules/module-02/module-2.css';
		wp_enqueue_style(
			'module-02-css',
			get_stylesheet_directory_uri() . $path,
			array( 'nhom-a-twentytwenty-child' ),
			(string) filemtime( __DIR__ . '/module-2.css' )
		);
	}
}
if ( false === has_action( 'wp_enqueue_scripts', 'nhom_a_module02_enqueue_styles' ) ) {
	add_action( 'wp_enqueue_scripts', 'nhom_a_module02_enqueue_styles', 40 );
}

if ( ! function_exists( 'nhom_a_module02_html_image_url' ) ) {
	/** Find a saved image URL without rendering the post content. */
	function nhom_a_module02_html_image_url( $html ) {
		$attributes = array( 'data-lazy-src', 'data-src', 'src' );
		if ( class_exists( 'WP_HTML_Tag_Processor' ) ) {
			$processor = new WP_HTML_Tag_Processor( (string) $html );
			while ( $processor->next_tag( array( 'tag_name' => 'IMG' ) ) ) {
				foreach ( $attributes as $attribute ) {
					$url = $processor->get_attribute( $attribute );
					if ( is_string( $url ) && '' !== trim( $url ) ) {
						$url = esc_url_raw( html_entity_decode( $url, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
						if ( $url ) {
							return $url;
						}
					}
				}
			}
			return '';
		}
		if ( preg_match_all( '/<img\b[^>]*>/i', (string) $html, $tags ) ) {
			foreach ( $tags[0] as $tag ) {
				foreach ( $attributes as $attribute ) {
					$pattern = '/\s' . preg_quote( $attribute, '/' ) . '\s*=\s*(?:"([^"]*)"|\'([^\']*)\'|([^\s>]+))/i';
					if ( preg_match( $pattern, $tag, $matches ) ) {
						foreach ( array_slice( $matches, 1 ) as $candidate ) {
							$url = esc_url_raw( html_entity_decode( $candidate, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
							if ( $url ) {
								return $url;
							}
						}
					}
				}
			}
		}
		return '';
	}
}

if ( ! function_exists( 'nhom_a_module02_block_image_url' ) ) {
	/** Search image blocks, including images nested in groups or galleries. */
	function nhom_a_module02_block_image_url( $blocks ) {
		foreach ( $blocks as $block ) {
			if ( 'core/image' === $block['blockName'] ) {
				$id  = isset( $block['attrs']['id'] ) ? absint( $block['attrs']['id'] ) : 0;
				$url = $id ? wp_get_attachment_image_url( $id, 'medium_large' ) : '';
				if ( ! $url && ! empty( $block['attrs']['url'] ) ) {
					$url = esc_url_raw( $block['attrs']['url'] );
				}
				if ( ! $url ) {
					$url = nhom_a_module02_html_image_url( $block['innerHTML'] );
				}
				if ( $url ) {
					return $url;
				}
			}
			$url = nhom_a_module02_block_image_url( $block['innerBlocks'] );
			if ( $url ) {
				return $url;
			}
		}
		return '';
	}
}

if ( ! function_exists( 'nhom_a_module02_post_image_url' ) ) {
	/** Prefer a featured image, then an image already saved in the content. */
	function nhom_a_module02_post_image_url( $post_id ) {
		$post_id = absint( $post_id );
		$url = wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'medium_large' );
		if ( $url ) {
			return $url;
		}
		$content = (string) get_post_field( 'post_content', $post_id, 'raw' );
		$url = nhom_a_module02_block_image_url( parse_blocks( $content ) );
		return $url ? $url : nhom_a_module02_html_image_url( $content );
	}
}
