<?php
/**
 * WebMan Amplifier plugin setup
 *
 * THEME IMPLEMENTATION
 * Copy this file into your theme's folder and inlude it in the theme's
 * "functions.php" file with "require_once( 'webman-amplifier-setup.php' );"
 * command. Edit the file to your needs.
 *
 * PLUGIN LOCALIZATION
 * Note that custom translation files inside the plugin folder
 * will be removed on plugin updates. If you're creating custom
 * translation files, please use the global WordPress language folder.
 * Just create a "wp-content/languages/wm-amplifier" folder and place
 * your plugin localization files in there.
 *
 * @author     WebMan
 * @copyright  2014 WebMan
 *
 * @since    1.0
 * @version  1.4
 */





/**
 * SET UP THE PLUGIN
 */

	/**
	 * Enabling plugin features
	 *
	 * Please note that your theme must support them. If you enable any of custom
	 * post types, make sure your theme contains the appropriate single post
	 * and archive templates.
	 */
	add_theme_support( 'webman-amplifier', apply_filters( 'wmhook_webman_amplifier_support', array(
			'cp-logos',
			'cp-modules',
			'cp-projects',
			'cp-staff',
			'cp-testimonials',
			'widget-contact',
			'widget-module',
			'widget-posts',
			'widget-subnav',
			'widget-tabbed-widgets',
			'widget-twitter',
		) ) );

	//WebMan Advanced Metaboxes
		add_filter( 'wmhook_metabox_visual_wrapper_toggle', '__return_true' );
	//Enable Schema.org
		add_filter( 'wmhook_wmamp_disable_schema_org', '__return_false' );
	//Dequeue plugin shortcodes stylesheet
		add_filter( 'wmhook_shortcode_enqueue_shortcode_css', '__return_false' );
	//Visual Composer text block content filters
		// add_filter( 'wmhook_shortcode_text_block_content', 'wm_default_content_filters', 10 );
	//Disable the Isotope licence purchase admin notice
		add_filter( 'wmhook_wmamp_notice_isotope_licence', '__return_false' );





	/**
	 * Deactivate plugin when theme changed
	 *
	 * @since    1.2.2
	 * @version  1.2.5
	 */

		if ( ! get_option( 'wmamp-deactivate' ) ) {
			update_option( 'wmamp-deactivate', true );
		}





	/**
	 * Dequeue RTL stylesheets
	 *
	 * @version  1.1
	 */
	function wm_dequeue_rtl() {
		if (
				is_rtl()
				&& apply_filters( 'wmhook_force_admin_ltr', false )
			) {
			wp_dequeue_style( 'wm-metabox-styles-rtl' );
			wp_dequeue_style( 'wm-shortcodes-generator-rtl' );
			wp_dequeue_style( 'wm-shortcodes-vc-addon-rtl' );
		}
	} // /wm_dequeue_rtl

	add_filter( 'admin_enqueue_scripts', 'wm_dequeue_rtl', 999 );



	/**
	 * Setup the default color calculation treshold
	 *
	 * @version  1.1
	 *
	 * @param  integer $treshold [0,255]
	 */
	function wm_default_color_treshold( $treshold ) {
		//Requirements check
			if ( ! function_exists( 'wm_option' ) ) {
				return $treshold;
			}

		//Preparing output
			$skin_treshold = wm_option( 'skin-text-color-treshold' );
			if ( $skin_treshold ) {
				$treshold = 2.55 * absint( $skin_treshold + 50 );
			}

		//Output
			return absint( $treshold );
	} // /wm_default_color_treshold

	add_filter( 'wmhook_wmamp_color_brightness_treshold', 'wm_default_color_treshold' );



	/**
	 * Pagination left/right buttons
	 *
	 * @param  array $atts
	 */
	function wm_pagination_next_prev( $atts ) {
		//Preparing output
			if ( ! is_rtl() ) {
				$atts['label_next']     = '<i class="iconwm-arrow-right-thin-small"></i>';
				$atts['label_previous'] = '<i class="iconwm-arrow-left-thin-small"></i>';
			} else {
				$atts['label_next']     = '<i class="iconwm-arrow-left-thin-small"></i>';
				$atts['label_previous'] = '<i class="iconwm-arrow-right-thin-small"></i>';
			}

		//Output
			return $atts;
	} // /wm_pagination_next_prev

	add_filter( 'wmhook_wmamp_wma_pagination_atts_defaults', 'wm_pagination_next_prev' );





/**
 * WIDGETS
 *
 * @since  1.2.2
 */

	/**
	 * Posts widget modifications
	 */

		/**
		 * Adding custom post types
		 *
		 * @param  array $post_types
		 */
		function wm_widgets_posts_post_types( $post_types = array() ) {
			//Preparing output
				$post_types['wm_projects'] = __( 'Projects', 'wm_domain' );

			//Output
				return $post_types;
		} // /wm_widgets_posts_post_types

		add_filter( 'wmhook_widgets_wm_posts_widget_form_post_type', 'wm_widgets_posts_post_types' );



		/**
		 * Adding taxonomies
		 *
		 * @param  array $taxonomies
		 */
		function wm_widgets_posts_taxonomies( $taxonomies = array() ) {
			//Preparing output
				$taxonomies['wm_projects'] = array(
						'optgroup'     => __( 'Projects tags', 'wm_domain' ),
						'all'          => false,
						'hierarchical' => '0',
						'tax_name'     => 'project_tag',
					);

			//Output
				return $taxonomies;
		} // /wm_widgets_posts_taxonomies

		add_filter( 'wmhook_widgets_wm_posts_widget_form_taxonomy', 'wm_widgets_posts_taxonomies' );



		/**
		 * Instance defaults
		 *
		 * @param  array $defaults
		 */
		function wm_widgets_posts_instance_defaults( $defaults = array() ) {
			//Preparing output
				$defaults['layout'] = array(
						'post'        => 'widget',
						'wm_projects' => 'widget',
					);

			//Output
				return $defaults;
		} // /wm_widgets_posts_instance_defaults

		add_filter( 'wmhook_widgets_wm_posts_widget_defaults', 'wm_widgets_posts_instance_defaults' );





