<?php
/**
 * Admin Functions
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Admin Functions
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @since    3.0
 * @version  1.5
 *
 * CONTENT:
 * - 1) Required files
 * - 10) Actions and filters
 * - 20) Styles and scripts
 * - 30) Admin login
 * - 40) Admin dashboard customization
 * - 50) Visual editor improvements
 * - 60) Other functions
 */





/**
 * 1) Required files
 */

	//Widgets areas
		if (
				file_exists( WM_SETUP . 'widgets.php' )
				|| file_exists( WM_SETUP_CHILD . 'widgets.php' )
			) {
			locate_template( WM_SETUP_DIR . 'widgets.php', true );
		}

	//Load the theme introduction page
		if (
				is_admin()
				&& (
					file_exists( WM_SETUP . 'about/about.php' )
					|| file_exists( WM_SETUP_CHILD . 'about/about.php' )
				)
			) {
			locate_template( WM_SETUP_DIR . 'about/about.php', true );
		}

	//Skinning functionality
		if ( function_exists( 'wma_amplifier' ) ) {
			locate_template( WM_LIBRARY_DIR . 'skinning.php', true );
		}

	//Theme updater
		if (
				is_admin()
				&& ! ( wm_option( 'general-disable-update-notifier' ) || apply_filters( 'wmhook_disable_update_notifier', false ) )
			) {
			locate_template( WM_LIBRARY_DIR . 'updater/update-notifier.php', true );
		}





/**
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		//Admin customization
			add_action( 'admin_head', 'wm_admin_head' );
			add_action( 'admin_enqueue_scripts', 'wm_admin_include', 998 );
		//Disable comments
			if (
					is_admin()
					&& ( wm_option( 'general-comments' ) || apply_filters( 'wmhook_admin_comments', '' ) )
				) {
				add_action ( 'admin_footer', 'wm_comments_off' );
			}
		//Display admin notice
			add_action( 'admin_notices', 'wm_admin_notice' );
		//Posts list table
			//Posts
				add_action( 'manage_post_posts_columns',       'wm_post_columns_register', 10    );
				add_action( 'manage_post_posts_custom_column', 'wm_post_columns_render',   10, 2 );
			//Pages
				add_action( 'manage_pages_columns',            'wm_post_columns_register', 10    );
				add_action( 'manage_pages_custom_column',      'wm_post_columns_render',   10, 2 );



	/**
	 * Filters
	 */

		//TinyMCE customization
			if ( is_admin() ) {
				add_filter( 'tiny_mce_before_init', 'wm_custom_mce_format' );
				add_filter( 'mce_buttons', 'wm_add_buttons_row1' );
			}
		//Login customization
			add_filter( 'login_headertitle', 'wm_login_headertitle' );
			add_filter( 'login_headerurl', 'wm_login_headerurl' );
		//Admin customization
			add_filter( 'admin_footer_text', 'wm_admin_footer' );
		//User profile
			add_filter( 'user_contactmethods', 'wm_user_contact_methods' );





/**
 * 20) Styles and scripts
 */

	/**
	 * Admin assets
	 */
	if ( ! function_exists( 'wm_admin_include' ) ) {
		function wm_admin_include() {
			//Styles
				wp_enqueue_style( 'wm-admin' );

				//RTL languages support
					if ( is_rtl() ) {
						wp_enqueue_style( 'wm-admin-rtl' );
						if ( class_exists( 'Woocommerce' ) ) {
							wp_enqueue_style( 'wm-admin-wc-rtl' );
						}
					}

			//Scripts
				wp_enqueue_script( 'wm-wp-admin' );
		}
	} // /wm_admin_include





/**
 * 30) Admin login
 */

	/**
	 * Login logo title
	 */
	if ( ! function_exists( 'wm_login_headertitle' ) ) {
		function wm_login_headertitle() {
			return apply_filters( 'wmhook_wm_login_headertitle_output', get_bloginfo( 'name' ) );
		}
	} // /wm_login_headertitle



	/**
	 * Login logo URL
	 */
	if ( ! function_exists( 'wm_login_headerurl' ) ) {
		function wm_login_headerurl() {
			return apply_filters( 'wmhook_wm_login_headerurl_output', home_url() );
		}
	} // /wm_login_headerurl





