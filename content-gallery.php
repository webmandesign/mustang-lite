<?php
/**
 * Gallery post format content
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Post Formats
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.1.1
 */



$is_single         = ( is_home() && apply_filters( 'wmhook_enable_blog_full_posts', false ) ) ? ( true ) : ( is_single() );
$pagination_suffix = wm_paginated_suffix( 'small', 'post' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); echo wm_schema_org( 'article' ); ?>>

	<div class="post-media">
		<?php
		/**
		 * Post media
		 */
		$image_size = apply_filters( 'wmhook_post_thumbnail_image_size', wm_option( 'skin-image-blog' ) );
		if ( ! $image_size ) {
			$image_size = WM_DEFAULT_IMAGE_SIZE;
		}

		if ( ! $is_single ) {
		//Is gallery? Display slideshow in posts list...

			$media_shortcode = array( false, '' ); //the first value determines whether gallery shortcode appears in post, second one if image IDs set
			$content         = get_the_content();

			//Search for the shortcode
				$pattern = '/\[gallery(.*)\]/';
				preg_match( $pattern, strip_tags( $content ), $matches );
				if ( isset( $matches[1] ) ) {
					//Get [gallery] shortcode parameters only
						$media_shortcode = array( true, trim( $matches[1] ) );
				}

				//Get the image IDs from shortcode attribute into an array
					if ( false !== strpos( $media_shortcode[1], 'ids="' ) ) {
						preg_match( '/ids="(.+?)"/', $media_shortcode[1], $matches );
						$media_shortcode[1] = explode( ',', preg_replace( '/\s+/', '', str_replace( array( 'ids="', '"' ), '', $matches[0] ) ) );
					}

			if ( $media_shortcode[0] && function_exists( 'wma_amplifier' ) ) {
				$images = array();

				if ( is_array( $media_shortcode[1] ) ) {
					$images = $media_shortcode[1];
				} else {
					$posts_images = wm_get_post_images();
					foreach ( $posts_images as $image ) {
						$images[] = $image['id'];
					}
				}

				if ( is_array( $images ) && ! empty( $images ) ) {
					echo do_shortcode( apply_filters( 'wmhook_post_format_gallery_slideshow_shortcode', '[wm_slideshow ids="' . implode( ',', $images ) . '" nav="pagination" size="' . $image_size . '" speed="4000" /]' ) );
				}
			}

		}

		//If no gallery, display featured image (also, always display featured image on single post page)
			if (
					$is_single
					&& ! apply_filters( 'wmhook_disable_single_featured_image', false )
					&& ! ( function_exists( 'wma_meta_option' ) && wma_meta_option( 'disable-featured-image' ) )
					&& ! $pagination_suffix
				) {
				echo wm_thumb( array(
						'attr-link' => wm_schema_org( 'image' ),
						'class'     => 'image-container post-thumbnail scale-rotate',
						'link'      => 'bigimage',
						'size'      => 'content-width',
					) );
			} elseif (
					! $is_single
					&& ( ! $media_shortcode[0] || ! function_exists( 'wma_amplifier' ) )
				) {
				echo wm_thumb( array(
						'attr-link' => wm_schema_org( 'image' ),
						'class'     => 'image-container post-thumbnail scale-rotate',
						'link'      => get_permalink(),
						'size'      => $image_size,
					) );
			}
		?>
	</div>

	<?php
	/**
	 * Post title
	 */

		wm_post_title();



	/**
	 * Post content
	 */
	if ( $is_single ) {

		//Outputs full post content including excerpt at the top
			wmhook_entry_top();

			if (
					has_excerpt()
					&& ! $pagination_suffix
					&& ! wm_option( 'blog-disable-single-post-excerpt' )
				) {
				echo wm_excerpt();
			}

			the_content();

			wmhook_entry_bottom();

	} else {

		//Outputs excerpt or content until <!--more--> tag
			echo wm_content_or_excerpt( $post );

	}
	?>

</article>