/**
 * CUSTOM METABOXES
 */

	if ( function_exists( 'wma_add_meta_box' ) ) {

		/**
		 * Post metaboxex
		 */

			/**
			 * Post formats info metafields
			 *
			 * @param   array $fields Array of predefined metafields
			 *
			 * @return  array Modified $fields array
			 */
			function wm_post_formats_metafields( $fields = array() ) {

				$fields[20] = array(
						'id'          => 'post-format-audio',
						'type'        => 'html',
						'content'     => '<div class="box blue">' . __( '<h2>Audio post format</h2>Displays audio player to play your audio files. Could be used for Podcasting. Please place the <code>[wm_audio]</code> shortcode as the first thing in post content. The audio description text can follow on next line.', 'wm_domain' ) . '</div>',
						'conditional' => array(
								'option'       => array(
										'tag'  => 'input',
										'name' => 'post_format',
										'type' => 'radio',
									),
								'option_value' => array( 'audio' ),
								'operand'      => 'IS',
							),
					);

				$fields[25] = array(
						'id'          => 'post-format-gallery',
						'type'        => 'html',
						'content'     => '<div class="box blue">' . __( '<h2>Gallery post format</h2>A standard post with a gallery of images in post content. Slideshow will be displayed on blog page from the first gallery found in post content. If no gallery found, featured image is displayed.<br />You can insert a <code>&#91;gallery]</code> shortcode anywhere in the post. This shortcode will not be stripped out from the post content on the single post page.', 'wm_domain' ) . '</div>',
						'conditional' => array(
								'option'       => array(
										'tag'  => 'input',
										'name' => 'post_format',
										'type' => 'radio',
									),
								'option_value' => array( 'gallery' ),
								'operand'      => 'IS',
							),
					);

				$fields[30] = array(
						'id'          => 'post-format-link',
						'type'        => 'html',
						'content'     => '<div class="box blue">' . __( '<h2>Link post format</h2>Promotes interesting URL links. You can set the link anywhere in the post content. The link will be emphasized when post is displayed.', 'wm_domain' ) . '<br />' . __( 'Post title will not be displayed.', 'wm_domain' ) . '</div>',
						'conditional' => array(
								'option'       => array(
										'tag'  => 'input',
										'name' => 'post_format',
										'type' => 'radio',
									),
								'option_value' => array( 'link' ),
								'operand'      => 'IS',
							),
					);

				$fields[35] = array(
						'id'          => 'post-format-quote',
						'type'        => 'html',
						'content'     => '<div class="box blue">' . __( '<h2>Quote post format</h2>A quotation. Please place the actual quote (blockquote) directly into post content. To set a quote source use a <code>&lt;cite></code> HTML tag.', 'wm_domain' ) . '<br />' . __( 'Post title will not be displayed.', 'wm_domain' ) . '</div>',
						'conditional' => array(
								'option'       => array(
										'tag'  => 'input',
										'name' => 'post_format',
										'type' => 'radio',
									),
								'option_value' => array( 'quote' ),
								'operand'      => 'IS',
							),
					);

				$fields[40] = array(
						'id'          => 'post-format-status',
						'type'        => 'html',
						'content'     => '<div class="box blue">' . __( '<h2>Status post format</h2>A short status update, similar to a Twitter status update. Please place the actual status text directly into post content area.', 'wm_domain' ) . '<br />' . __( 'Post title will not be displayed.', 'wm_domain' ) . '</div>',
						'conditional' => array(
								'option'       => array(
										'tag'  => 'input',
										'name' => 'post_format',
										'type' => 'radio',
									),
								'option_value' => array( 'status' ),
								'operand'      => 'IS',
							),
					);

				$fields[45] = array(
						'id'          => 'post-format-video',
						'type'        => 'html',
						'content'     => '<div class="box blue">' . __( '<h2>Video post format</h2>A single video. Please place the <code>[wm_video]</code> shortcode as the first thing in post content. The video description text can follow on next line.', 'wm_domain' ) . '</div>',
						'conditional' => array(
								'option'       => array(
										'tag'  => 'input',
										'name' => 'post_format',
										'type' => 'radio',
									),
								'option_value' => array( 'video' ),
								'operand'      => 'IS',
							),
					);

				/**
				 * For more form fields options please check the PHP files inside
				 * the "wm-amplifier/includes/metabox/fields/" folder.
				 */

				return $fields;
			} // /wm_post_formats_metafields



			/**
			 * Post metabox metafields
			 *
			 * @version  1.1
			 *
			 * @param   array $fields Array of predefined metafields
			 *
			 * @return  array Modified $fields array
			 */
			function wm_post_metafields( $fields = array() ) {
				//Helper variables
					$helper = array(
							'sidebars' => ( ! function_exists( 'wm_helper_var' ) ) ? ( array( '' => __( 'Default', 'wm_domain' ) ) ) : ( wm_helper_var( 'layouts', 'sidebars' ) ),
						);

					if ( isset( $helper['sidebars']['sections'] ) ) {
						unset( $helper['sidebars']['sections'] );
					}

				//"Settings" tab
					$fields[100] = array(
							'type'  => 'section-open',
							'id'    => 'page-options-section',
							'title' => __( 'Settings', 'wm_domain' ),
						);

						$fields[120] = array(
								'type'        => 'checkbox',
								'id'          => 'disable-heading',
								'label'       => __( 'Disable main heading', 'wm_domain' ),
								'description' => __( 'Hide main heading section', 'wm_domain' ),
							);

						$fields[140] = array(
								'type'        => 'select',
								'id'          => 'sidebar',
								'label'       => __( 'Sidebar position', 'wm_domain' ),
								'description' => __( 'Select a sidebar position', 'wm_domain' ),
								'options'     => $helper['sidebars'],
							);

					$fields[1000] = array(
							'type' => 'section-close',
						);
				// /"Settings" tab

				/**
				 * For more form fields options please check the PHP files inside
				 * the "wm-amplifier/includes/metabox/fields/" folder.
				 */

				return $fields;
			} // /wm_post_metafields



			wma_add_meta_box( array(
					// Meta fields function callback (should return array of fields).
					// The function callback is used for to use a WordPress globals
					// available during the metabox rendering, such as $post.
					'fields' => 'wm_post_metafields',

					// Meta box id, unique per meta box.
					'id' => 'post-metabox',

					// Post types.
					'pages' => array( 'post' ),

					// Meta box title.
					'title' => __( 'Post options', 'wm_domain' ),

					// Function callback of form fields displayed immediately after
				 	// visual editor on 1st tab.
				 	'visual-wrapper-add' => 'wm_post_formats_metafields',
				) );



		/**
		 * Page metabox
		 */

			/**
			 * Page metabox metafields
			 *
			 * @version  1.1
			 *
			 * @param   array $fields Array of predefined metafields
			 *
			 * @return  array Modified $fields array
			 */
			function wm_page_metafields( $fields = array() ) {
				//Helper variables
					global $post_id;

					$wm_layouts = ( ! function_exists( 'wm_helper_var' ) ) ? ( array( 'sidebars' => array(), 'website' => array() ) ) : ( wm_helper_var( 'layouts' ) );

					$menus  = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
					$helper = array(
							'menus'    => array( '' => __( 'Default', 'wm_domain' ) ),
							'sidebars' => $wm_layouts['sidebars'],
							'website'  => $wm_layouts['website'],
						);

					if (
							is_array( $menus )
							&& ! empty( $menus )
						) {
						foreach ( $menus as $item ) {
							if ( isset( $item->name ) && isset( $item->slug ) ) {
								$helper['menus'][ $item->slug ] = $item->name;
							}
						}
					}

				//"Settings" tab
					$fields[100] = array(
							'type'  => 'section-open',
							'id'    => 'page-options-section',
							'title' => __( 'Settings', 'wm_domain' ),
							'page'  => array(
									'templates' => array( 'page-template/blank.php' ),
									'operand'   => 'IS_NOT'
								),
						);

						$fields[120] = array(
								'type'        => 'checkbox',
								'id'          => 'disable-heading',
								'label'       => __( 'Disable main heading', 'wm_domain' ),
								'description' => __( 'Hide main heading section', 'wm_domain' ),
							);

						$fields[140] = array(
								'type'        => 'select',
								'id'          => 'sidebar',
								'label'       => __( 'Page layout', 'wm_domain' ),
								'description' => __( 'Select a sidebar position or enable fullwidth sections', 'wm_domain' ),
								'options'     => $helper['sidebars'],
							);
							$fields[145] = array(
									'id'      => 'sections-description',
									'type'    => 'html',
									'content' => '<div class="box blue">' . __( 'All <code>[wm_row]</code> (and/or <code>[vc_row]</code>) shortcodes will be treated as fullwidth sections in "Fullwidth sections" page layout.', 'wm_domain' ) . '</div>',
									'conditional' => array(
											'option'       => array(
													'tag'  => 'select',
													'name' => 'wm-sidebar',
												),
											'option_value' => array( 'sections' ),
											'operand'      => 'IS',
										),
								);

						$fields[160] = array(
								'type'        => 'select',
								'id'          => 'layout',
								'label'       => __( 'Website layout', 'wm_domain' ),
								'description' => __( 'Select a website layout for this page', 'wm_domain' ),
								'options'     => $helper['website'],
							);

						$fields[180] = array(
								'type'        => 'select',
								'id'          => 'footer',
								'label'       => __( 'Footer layout', 'wm_domain' ),
								'description' => __( 'Select a footer layout', 'wm_domain' ),
								'options'     => array(
										''        => __( 'Widgets and credits', 'wm_domain' ),
										'widgets' => __( 'Widgets only', 'wm_domain' ),
										'credits' => __( 'Credits only', 'wm_domain' ),
										'none'    => __( 'No footer', 'wm_domain' ),
									),
							);

					$fields[1000] = array(
							'type' => 'section-close',
						);
				// /"Settings" tab

				//"Slider" tab
					$fields[2000] = array(
							'type'  => 'section-open',
							'id'    => 'page-slider-section',
							'title' => __( 'Slider', 'wm_domain' ),
							'page'  => array(
									'templates' => array( 'page-template/blank.php' ),
									'operand'   => 'IS_NOT'
								),
						);

						$fields[2020] = array(
								'type'    => 'html',
								'content' => '<tr class="option padding-20"><td colspan="2"><div class="box blue">' . __( '<strong>Please note that this is a special slider section setup.</strong><br />This slider will be displayed above the website header area. For standard sliders please use the shortcodes directly in the page content.', 'wm_domain' ) . '</div></td></tr>',
							);

						$fields[2040] = array(
								'type'        => 'select',
								'id'          => 'slider',
								'label'       => __( 'Set special slider', 'wm_domain' ),
								'description' => __( 'Select a slider type used as a special slider above the website header', 'wm_domain' ),
								'options'     => array(
										''       => __( 'No special slider', 'wm_domain' ),
										'custom' => __( 'Custom slider (use shortcode)', 'wm_domain' ),
										'static' => __( 'Featured image', 'wm_domain' ),
									),
							);

						$fields[2060] = array(
								'type'        => 'text',
								'id'          => 'slider-shortcode',
								'label'       => __( 'Slider shortcode', 'wm_domain' ),
								'description' => __( 'Set the custom slider shortcode', 'wm_domain' ),
								'conditional' => array(
										'option'       => array(
												'tag'  => 'select',
												'name' => 'wm-slider',
												'type' => '',
											),
										'option_value' => array( 'custom' ),
										'operand'      => 'IS',
									),
							);

						$fields[2080] = array(
								'type'        => 'select',
								'id'          => 'slider-static',
								'label'       => __( 'Image caption position', 'wm_domain' ),
								'description' => __( 'Featured image will be displayed in the special slider section.<br />Set the image caption (you can use shortcodes) and set the image caption position here.', 'wm_domain' ) . '<br /><a href="#" class="button-primary button-set-featured-image" style="margin-top: .5em">' . __( 'Set featured image', 'wm_domain' ) . '</a>',
								'options'     => array(
										'center' => __( 'Center', 'wm_domain' ),
										'left'   => __( 'Left', 'wm_domain' ),
										'right'  => __( 'Right', 'wm_domain' ),
									),
								'conditional' => array(
										'option'       => array(
												'tag'  => 'select',
												'name' => 'wm-slider',
												'type' => '',
											),
										'option_value' => array( 'static' ),
										'operand'      => 'IS',
									),
							);

					$fields[3000] = array(
							'type' => 'section-close',
						);
				// /"Slider" tab

				//"Blog" tab
					$fields[4000] = array(
							'type'  => 'section-open',
							'id'    => 'page-blog-section',
							'title' => __( 'Blog', 'wm_domain' ),
							'page'  => array(
									'templates' => array( 'home.php' ),
									'operand'   => 'IS'
								),
						);

						$fields[4020] = array(
								'type'        => 'slider',
								'id'          => 'blog-posts-count',
								'label'       => __( 'Number of posts', 'wm_domain' ),
								'description' => __( 'Sets the number of posts listed on this blog page only. Other archives will display posts according to WordPress settings.<br />Value of "-1" will display all posts. When you set the value of "0", WordPress settings are applied.', 'wm_domain' ),
								'default'     => 0,
								'min'         => -1,
								'max'         => 25,
								'step'        => 1,
								'zero'        => true,
							);

						//Categories multi field
						$category_fields = array();
						$category_fields[] = array(
								'type'    => 'select',
								'id'      => 'category',
								'label'   => __( 'Category', 'wm_domain' ),
								'options' => wma_taxonomy_array(),
							);
						$fields[4040] = array(
								'type'        => 'repeater',
								'id'          => 'blog-categories',
								'label'       => __( 'Posts categories', 'wm_domain' ),
								'description' => __( 'You can choose to display all posts or posts from a specific categories only. Press [+] button to add a category and select the category name from dropdown list.', 'wm_domain' ),
								'fields'      => $category_fields,
							);

						$fields[4060] = array(
								'type'        => 'radio',
								'id'          => 'blog-categories-action',
								'label'       => __( 'Categories action', 'wm_domain' ),
								'description' => __( 'Exclude or use the above categories?', 'wm_domain' ),
								'default'     => 'category__in',
								'options'     => array(
										'category__in'     => __( 'Posts just from these categories', 'wm_domain' ),
										'category__not_in' => __( 'Exclude posts from these categories', 'wm_domain' ),
									),
							);

					$fields[5000] = array(
							'type' => 'section-close',
						);
				// /"Blog" tab

				//"One page" tab
					if (
							! class_exists( 'Woocommerce' )
							|| ! (
								class_exists( 'Woocommerce' )
								&& $post_id
								&& $post_id == wc_get_page_id( 'shop' )
							)
						) {

						$fields[6000] = array(
								'type'  => 'section-open',
								'id'    => 'page-one-section',
								'title' => __( 'One page', 'wm_domain' ),
								'page'  => array(
										'templates' => array( 'page-template/one-page.php' ),
										'operand'   => 'IS'
									),
							);

							$fields[6020] = array(
									'type'    => 'html',
									'content' => '<tr class="option padding-20"><td colspan="2"><div class="box blue">' . __( 'Use this page template to place most (or all) of your website content on a single page. Set the ID for each section of the page (apply on row shortcode) and use them in custom navigation as anchors. You can set a navigation for this page below. Once you click the navigation link, the page will scroll to the section of a specific anchor ID.', 'wm_domain' ) . '</div></td></tr>',
								);

							$fields[6040] = array(
									'type'        => 'select',
									'id'          => 'navigation',
									'label'       => __( 'Anchor navigation', 'wm_domain' ),
									'description' => __( 'Set a special anchor navigation for this page', 'wm_domain' ),
									'options'     => $helper['menus'],
								);

						$fields[7000] = array(
								'type' => 'section-close',
							);

					}
				// /"One page" tab

				/**
				 * For more form fields options please check the PHP files inside
				 * the "wm-amplifier/includes/metabox/fields/" folder.
				 */

				return $fields;
			} // /wm_page_metafields



			wma_add_meta_box( array(
					// Meta fields function callback (should return array of fields).
					// The function callback is used for to use a WordPress globals
					// available during the metabox rendering, such as $post.
					'fields' => 'wm_page_metafields',

					// Meta box id, unique per meta box.
					'id' => 'page-metabox',

					// Post types.
					'pages' => array( 'page' ),

					// Meta box title.
					'title' => __( 'Page options', 'wm_domain' ),
				) );



		/**
		 * Staff metabox
		 */

			/**
			 * Staff metabox fields alteration
			 *
			 * @param   array $fields Array of predefined metafields
			 * @param   array $fonticons Array of icons names/classes
			 *
			 * @return  array Modified $fields array
			 */
			function wm_staff_contact_fields( $fields = array(), $fonticons = array() ) {
				//Preparing output
					$fields = array();

					if ( ! empty( $fonticons ) ) {
						$fields[] = array(
								'type'    => 'select',
								'id'      => 'icon',
								'label'   => __( 'Icon', 'wm_domain' ),
								'options' => $fonticons,
							);
					}
					$fields[] = array(
							'type'  => 'text',
							'id'    => 'title',
							'label' => __( 'Hover title', 'wm_domain' ),
						);
					$fields[] = array(
							'type'  => 'text',
							'id'    => 'link',
							'label' => __( 'URL link', 'wm_domain' ),
						);

				//Output
					return $fields;
			} // /wm_staff_contact_fields

			add_filter( 'wmhook_wmamp_cp_metafields_wm_staff_contact_fields', 'wm_staff_contact_fields', 10, 2 );



		/**
		 * Projects metabox
		 */

			/**
			 * Projects metabox fields alteration
			 *
			 * @version  1.1
			 *
			 * @param   array $fields Array of predefined metafields
			 *
			 * @return  array Modified $fields array
			 */
			function wm_project_metafields( $fields = array() ) {
				//Preparing output
					$fields[1000]['title'] = __( 'Settings', 'wm_domain' );
					$fields[1010] = array(
							'type'        => 'select',
							'id'          => 'sidebar',
							'label'       => __( 'Page layout', 'wm_domain' ),
							'description' => __( 'Select a sidebar position or enable fullwidth sections', 'wm_domain' ),
							'options'     => ( ! function_exists( 'wm_helper_var' ) ) ? ( array( '' => __( 'Default', 'wm_domain' ) ) ) : ( wm_helper_var( 'layouts', 'sidebars' ) ),
						);
						$fields[1011] = array(
								'id'      => 'sections-description',
								'type'    => 'html',
								'content' => '<div class="box blue">' . __( 'All <code>[wm_row]</code> (and/or <code>[vc_row]</code>) shortcodes will be treated as fullwidth sections in "Fullwidth sections" page layout.', 'wm_domain' ) . '</div>',
								'conditional' => array(
										'option'       => array(
												'tag'  => 'select',
												'name' => 'wm-sidebar',
											),
										'option_value' => array( 'sections' ),
										'operand'      => 'IS',
									),
							);

					$fields[1015] = array(
							'type'        => 'text',
							'id'          => 'slider',
							'label'       => __( 'Custom preview slider', 'wm_domain' ),
							'description' => __( 'This slider will be displayed on projects list only, instead of featured image. Please enter the slider shortcode.', 'wm_domain' ),
						);

					$fields[1040]['options'][''] = '';
					unset( $fields[1040]['options']['1OPTGROUP'] );
					unset( $fields[1040]['options']['1/OPTGROUP'] );

				//Output
					return $fields;
			} // /wm_project_metafields

			add_filter( 'wmhook_wmamp_cp_metafields_wm_projects', 'wm_project_metafields', 10 );

	} // /wma_add_meta_box function check