/**
 * 40) Admin dashboard customization
 */

	/**
	 * Admin footer text customization
	 */
	if ( ! function_exists( 'wm_admin_footer' ) ) {
		function wm_admin_footer() {
			//Helper variables
				$output = '&copy; ' . get_bloginfo( 'name' ) . ' | Powered by <a href="http://wordpress.org/" target="_blank">WordPress</a> | Theme created by <a href="' . WM_DEVELOPER_URL . '" target="_blank">WebMan</a>';

			//Output
				echo apply_filters( 'wmhook_wm_admin_footer_output', $output );
		}
	} // /wm_admin_footer



	/**
	 * Admin HTML head
	 *
	 * @since    1.0
	 * @version  1.5
	 */
	if ( ! function_exists( 'wm_admin_head' ) ) {
		function wm_admin_head() {
			//Helper variables
				global $current_screen;

				$output     = '';
				$no_preview = apply_filters( 'wmhook_wm_admin_head_no_preview',  array( 'wm_logos', 'wm_modules', 'wm_staff' ) );

			//Preparing output
				//Removing unnecessary view buttons
					if ( in_array( $current_screen->post_type, $no_preview ) ) {
						$output .= "\r\n" . '.row-actions .view, #view-post-btn, #preview-action {display: none}';
					}

			//Output
				if ( $output ) {
					echo apply_filters( 'wmhook_wm_admin_head_output', '<style type="text/css">' . "\r\n" . $output . '</style>' . "\r\n" );
				}
		}
	} // /wm_admin_head



	/**
	 * Admin post list columns
	 *
	 * @since    1.0
	 * @version  1.5
	 *
	 * @param  array $columns
	 */
	if ( ! function_exists( 'wm_post_columns_register' ) ) {
		function wm_post_columns_register( $columns ) {
			//Helper variables
				$add                = array_slice( $columns, 0, 2 );
				$add['wmamp-thumb'] = __( 'Image', 'wm_domain' );

			//Output
				return apply_filters( 'wmhook_wm_post_columns_register_output', array_merge( $add, array_slice( $columns, 2 ) ) );
		}
	} // /wm_post_columns_register



	/**
	 * Admin post list columns content
	 *
	 * @since    1.0
	 * @version  1.5
	 *
	 * @param  string $column
	 * @param  absint $post_id
	 */
	if ( ! function_exists( 'wm_post_columns_render' ) ) {
		function wm_post_columns_render( $column, $post_id ) {
			//Thumbnail renderer
				if ( 'wmamp-thumb' === $column ) {

					$size  = ( class_exists( 'WM_Amplifier' ) ) ? ( apply_filters( 'wmhook_wmamp_' . 'cp_admin_thumb_size', 'admin-thumbnail' ) ) : ( 'thumbnail' );
					$image = ( has_post_thumbnail() ) ? ( get_the_post_thumbnail( null, $size ) ) : ( '' );

					$hasThumb = ( $image ) ? ( ' has-thumb' ) : ( ' no-thumb' );

					echo '<span class="wm-image-container' . $hasThumb . '">';

					if ( get_edit_post_link() ) {
						edit_post_link( $image );
					} else {
						echo '<a href="' . get_permalink() . '">' . $image . '</a>';
					}

					echo '</span>';

				}
		}
	} // /wm_post_columns_render





/**
 * 50) Visual editor improvements
 */

	/**
	 * Add buttons to visual editor
	 *
	 * First row.
	 *
	 * @param  array $buttons
	 */
	if ( ! function_exists( 'wm_add_buttons_row1' ) ) {
		function wm_add_buttons_row1( $buttons ) {
			//Inserting buttons after "more" button
				$pos = array_search( 'wp_more', $buttons, true );
				if ( $pos != false ) {
					$add     = array_slice( $buttons, 0, $pos + 1 );
					$add[]   = 'wp_page';
					$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
				}

			//Output
				return apply_filters( 'wmhook_wm_add_buttons_row1_output', $buttons );
		}
	} // /wm_add_buttons_row1



	/**
	 * Customizing format dropdown items
	 *
	 * @param  array $init
	 */
	if ( ! function_exists( 'wm_custom_mce_format' ) ) {
		function wm_custom_mce_format( $init ) {
			//Format buttons, default = 'p,address,pre,h1,h2,h3,h4,h5,h6'
				$init['theme_advanced_blockformats'] = apply_filters( 'wmhook_wm_custom_mce_format_theme_advanced_blockformats', 'p,h1,h2,h3,h4,h5,h6,address,div' );

			//Command separated string of extended elements
				$ext = apply_filters( 'wmhook_wm_custom_mce_format_extended_valid_elements', 'pre[id|name|class|style]' );
				if ( isset( $init['extended_valid_elements'] ) ) {
					$init['extended_valid_elements'] .= ',' . $ext;
				} else {
					$init['extended_valid_elements'] = $ext;
				}

			//Output
				return apply_filters( 'wmhook_wm_custom_mce_format_output', $init );
		}
	} // /wm_custom_mce_format





