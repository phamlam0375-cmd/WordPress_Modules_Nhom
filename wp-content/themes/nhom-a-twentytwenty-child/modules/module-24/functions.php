<?php
/**
 * Module 24 – Home Posts Grid.
 *
 * @package Nhom_A_TwentyTwenty_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'module24_is_home_request' ) ) {
	/**
	 * Determine whether Module 24 should run for the current request.
	 *
	 * @return bool
	 */
	function module24_is_home_request() {
		$is_rest_request = defined( 'REST_REQUEST' ) && REST_REQUEST;
		$is_json_request = function_exists( 'wp_is_json_request' ) && wp_is_json_request();

		return is_home()
			&& ! is_admin()
			&& ! wp_doing_ajax()
			&& ! is_feed()
			&& ! $is_rest_request
			&& ! $is_json_request;
	}
}

if ( ! function_exists( 'module24_home_template' ) ) {
	/**
	 * Use the module template on the main posts page only.
	 *
	 * @param string $template Template selected by WordPress.
	 * @return string
	 */
	function module24_home_template( $template ) {
		if ( ! module24_is_home_request() ) {
			return $template;
		}

		$module_template = __DIR__ . '/templates/home-grid.php';

		return is_readable( $module_template ) ? $module_template : $template;
	}
}

if ( ! has_filter( 'template_include', 'module24_home_template' ) ) {
	add_filter( 'template_include', 'module24_home_template', 99 );
}

if ( ! function_exists( 'module24_enqueue_home_grid_styles' ) ) {
	/**
	 * Enqueue the module stylesheet on the main posts page.
	 *
	 * @return void
	 */
	function module24_enqueue_home_grid_styles() {
		if ( ! module24_is_home_request() ) {
			return;
		}

		$relative_path = '/modules/module-24/assets/css/home-grid.css';
		$file_path     = get_stylesheet_directory() . $relative_path;
		$file_version  = is_readable( $file_path ) ? (string) filemtime( $file_path ) : null;

		wp_enqueue_style(
			'module24-home-grid',
			get_stylesheet_directory_uri() . $relative_path,
			array( 'nhom-a-twentytwenty-child' ),
			$file_version
		);
	}
}

if ( ! has_action( 'wp_enqueue_scripts', 'module24_enqueue_home_grid_styles' ) ) {
	add_action( 'wp_enqueue_scripts', 'module24_enqueue_home_grid_styles', 45 );
}

if ( ! function_exists( 'module24_normalize_image_url' ) ) {
	/**
	 * Decode and sanitize an image URL without assuming a domain or port.
	 *
	 * @param mixed $url Candidate image URL.
	 * @return string
	 */
	function module24_normalize_image_url( $url ) {
		if ( ! is_string( $url ) && ! is_numeric( $url ) ) {
			return '';
		}

		$url = html_entity_decode(
			trim( (string) $url ),
			ENT_QUOTES | ENT_HTML5,
			get_bloginfo( 'charset' )
		);

		return esc_url_raw( $url );
	}
}

if ( ! function_exists( 'module24_get_image_url_from_html' ) ) {
	/**
	 * Find the first usable image URL in an HTML fragment.
	 *
	 * Lazy-load attributes are checked before src because src may contain a
	 * temporary placeholder while the real image is stored in a data attribute.
	 *
	 * @param string $html HTML to inspect.
	 * @return string
	 */
	function module24_get_image_url_from_html( $html ) {
		$html       = (string) $html;
		$attributes = array( 'data-lazy-src', 'data-src', 'src' );

		if ( '' === $html ) {
			return '';
		}

		if ( class_exists( 'WP_HTML_Tag_Processor' ) ) {
			$processor = new WP_HTML_Tag_Processor( $html );

			while ( $processor->next_tag( array( 'tag_name' => 'IMG' ) ) ) {
				foreach ( $attributes as $attribute ) {
					$image_url = module24_normalize_image_url( $processor->get_attribute( $attribute ) );

					if ( '' !== $image_url ) {
						return $image_url;
					}
				}
			}
		}

		if ( ! preg_match_all( '/<img\b[^>]*>/i', $html, $image_tags ) ) {
			return '';
		}

		foreach ( $image_tags[0] as $image_tag ) {
			foreach ( $attributes as $attribute ) {
				$attribute_pattern = '/\s' . preg_quote( $attribute, '/' ) . '\s*=\s*(?:"([^"]*)"|\'([^\']*)\'|([^\s>]+))/i';

				if ( ! preg_match( $attribute_pattern, $image_tag, $attribute_match ) ) {
					continue;
				}

				$candidate_url = '';

				for ( $match_index = 1; $match_index <= 3; $match_index++ ) {
					if ( isset( $attribute_match[ $match_index ] ) && '' !== $attribute_match[ $match_index ] ) {
						$candidate_url = $attribute_match[ $match_index ];
						break;
					}
				}

				$image_url = module24_normalize_image_url( $candidate_url );

				if ( '' !== $image_url ) {
					return $image_url;
				}
			}
		}

		return '';
	}
}