/**
 * SHORTCODES
 */

	/**
	 * Supported shortcodes version
	 *
	 * Use this to declare the plugin version that your theme supports.
	 * It is possible that in future versions of the plugin there will be more
	 * shortcodes added and your theme might not suppot them out of the box.
	 * Setting this version number will make sure only the shortcodes included
	 * with the specific plugin version will be available to your theme users.
	 *
	 * To use this function just uncomment the "add_filter" below
	 */
	function wm_supported_shortcode_until_version() {
		return '1.0.9'; //Set the plugin version your theme supports
	} // /wm_supported_shortcode_until_version

	add_filter( 'wmhook_shortcode_supported_version', 'wm_supported_shortcode_until_version' );



	/**
	 * Posts shortcode default image size
	 *
	 * @version  1.1
	 */
	function wm_shortcode_image_size() {
		//Requirements check
			if ( ! function_exists( 'wm_option' ) ) {
				return $size;
			}

		//Output
			return 'mobile-' . wm_option( 'skin-image-posts' );
	} // /wm_shortcode_image_size

	add_filter( 'wmhook_shortcode_posts_image_size', 'wm_shortcode_image_size' );



	/**
	 * Slideshow shortcode default image size
	 */
	function wm_slideshow_image_size() {
		return 'content-width';
	} // /wm_slideshow_image_size

	add_filter( 'wmhook_shortcode_slideshow_image_size', 'wm_slideshow_image_size' );



	/**
	 * Staff posts default image size
	 */
	function wm_staff_posts_image_size() {
		return 'admin-thumbnail';
	} // /wm_staff_posts_image_size

	add_filter( 'wmhook_shortcode_posts_image_size_wm_staff', 'wm_staff_posts_image_size' );



	/**
	 * Content Module shortcode modifications
	 */

		/**
		 * Content Module shortcode default layout
		 *
		 * Removing "morelink" and setting layout element for banner only.
		 *
		 * @param  array $layouts
		 * @param  array $atts
		 */
		function wm_shortcode_content_module_layout( $layouts, $atts ) {
			//Preparing output
				$layouts['wm_modules'] = array( 'image', 'title', 'content' );

				if ( false !== strpos( $atts['class'], 'banner' ) ) {
					$layouts['wm_modules'] = array( 'image', 'content' );
				}

			//Output
				return $layouts;
		} // /wm_shortcode_content_module_layout

		add_filter( 'wmhook_shortcode_content_module_layouts', 'wm_shortcode_content_module_layout', 10, 2 );



		/**
		 * Content Module shortcode layout elements
		 *
		 * @param  array  $layout_elements
		 * @param  absint $post_id
		 * @param  array  $helpers
		 * @param  array  $atts
		 */
		function wm_shortcode_content_module_layout_elements( $layout_elements, $post_id, $helpers, $atts ) {
			//Preparing output
				if ( false !== strpos( $atts['class'], 'banner' ) ) {
					$content = wpautop( get_the_content() );

					if ( $helpers['link'] ) {
						$content = '<a' . $helpers['link'] . ' class="banner-cell">' . $content . '</a>';
					} else {
						$content = '<div class="banner-cell">' . $content . '</div>';
					}

					$layout_elements['content'] = do_shortcode( '<div class="wm-content-module-element wm-html-element content"><div class="banner-table custom-font-color">' . $content . '</div></div>' );
				}

			//Output
				return $layout_elements;
		} // /wm_shortcode_content_module_layout_elements

		add_filter( 'wmhook_shortcode_content_module_layout_elements', 'wm_shortcode_content_module_layout_elements', 10, 4 );



	/**
	 * Section (row) and column shortcode modifications
	 */

		/**
		 * Additional shortcode default attributes
		 */
		function wm_modify_shortcode_defaults( $atts, $shortcode ) {
			//Preparing output
				switch ( $shortcode ) {
					case 'row':
					case 'vc_row':

						$atts['disable_container'] = false;
						$atts['video_url']         = '';
						if ( 'sections' == wma_meta_option( 'sidebar' ) ) {
							$atts['behaviour'] = 'section';
						}

					break;

					case 'column':
					case 'vc_column':

						$atts['bg_image'] = '';

					break;

					default:
					break;
				}

			//Output
				return $atts;
		} // /wm_modify_shortcode_defaults

		add_filter( 'wmhook_shortcode__defaults', 'wm_modify_shortcode_defaults', 10, 2 );



		/**
		 * Modify section/row styles
		 */
		function wm_section_styles( $attributes, $atts ) {
			//Modify styles
				if ( $atts['bg_color'] ) {
					$attributes['style'] .= ' border-color: ' . esc_attr( wma_contrast_color( $atts['bg_color'], 19 ) ) . ';';
				}

			//Output
				return $attributes;
		} // /wm_section_styles

		add_filter( 'wmhook_shortcode_row_html_attributes',    'wm_section_styles', 10, 2 );
		add_filter( 'wmhook_shortcode_vc_row_html_attributes', 'wm_section_styles', 10, 2 );



		/**
		 * Shortcode markup: section (row)
		 */
		function wm_section_markup( $output, $atts ) {
			//Helper variables
				$prepend = $append = $sections_layout = '';

				$video_formats = array( 'mp4', 'm4v', 'webm', 'ogv', 'wmv', 'flv' );

				if ( 'sections' == wma_meta_option( 'sidebar' ) ) {
					$sections_layout = true;
				}

				//video_url
					$atts['video_url'] = array_filter( explode( ',', str_replace( ' ', '', $atts['video_url'] ) ) );
					if ( ! empty( $atts['video_url'] ) ) {
						if ( 1 === count( $atts['video_url'] ) ) {
							$atts['video_url'] = array( 'src="' . esc_url( $atts['video_url'][0] ) . '"' );
						} else {
							foreach ( $atts['video_url'] as $key => $url ) {
								foreach ( $video_formats as $format ) {
									if ( stripos( $url, '.' . $format ) ) {
										$atts['video_url'][ $key ] = $format . '="' . esc_url( $url ) . '"';
									}
								}
							}
						}
						$atts['video_url'] = do_shortcode( apply_filters( 'wm_section_markup_video_url', '<div class="wm-row-video">[wm_video ' . implode( ' ', $atts['video_url'] ) . ' loop="on" autoplay="on" /]<div class="overlay"></div></div>' ), $atts );
					} else {
						$atts['video_url'] = '';
					}

				//Modify class
					if ( $atts['font_color'] ) {
						$atts['class'] .= ' custom-font-color';
					}

			//Section markup
				if ( $sections_layout ) {
					//Modify class
						if ( $atts['padding'] ) {
							$atts['class'] .= ' no-wrap-inner-padding';
						}

					//Section HTML wrapper
						$prepend .= "\r\n\r\n" . '<div class="wm-section {class}"{attributes}>' . "\r\n\r\n" . $atts['video_url'];
						$append  .= "\r\n\r\n" . '</div> <!-- /wm-section -->' . "\r\n\r\n";

					//Apply default theme section inner wrappers
						if ( ! $atts['disable_container'] ) {
							$prepend .= apply_filters( 'wmhook_section_inner_wrappers', '' );
							$append   = apply_filters( 'wmhook_section_inner_wrappers_close', '' ) . $append;
						}
				}

			//Output
				$replacements = array(
						'{attributes}' => implode( ' ', $atts['attributes'] ),
						'{class}'      => $atts['class'],
						'{content}'    => $atts['content'],
					);
				$output = strtr( $prepend . $atts['html'][ $atts['behaviour'] ] . $append, $replacements );

				return $output;
		} // /wm_section_markup

		add_filter( 'wmhook_shortcode_row_output',    'wm_section_markup', 10, 2 );
		add_filter( 'wmhook_shortcode_vc_row_output', 'wm_section_markup', 10, 2 );



		/**
		 * Shortcode markup: column
		 */
		function wm_column_markup( $output, $atts ) {
			//Validation
				//style
					$atts['style'] = '';
				//bg_image
					$atts['bg_image'] = trim( $atts['bg_image'] );
					if ( $atts['bg_image' ] ) {

						$atts['class'] .= ' match-height';

						if ( is_numeric( $atts['bg_image'] ) ) {
							$image_size = apply_filters( 'wmhook_shortcode_column_image_size', 'full' );
							$image      = wp_get_attachment_image_src( absint( $atts['bg_image'] ), $image_size );

							if ( is_array( $image ) && isset( $image[0] ) && $image[0] ) {
								$atts['style'] .= ' background-image: url(' . esc_url( $image[0] ) . ');';
							}
						} elseif ( $atts['bg_image'] ) {
							$atts['style'] .= ' background-image: url(' . esc_url( $atts['bg_image'] ) . ');';
						}

						$atts['style'] .= ' background-repeat: repeat;';
						$atts['style'] .= ' background-position: 50% 50%;';
						$atts['style'] .= ' background-size: cover;';

						$atts['style'] = ' style="' . esc_attr( $atts['style'] ) . '"';

					}

			//Output
				return '<div class="' . $atts['class'] . '"' . $atts['style'] . '>' . $atts['content'] . '</div>';
		} // /wm_column_markup

		add_filter( 'wmhook_shortcode_column_output',    'wm_column_markup', 10, 2 );
		add_filter( 'wmhook_shortcode_vc_column_output', 'wm_column_markup', 10, 2 );



	/**
	 * VISUAL COMPOSER PLUGIN SUPPORT
	 *
	 * Please note that this is 3rd party plugin. The WebMan Amplifier plugin
	 * just integrates its shortcodes feature with the Visual Composer plugin
	 * to make it easier to create content. If you have any difficulties
	 * with Visual Composer plugin, please contact its developers.
	 *
	 * @link  http://codecanyon.net/item/visual-composer-for-wordpress/242431
	 */
	if ( function_exists( 'wma_is_active_vc' ) && wma_is_active_vc() ) {

		/**
		 * Remove default Visual Composer elements (shortcodes)
		 */
		add_theme_support( 'webman-shortcodes', array( 'remove_vc_shortcodes' ) );



		/**
		 * Deregister VC frontend JS
		 *
		 * This script is not needed and causing issues.
		 *
		 * @since    1.4
		 * @version  1.4
		 */
		function wm_deregister_visual_composer_front_js() {
			wp_deregister_script( 'wpb_composer_front_js' );
		} // /wm_deregister_visual_composer_front_js

		add_action( 'vc_base_register_front_js', 'wm_deregister_visual_composer_front_js' );



		/**
		 * Section (row) shortcode modifications
		 */

			/**
			 * Additional Visual Composer parameters
			 */
			function wm_modify_shortcodes_definitions( $definitions ) {
				//Preparing output
					//Posts shortcode
						$definitions['posts']['vc_plugin']['params'][30]['value'] = array(
								1 => 1,
								2 => 2,
								3 => 3,
								4 => 4,
								5 => 5,
								6 => 6,
								7 => 7,
								8 => 8,
								9 => 9,
							);

						$definitions['posts']['vc_plugin']['params'][145] = array(
								'heading'     => __( 'Output layout', 'wm_domain' ),
								'description' => __( 'Set optional output layout name. You can use <code>simple</code> with <em>Posts</em> and <em>Projects</em> posts.', 'wm_domain' ),
								'type'        => 'textfield',
								'param_name'  => 'layout',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Layout', 'wm_domain' ),
							);

					//Row shortcode
						$definitions['vc_row']['vc_plugin']['params'][5] = array(
								'heading'     => __( 'Remove section inner container', 'wm_domain' ),
								'description' => __( 'This is only relevant when using "Fullwidth sections" page layout.', 'wm_domain' ),
								'type'        => 'checkbox',
								'param_name'  => 'disable_container',
								'value'       => '',
								'value'       => array(
										__( 'Remove the inner Section container to make the content fill the whole section without any paddings.', 'wm_domain' ) => 1,
									),
								'holder'      => 'hidden',
								'class'       => '',
							);
						$definitions['vc_row']['vc_plugin']['params'][90] = array(
								'heading'     => __( 'Section background video URL', 'wm_domain' ),
								'description' => __( 'Set optional section background video URL. Video will be played automatically in a loop.', 'wm_domain' ),
								'type'        => 'textfield',
								'param_name'  => 'video_url',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
								'group'       => __( 'Styling', 'wm_domain' ),
							);

					//Column shortcode
						$definitions['vc_column']['vc_plugin']['params'][5] = array(
								'heading'     => __( 'Background image', 'wm_domain' ),
								'description' => __( 'The image will cover the column background', 'wm_domain' ),
								'type'        => 'attach_image',
								'param_name'  => 'bg_image',
								'value'       => '',
								'holder'      => 'hidden',
								'class'       => '',
							);

					//Slideshow shortcode
						$definitions['slideshow']['vc_plugin']['params'][20]['value'] = array(
								__( 'Just Next/Prev button', 'wm_domain' )  => '',
								__( 'Next/Prev + Pagination', 'wm_domain' ) => 'pagination',
								//Removed custom thumbnail pagination as we are using Owl Carousel (@todo Make custom thumbnail pagination work with Owl Carousel too.)
							);

					//bbPress shortcodes
						if ( class_exists( 'bbPress' ) ) {
							//Forum index
								$definitions['bbp-forum-index'] = array(
										'vc_plugin' => array(
											'name'                    => __( 'Forums Index', 'wm_domain' ),
											'base'                    => 'bbp-forum-index',
											'class'                   => 'wm-shortcode-vc-bbp-forum-index',
											'category'                => __( 'Forum', 'wm_domain' ),
											'show_settings_on_create' => false,
											'params'                  => array(
													10 => array(
														'heading'     => '<a href="http://codex.bbpress.org/shortcodes/" target="_blank"><strong>' . __( 'bbPress Shortcode', 'wm_domain' ) . '</strong></a>',
														'description' => __( 'This will display your entire forum index. No parameters to be set.', 'wm_domain' ),
														'type'        => 'wm_html',
														'param_name'  => 'forums',
														'value'       => '',
														'holder'      => 'hidden',
														'class'       => '',
													),
												)
										)
									);
						}

					//WooCommerce shortcodes
						if ( class_exists( 'Woocommerce' ) ) {
							//Product categories
								$definitions['product_categories'] = array(
										'vc_plugin' => array(
											'name'                    => __( 'Product Categories', 'wm_domain' ),
											'base'                    => 'product_categories',
											'class'                   => 'wm-shortcode-vc-product_categories',
											'category'                => __( 'Shop', 'wm_domain' ),
											'show_settings_on_create' => false,
											'params'                  => array(
													10 => array(
														'heading'     => __( 'Count', 'wm_domain' ),
														'description' => '',
														'type'        => 'textfield',
														'param_name'  => 'number',
														'value'       => '',
														'holder'      => 'hidden',
														'class'       => '',
													),
													20 => array(
														'heading'     => __( 'Columns', 'wm_domain' ),
														'description' => '',
														'type'        => 'dropdown',
														'param_name'  => 'columns',
														'value'       => array(
																3 => 3,
																4 => 4,
																5 => 5,
															),
														'holder'      => 'hidden',
														'class'       => '',
													),
												)
										)
									);

							//Single product category
								$definitions['product_category'] = array(
										'vc_plugin' => array(
											'name'                    => __( 'Product Category', 'wm_domain' ),
											'base'                    => 'product_category',
											'class'                   => 'wm-shortcode-vc-product_category',
											'category'                => __( 'Shop', 'wm_domain' ),
											'show_settings_on_create' => true,
											'params'                  => array(
													10 => array(
														'heading'     => __( 'Category', 'wm_domain' ),
														'description' => '',
														'type'        => 'dropdown',
														'param_name'  => 'category',
														'value'       => array_flip( wma_taxonomy_array( array(
																									'all_post_type' => 'product',
																									'all_text'      => '',
																									'hierarchical'  => '0',
																									'tax_name'      => 'product_cat'
																								) )
																							),
														'holder'      => 'hidden',
														'class'       => '',
													),
													20 => array(
														'heading'     => __( 'Number of products per page', 'wm_domain' ),
														'description' => '',
														'type'        => 'textfield',
														'param_name'  => 'per_page',
														'value'       => '',
														'holder'      => 'hidden',
														'class'       => '',
													),
													30 => array(
														'heading'     => __( 'Columns', 'wm_domain' ),
														'description' => '',
														'type'        => 'dropdown',
														'param_name'  => 'columns',
														'value'       => array(
																3 => 3,
																4 => 4,
																5 => 5,
															),
														'holder'      => 'hidden',
														'class'       => '',
													),
												)
										)
									);

							//Recent products
								$definitions['recent_products'] = array(
										'vc_plugin' => array(
											'name'                    => __( 'Recent Products', 'wm_domain' ),
											'base'                    => 'recent_products',
											'class'                   => 'wm-shortcode-vc-recent_products',
											'category'                => __( 'Shop', 'wm_domain' ),
											'show_settings_on_create' => true,
											'params'                  => array(
													10 => array(
														'heading'     => __( 'Number of products per page', 'wm_domain' ),
														'description' => '',
														'type'        => 'textfield',
														'param_name'  => 'per_page',
														'value'       => '',
														'holder'      => 'hidden',
														'class'       => '',
													),
													20 => array(
														'heading'     => __( 'Columns', 'wm_domain' ),
														'description' => '',
														'type'        => 'dropdown',
														'param_name'  => 'columns',
														'value'       => array(
																3 => 3,
																4 => 4,
																5 => 5,
															),
														'holder'      => 'hidden',
														'class'       => '',
													),
												)
										)
									);

							//Featured products
								$definitions['featured_products'] = array(
										'vc_plugin' => array(
											'name'                    => __( 'Featured Products', 'wm_domain' ),
											'base'                    => 'featured_products',
											'class'                   => 'wm-shortcode-vc-featured_products',
											'category'                => __( 'Shop', 'wm_domain' ),
											'show_settings_on_create' => true,
											'params'                  => array(
													10 => array(
														'heading'     => __( 'Number of products per page', 'wm_domain' ),
														'description' => '',
														'type'        => 'textfield',
														'param_name'  => 'per_page',
														'value'       => '',
														'holder'      => 'hidden',
														'class'       => '',
													),
													20 => array(
														'heading'     => __( 'Columns', 'wm_domain' ),
														'description' => '',
														'type'        => 'dropdown',
														'param_name'  => 'columns',
														'value'       => array(
																3 => 3,
																4 => 4,
																5 => 5,
															),
														'holder'      => 'hidden',
														'class'       => '',
													),
												)
										)
									);
						}

				//Output
					return $definitions;
			} // /wm_modify_shortcodes_definitions

			add_filter( 'wmhook_shortcode_definitions', 'wm_modify_shortcodes_definitions', 10 );



		/**
		 * Enable Visual Composer for custom post types
		 */

			//Set post types, where Visual Composer should be always enabled
				$vc_post_types = array(
						'page',
						'wm_projects',
					);

			//Comparing and altering the Visual Composer settings
				$vc_post_types_diff = array_diff( $vc_post_types, (array) get_option( 'wpb_js_content_types' ) );

				if ( ! empty( $vc_post_types_diff ) ) {
					$vc_post_types_new = array_filter( array_merge( (array) get_option( 'wpb_js_content_types' ), $vc_post_types_diff ) );
					update_option( 'wpb_js_content_types', $vc_post_types_new );
				}



		/**
		 * Add custom Visual Composer templates
		 *
		 * Please note that this procedure works with Visual Composer version 4.3 and above.
		 *
		 * @since  1.1
		 */
		if ( function_exists( 'vc_add_default_templates' ) ) {
			$wm_custom_vc_templates = array(
				'project-simple' => array(
						'name'    => __( 'Project - Simple', 'wm_domain' ),
						'content' => '[vc_row][vc_column width="1/3"][wm_text_block]Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.[/wm_text_block][wm_divider type="dashed"][wm_accordion behaviour="accordion" active="1"][wm_item title="Client"][wm_text_block]<p><strong>Company Name</strong></p><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p><p><a href="http://www.wordpress.org" target="_blank">www.wordpress.org</a></p>[/wm_text_block][/wm_item][wm_item title="Our Task"][wm_text_block]Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.[/wm_text_block][/wm_item][wm_item title="Skills Required"][wm_text_block]<p><strong>Skills involved:</strong></p><ul><li>Lorem ipsum dolor sit amet</li><li>Ut wisi enim ad minim veniam</li><li>Duis autem vel eum</li><li>Nam liber tempor cum soluta</li><li>Typi non habent claritatem insitam</li></ul>[/wm_text_block][/wm_item][/wm_accordion][/vc_column][vc_column width="2/3"][wm_video src="http://vimeo.com/67658001" class="frame bottom-shadow"][/vc_column][/vc_row][vc_row bg_color="#f6f6f6" class="border-top inner-shadow"][vc_column width="1/1"][wm_posts post_type="wm_projects" count="3" columns="3" order="random" align="left" layout="simple" related="project_category"]<h3><strong>Related</strong> projects</h3><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>[/wm_posts][/vc_column][/vc_row]',
					),
				'project-complex' => array(
						'name'    => __( 'Project - Complex', 'wm_domain' ),
						'content' => '[vc_row disable_container="1"][vc_column width="1/1"][layerslider_vc id="1"][/vc_column][/vc_row][vc_row class="border-top"][vc_column width="1/2" class="animation-fadeInLeftBig"][wm_separator_heading tag="h2" align="right"]The Chalenge[/wm_separator_heading][wm_text_block class="text-right"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.[/wm_text_block][/vc_column][vc_column width="1/2" class="animation-fadeInRightBig"][wm_separator_heading tag="h2" align="left"]The Solution[/wm_separator_heading][wm_text_block]Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit.[/wm_text_block][/vc_column][/vc_row][vc_row parallax="0.1" padding="200px 0" class="text-center" bg_image="82"][vc_column width="1/1"][wm_text_block]<h2 class="heading-style-1"><strong>Complete</strong> Corporate Branding</h2>[/wm_text_block][wm_divider type="line"][wm_button url="#" color="green" size="xl" icon="icon-award"]Contact Us Today![/wm_button][/vc_column][/vc_row][vc_row class="border-top"][vc_column width="1/2"][wm_separator_heading tag="h2" align="left"]<strong>Client</strong> Details[/wm_separator_heading][wm_text_block]<img class="alignleft" alt="" src="http://placehold.it/150x150" width="150" height="150" /><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p><p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>[/wm_text_block][/vc_column][vc_column width="1/2"][wm_separator_heading tag="h2" align="left"]More <strong>Info</strong>[/wm_separator_heading][wm_tabs layout="right" active="1"][wm_item title="Some info" icon="icon-help-circled"][wm_text_block]Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.[/wm_text_block][/wm_item][wm_item title="More info" icon="icon-info-circled"][wm_text_block]Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.[/wm_text_block][/wm_item][wm_item title="Yet another one" icon="icon-thumbs-up-alt"][wm_text_block]Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.[/wm_text_block][wm_message color="blue" size="s" icon="icon-basket"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.[/wm_message][/wm_item][/wm_tabs][/vc_column][/vc_row][vc_row class="background-color-accent" font_color="#ffffff"][vc_column width="2/3"][wm_image src="89" class="animation-bounceInLeft"][/vc_column][vc_column width="1/3"][wm_divider type="whitespace"][wm_text_block]<h3><strong>WordPress</strong> Design</h3><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>[/wm_text_block][wm_divider type="whitespace" space_before="30"][wm_button url="#" color="green" size="l"]Contact Us[/wm_button][/vc_column][/vc_row][vc_row font_color="#ffffff" parallax="0.1" bg_image="91"][vc_column width="1/1"][wm_content_module multiple="1" count="4" columns="4" order="new" tag="features" align="left" class="text-center"][/wm_content_module][/vc_column][/vc_row][vc_row class="animation-flipInX" disable_container="1"][vc_column width="1/1"][wm_posts post_type="wm_projects" count="8" columns="4" order="new" align="left" layout="simple" no_margin="1"][/wm_posts][/vc_column][/vc_row]',
					),
				);

			foreach ( $wm_custom_vc_templates as $template ) {
				vc_add_default_templates( (array) $template );
			}
		} // check if vc_add_default_templates() exists

	} // /wma_is_active_vc() check

?>