/**
 * 60) Other functions
 */

	/**
	 * WordPress admin notices
	 *
	 * Displays the message stored in "wm-admin-notice" transient cache
	 * once or multiple times, than deletes the message cache.
	 * Transient structure:
	 * set_transient(
	 *   'wm-admin-notice',
	 *   array( $text, $class, $capability, $number_of_displays )
	 * );
	 *
	 * @since    3.0
	 * @version  3.4
	 */
	if ( ! function_exists( 'wm_admin_notice' ) ) {
		function wm_admin_notice() {
			//Requirements check
				if ( ! is_admin() ) {
					return;
				}

			//Helper variables
				$output     = '';
				$class      = 'updated';
				$repeat     = 0;
				$capability = apply_filters( 'wmhook_wm_admin_notice_capability', 'switch_themes' );
				$message    = get_transient( 'wm-admin-notice' );

			//Requirements check
				if ( empty( $message ) ) {
					return;
				}

			//Preparing output
				if ( ! is_array( $message ) ) {
					$message = array( $message, $class, $capability, $repeat );
				}
				if ( ! isset( $message[1] ) || empty( $message[1] ) ) {
					$message[1] = $class;
				}
				if ( ! isset( $message[2] ) || empty( $message[2] ) ) {
					$message[2] = $capability;
				}
				if ( ! isset( $message[3] ) ) {
					$message[3] = $repeat;
				}

				if ( $message[0] && current_user_can( $message[2] ) ) {
					$output .= '<div class="' . trim( 'wm-notice ' . $message[1] ) . '"><p>' . $message[0] . '</p></div>';
					delete_transient( 'wm-admin-notice' );
				}

				//Delete the transient cache after specific number of displays
					if ( 1 < intval( $message[3] ) ) {
						$message[3] = intval( $message[3] ) - 1;
						set_transient( 'wm-admin-notice', $message, ( 60 * 60 * 48 ) );
					}

			//Output
				if ( $output ) {
					echo apply_filters( 'wmhook_wm_admin_notice_output', $output, $message );
				}
		}
	} // /wm_admin_notice



	/**
	 * WordPress user profile contact fields
	 *
	 * @param  array $user_contactmethods
	 */
	if ( ! function_exists( 'wm_user_contact_methods' ) ) {
		function wm_user_contact_methods( $user_contactmethods ) {
			//Preparing output
				if ( ! isset( $user_contactmethods['twitter'] ) ) {
					$user_contactmethods['twitter'] = 'Twitter';
				}
				if ( ! isset( $user_contactmethods['facebook'] ) ) {
					$user_contactmethods['facebook'] = 'Facebook';
				}
				if ( ! isset( $user_contactmethods['googleplus'] ) ) {
					$user_contactmethods['googleplus'] = 'Google+';
				}

			//Output
				return apply_filters( 'wmhook_wm_user_contact_methods_output', $user_contactmethods );
		}
	} // /wm_user_contact_methods



	/**
	 * Switch comments and pingbacks off
	 */
	if ( ! function_exists( 'wm_comments_off' ) ) {
		function wm_comments_off() {
			//Helper variables
				global $current_screen;

				$output = '';

				$post_types = apply_filters( 'wmhook_admin_comments', wm_option( 'general-comments' ) );

				if ( ! is_array( $post_types ) ) {
					$post_types = explode( ',', $post_types );
				}
				$post_types = apply_filters( 'wmhook_wm_comments_off_post_types', array_filter( $post_types ) );

			//Requirements check
				if (
						empty( $post_types )
						|| ! isset( $current_screen->post_type )
						|| ! isset( $current_screen->action )
					) {
					return;
				}

			//Preparing output
				if ( in_array( $current_screen->post_type, $post_types ) && 'add' == $current_screen->action ) {
					$output .= '<script><!--
						if ( document.post ) {
							var the_comment = document.post.comment_status,
							    the_ping    = document.post.ping_status;
							if ( the_comment && the_ping ) {
								the_comment.checked = false;
								the_ping.checked    = false;
							}
						}
						//--></script>';
				}

			//Output
				echo apply_filters( 'wmhook_wm_comments_off_output', $output );
		}
	} // /wm_comments_off

?>