if ( ! function_exists( 'module24_get_image_url_from_blocks' ) ) {
	/**
	 * Recursively find the first image represented by a core/image block.
	 *
	 * @param array $blocks Parsed blocks.
	 * @return string
	 */
	function module24_get_image_url_from_blocks( $blocks ) {
		if ( ! is_array( $blocks ) ) {
			return '';
		}

		foreach ( $blocks as $block ) {
			if ( ! is_array( $block ) ) {
				continue;
			}

			$block_name = isset( $block['blockName'] ) ? (string) $block['blockName'] : '';
			$attributes = isset( $block['attrs'] ) && is_array( $block['attrs'] ) ? $block['attrs'] : array();

			if ( 'core/image' === $block_name ) {
				$attachment_id = isset( $attributes['id'] ) ? absint( $attributes['id'] ) : 0;

				if ( $attachment_id ) {
					$image_url = module24_normalize_image_url(
						wp_get_attachment_image_url( $attachment_id, 'medium_large' )
					);

					if ( '' !== $image_url ) {
						return $image_url;
					}
				}

				foreach ( array( 'url', 'src' ) as $url_attribute ) {
					if ( ! isset( $attributes[ $url_attribute ] ) ) {
						continue;
					}

					$image_url = module24_normalize_image_url( $attributes[ $url_attribute ] );

					if ( '' !== $image_url ) {
						return $image_url;
					}
				}

				$image_url = module24_get_image_url_from_html(
					isset( $block['innerHTML'] ) ? $block['innerHTML'] : ''
				);

				if ( '' !== $image_url ) {
					return $image_url;
				}
			}

			$inner_blocks = isset( $block['innerBlocks'] ) ? $block['innerBlocks'] : array();
			$image_url   = module24_get_image_url_from_blocks( $inner_blocks );

			if ( '' !== $image_url ) {
				return $image_url;
			}
		}

		return '';
	}
}

if ( ! function_exists( 'module24_get_post_image_url' ) ) {
	/**
	 * Get a post image using the module's ordered fallback rules.
	 *
	 * @param int $post_id Post ID.
	 * @return string
	 */
	function module24_get_post_image_url( $post_id ) {
		$post_id = absint( $post_id );

		if ( ! $post_id ) {
			return '';
		}

		$thumbnail_id = absint( get_post_thumbnail_id( $post_id ) );

		if ( $thumbnail_id ) {
			$image_url = module24_normalize_image_url(
				wp_get_attachment_image_url( $thumbnail_id, 'medium_large' )
			);

			if ( '' !== $image_url ) {
				return $image_url;
			}
		}

		$content = (string) get_post_field( 'post_content', $post_id, 'raw' );

		if ( '' !== $content && function_exists( 'parse_blocks' ) ) {
			$image_url = module24_get_image_url_from_blocks( parse_blocks( $content ) );

			if ( '' !== $image_url ) {
				return $image_url;
			}
		}

		$image_url = module24_get_image_url_from_html( $content );

		if ( '' !== $image_url ) {
			return $image_url;
		}

		$attached_images = get_attached_media( 'image', $post_id );

		if ( is_array( $attached_images ) ) {
			foreach ( $attached_images as $attached_image ) {
				$attachment_id = $attached_image instanceof WP_Post ? $attached_image->ID : 0;
				$image_url     = module24_normalize_image_url(
					wp_get_attachment_image_url( absint( $attachment_id ), 'medium_large' )
				);

				if ( '' !== $image_url ) {
					return $image_url;
				}
			}
		}

		return '';
	}
}
