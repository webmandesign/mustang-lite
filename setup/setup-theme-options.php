<?php
/**
 * Theme Options
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  WebMan Options Panel
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.5.1
 *
 * CONTENT:
 * - 10) Actions and filters
 * - 20) Array functions
 */





/**
 * 10) Actions and filters
 */

	/**
	 * Filters
	 */

		//CSS file generator replacements
			add_filter( 'wmhook_generate_css_replacements', 'wm_generate_css_replacements', 10 );
		//Contextual help texts
			add_filter( 'wmhook_wm_help_texts_array', 'wm_contextual_help_texts', 10 );
		//$wm_skin_design
			add_filter( 'wmhook_theme_options_skin_array', 'wm_theme_options_skin_array', 10 );





/**
 * 20) Array functions
 */

	/**
	 * CSS generator replacements
	 *
	 * @since    1.0
	 * @version  1.5
	 *
	 * @param  array $replacements
	 */
	if ( ! function_exists( 'wm_generate_css_replacements' ) ) {
		function wm_generate_css_replacements( $replacements = array() ) {
			//Preparing output
				$replacements = array(

						'/* End of file */'             => "\r\n\r\n",
						'/*(*/'                         => '/** ', // Open a comment
						'/*)*/'                         => ' **/', // Close a comment
						'/*//'                          => '', // Remove a comment opening
						'//*/'                          => '', // Remove a comment closing

						'___get_template_directory_uri' => str_replace( array( 'http:', 'https:' ), '', untrailingslashit( get_template_directory_uri() ) ),
						'___theme_assets_url'           => str_replace( array( 'http:', 'https:' ), '', trailingslashit( get_template_directory_uri() ) . 'assets' ),

						'___accent_color'               => '#3b5998',
						'___bg_color_brighter'          => '#f6f6f6',
						'___border_color'               => '#e3e3e3',

					);

			//Output
				return $replacements;
		}
	} // /wm_generate_css_replacements



	/**
	 * Set $wm_options array
	 *
	 * @version  1.5.1
	 *
	 * @param  array $wm_options
	 */
	if ( ! function_exists( 'wm_contextual_help_texts' ) ) {
		function wm_contextual_help_texts( $help_texts = array() ) {
			//Helper variables
				global $wpdb;

			//Preparing output

				/**
				 * Support / troubleshooting
				 */

					//Support table content
						$support_table_content = '
							<thead>
								<tr>
									<th colspan="2">' . __( 'WordPress and Theme', 'wm_domain_support' ) . '</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th>' . __( 'WP Version', 'wm_domain_support' ) . ':</th>
									<td>' . get_bloginfo( 'version' ) . '</td>
								</tr>
								<tr>
									<th>' . __( 'WP Multisite Enabled', 'wm_domain_support' ) . ':</th>
									<td>' . ( ( is_multisite() ) ? ( __( 'Yes', 'wm_domain_support' ) ) : ( __( 'No', 'wm_domain_support' ) ) ) . '</td>
								</tr>
								<tr>
									<th>' . __( 'WP Language', 'wm_domain_support' ) . ':</th>
									<td>' . ( ( defined( 'WPLANG' ) && WPLANG ) ? ( WPLANG ) : ( __( 'Default', 'wm_domain_support' ) ) ) . '</td>
								</tr>
								<tr>
									<th>' . __( 'Home URL', 'wm_domain_support' ) . ':</th>
									<td>' . home_url() . '</td>
								</tr>
								<tr>
									<th>' . __( 'Site URL', 'wm_domain_support' ) . ':</th>
									<td>' . site_url() . '</td>
								</tr>
								<tr>
									<th>' . __( 'Theme Name', 'wm_domain_support' ) . ':</th>
									<td>' . WM_THEME_NAME . '</td>
								</tr>
								<tr>
									<th>' . __( 'Theme Shortname', 'wm_domain_support' ) . ':</th>
									<td>' . WM_THEME_SHORTNAME . '</td>
								</tr>
								<tr>
									<th>' . __( 'Theme Version', 'wm_domain_support' ) . ':</th>
									<td>' . WM_THEME_VERSION . '</td>
								</tr>
								<tr>
									<th>' . __( 'WP Debug Mode', 'wm_domain_support' ) . ':</th>
									<td>' . ( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? ( __( 'Yes', 'wm_domain_support' ) ) : ( __( 'No', 'wm_domain_support' ) ) ) . '</td>
								</tr>
								<tr>
									<th>' . __( 'WP Memory Limit', 'wm_domain_support' ) . ':</th>
									<td>' . WP_MEMORY_LIMIT . '</td>
								</tr>
								<tr>
									<th>' . __( 'WP Max Upload Size', 'wm_domain_support' ) . ':</th>
									<td>' . size_format( wp_max_upload_size() ) . '</td>
								</tr>
							</tbody>
							<thead>
								<tr>
									<th colspan="2">' . __( 'Server Info', 'wm_domain_support' ) . '</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th>' . __( 'Web Server Info', 'wm_domain_support' ) . ':</th>
									<td>' . esc_html( $_SERVER['SERVER_SOFTWARE'] ) . '</td>
								</tr>
								<tr>
									<th>' . __( 'PHP Version', 'wm_domain_support' ) . ':</th>
									<td>' . ( ( function_exists( 'phpversion' ) ) ? ( esc_html( phpversion() ) ) : ( '-' ) ) . '</td>
								</tr>
								<tr>
									<th>' . __( 'MySQL Version', 'wm_domain_support' ) . ':</th>
									<td>' . $wpdb->db_version() . '</td>
								</tr>
							</tbody>';

						if ( function_exists( 'ini_get' ) ) {
							$support_table_content .= '
									<tr>
										<th>' . __( 'PHP memory_limit', 'wm_domain_support' ) . ':</th>
										<td>' . ini_get( 'memory_limit' ) . '</td>
									</tr>
									<tr>
										<th>' . __( 'PHP post_max_size', 'wm_domain_support' ) . ':</th>
										<td>' . ini_get( 'post_max_size' ) . '</td>
									</tr>
									<tr>
										<th>' . __( 'PHP upload_max_filesize', 'wm_domain_support' ) . ':</th>
										<td>' . ini_get( 'upload_max_filesize' ) . '</td>
									</tr>
									<tr>
										<th>' . __( 'PHP max_execution_time', 'wm_domain_support' ) . ':</th>
										<td>' . ini_get( 'max_execution_time' ) . '</td>
									</tr>
									<tr>
										<th>' . __( 'PHP max_input_vars', 'wm_domain_support' ) . ':</th>
										<td>' . ini_get( 'max_input_vars' ) . '</td>
									</tr>';
						}

						$support_table_content .= '</tbody>';

					//Setting $help_texts array
						$help_texts['themes'] = array(
								array(
									'tab-id'      => 'wm-support',
									'tab-title'   => __( 'Support and troubleshooting', 'wm_domain' ),
									'tab-content' => '<p>' . sprintf( __( 'If you have any difficulties with the theme or need a help customizing it, please visit the %s.<br />The troubleshooting information below may be requested by support staff to resolve your query. Please, provide them when asked.', 'wm_domain' ), '<a href="' . WM_SUPPORT_URL . '/forums/forum/' . WM_THEME_SHORTNAME . '" target="_blank">WebMan Support Forum</a>' )  . '</p><table class="wm-table">' . $support_table_content . '</table>',
								)
							);

			//Output
				return $help_texts;
		}
	} // /wm_contextual_help_texts



	/**
	 * Set $wm_skin_design array
	 *
	 * @since    1.0
	 * @version  1.5
	 *
	 * @param  array $wm_skin_design
	 */
	if ( ! function_exists( 'wm_theme_options_skin_array' ) ) {
		function wm_theme_options_skin_array( $wm_skin_design = array() ) {
			//Preparing output

				/**
				 * Theme customizer options array
				 */

					$prefix = 'skin-';

					$wm_skin_design = array(


						/**
						 * Top Bar
						 */
						'topbar' => array(
							'type'           => 'section',
							'create_section' => __( 'Section: Top Bar', 'wm_domain' ),
							'in_panel'       => _x( 'Theme', 'Customizer panel title.', 'wm_domain' ),
						),

							'topbar' . 10 => array(
								'type'    => 'html',
								'content' => '<p class="description">' . __( 'These settings will affect both Topbar Widgets and Topbar Extra Widgets areas.', 'wm_domain' ) . '</p>',
							),

								'topbar' . 20 => array(
									'type'  => 'color',
									'id'    => $prefix . 'topbar' . '-color',
									'label' => __( 'Text color', 'wm_domain' ),
								),
								'topbar' . 30 => array(
									'type'  => 'color',
									'id'    => $prefix . 'topbar' . '-accent-color',
									'label' => __( 'Accent color', 'wm_domain' ),
								),
								'topbar' . 40 => array(
									'type'  => 'color',
									'id'    => $prefix . 'topbar' . '-border-color',
									'label' => __( 'Borders color', 'wm_domain' ),
								),
								'topbar' . 50 => array(
									'type'  => 'background',
									'id'    => $prefix . 'topbar'
								),

							'topbar-extra' . 10 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Topbar Extra widgets', 'wm_domain' ) . '</h3>',
							),

								'topbar-extra' . 20 => array(
									'type'  => 'color',
									'id'    => $prefix . 'topbar-extra' . '-color',
									'label' => __( 'Text color', 'wm_domain' ),
								),
								'topbar-extra' . 30 => array(
									'type'  => 'color',
									'id'    => $prefix . 'topbar-extra' . '-accent-color',
									'label' => __( 'Accent color', 'wm_domain' ),
								),
								'topbar-extra' . 40 => array(
									'type'  => 'color',
									'id'    => $prefix . 'topbar-extra' . '-border-color',
									'label' => __( 'Borders color', 'wm_domain' ),
								),
								'topbar-extra' . 50 => array(
									'type'  => 'color',
									'id'    => $prefix . 'topbar-extra' . '-bg-color',
									'label' => __( 'Background color', 'wm_domain' ),
								),



						/**
						 * Header
						 */
						'header' => array(
							'type'           => 'section',
							'create_section' => __( 'Section: Header', 'wm_domain' ),
							'in_panel'       => _x( 'Theme', 'Customizer panel title.', 'wm_domain' ),
						),

							'header' . 10 => array(
								'type'    => 'select',
								'id'      => $prefix . 'header' . '-shadow',
								'label'   => __( 'Header shadow', 'wm_domain' ),
								'options' => array(
										''  => __( 'No shadow', 'wm_domain' ),
										'1' => __( 'Display shadow', 'wm_domain' )
									),
							),
							'header' . 20 => array(
								'type'  => 'checkbox',
								'id'    => $prefix . 'header' . '-sticky',
								'label' => __( 'Sticky header', 'wm_domain' ),
							),

							'header' . 30 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Design', 'wm_domain' ) . '</h3>',
							),

								'header' . 40 => array(
									'type'  => 'color',
									'id'    => $prefix . 'header' . '-color',
									'label' => __( 'Text color', 'wm_domain' ),
								),
								'header' . 50 => array(
									'type'  => 'color',
									'id'    => $prefix . 'header' . '-accent-color',
									'label' => __( 'Accent color', 'wm_domain' ),
								),
								'header' . 60 => array(
									'type'  => 'color',
									'id'    => $prefix . 'header' . '-border-color',
									'label' => __( 'Borders color', 'wm_domain' ),
								),
								'header' . 70 => array(
									'type'  => 'background',
									'id'    => $prefix . 'header',
								),

							'header' . 140 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Navigation design', 'wm_domain' ) . '</h3>',
							),

								'header' . 150 => array(
									'type'    => 'html',
									'content' => '<p class="description">' . __( 'Navigation padding will affect the header height and logo position.', 'wm_domain' ) . '</p>',
								),
									'header' . 160 => array(
										'type'    => 'range',
										'id'      => $prefix . 'nav' . '-padding',
										'label'   => __( 'Navigation padding', 'wm_domain' ),
										'default' => 25,
										'min'     => 0,
										'max'     => 60,
										'step'    => 1,
										'zero'    => true,
									),

								'header' . 170 => array(
									'type'  => 'color',
									'id'    => $prefix . 'nav' . '-color',
									'label' => __( 'Subnav text color', 'wm_domain' ),
								),
								'header' . 180 => array(
									'type'  => 'color',
									'id'    => $prefix . 'nav' . '-border-color',
									'label' => __( 'Borders color', 'wm_domain' ),
								),
								'header' . 190 => array(
									'type'  => 'color',
									'id'    => $prefix . 'nav' . '-bg-color',
									'label' => __( 'Subnav background', 'wm_domain' ),
								),
									'header' . 200 => array(
										'type'    => 'html',
										'content' => '<p class="description">' . __( 'Subnav colors will be also used to style the mobile navigation.', 'wm_domain' ) . '</p>',
									),



						/**
						 * Special Slider
						 */
						'range' => array(
							'type'           => 'section',
							'create_section' => __( 'Section: Special Slider', 'wm_domain' ),
							'in_panel'       => _x( 'Theme', 'Customizer panel title.', 'wm_domain' ),
						),

							'range' . 10 => array(
								'type'  => 'color',
								'id'    => $prefix . 'range' . '-color',
								'label' => __( 'Text color', 'wm_domain' ),
							),
							'range' . 20 => array(
								'type'  => 'color',
								'id'    => $prefix . 'range' . '-accent-color',
								'label' => __( 'Accent color', 'wm_domain' ),
							),
							'range' . 30 => array(
								'type'  => 'color',
								'id'    => $prefix . 'range' . '-border-color',
								'label' => __( 'Borders color', 'wm_domain' ),
							),
							'range' . 40 => array(
								'type'  => 'color',
								'id'    => $prefix . 'range' . '-bg-color',
								'label' => __( 'Background color', 'wm_domain' ),
							),



						/**
						 * Main Heading
						 */
						'heading' => array(
							'type'           => 'section',
							'create_section' => __( 'Section: Main Heading', 'wm_domain' ),
							'in_panel'       => _x( 'Theme', 'Customizer panel title.', 'wm_domain' ),
						),

							'heading' . 10 => array(
								'type'  => 'color',
								'id'    => $prefix . 'heading' . '-color',
								'label' => __( 'Text color', 'wm_domain' ),
							),
							'heading' . 20 => array(
								'type'  => 'color',
								'id'    => $prefix . 'heading' . '-accent-color',
								'label' => __( 'Accent color', 'wm_domain' ),
							),
							'heading' . 30 => array(
								'type'  => 'color',
								'id'    => $prefix . 'heading' . '-border-color',
								'label' => __( 'Borders color', 'wm_domain' ),
							),
							'heading' . 40 => array(
								'type'  => 'background',
								'id'    => $prefix . 'heading',
							),



						/**
						 * Content Area
						 */
						'content' => array(
							'type'           => 'section',
							'create_section' => __( 'Section: Content', 'wm_domain' ),
							'in_panel'       => _x( 'Theme', 'Customizer panel title.', 'wm_domain' ),
						),

							'content' . 10 => array(
								'type'    => 'select',
								'id'      => $prefix . 'sidebar' . '-position',
								'label'   => __( 'Sidebar position', 'wm_domain' ),
								'options' => array(
										'left'  => __( 'Left', 'wm_domain' ),
										'right' => __( 'Right', 'wm_domain' )
									),
								'default' => WM_DEFAULT_SIDEBAR_POSITION,
							),
							'content' . 20 => array(
								'type'    => 'select',
								'id'      => $prefix . 'sidebar' . '-width',
								'label'   => __( 'Sidebar width', 'wm_domain' ),
								'options' => array(
										' pane three; pane nine'                => __( '1/4 sidebar', 'wm_domain' ),
										' pane four; pane eight'                => __( '1/3 sidebar', 'wm_domain' ),
										' pane golden-narrow; pane golden-wide' => __( 'Golden ratio', 'wm_domain' ),
									),
								'default' => WM_DEFAULT_SIDEBAR_WIDTH,
							),

							'content' . 30 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Design', 'wm_domain' ) . '</h3>',
							),

								'content' . 40 => array(
									'type'  => 'color',
									'id'    => $prefix . 'content' . '-color',
									'label' => __( 'Text color', 'wm_domain' ),
								),
								'content' . 50 => array(
									'type'  => 'color',
									'id'    => $prefix . 'content' . '-accent-color',
									'label' => __( 'Accent color', 'wm_domain' ),
								),
								'content' . 60 => array(
									'type'  => 'color',
									'id'    => $prefix . 'content' . '-border-color',
									'label' => __( 'Borders color', 'wm_domain' ),
								),
								'content' . 70 => array(
									'type'  => 'background',
									'id'    => $prefix . 'content',
								),



						/**
						 * Footer
						 */
						'footer' => array(
							'type'           => 'section',
							'create_section' => __( 'Section: Footer', 'wm_domain' ),
							'in_panel'       => _x( 'Theme', 'Customizer panel title.', 'wm_domain' ),
						),

							'footer' . 10 => array(
								'type'    => 'html',
								'content' => '<p class="description">' . __( 'Footer consists of footer widgets area and credits (copyright) widgets area. Set the footer widgets layout below and backgrounds for both footer areas.', 'wm_domain' ) . '</p>',
							),

							'header' . 15 => array(
								'type'    => 'select',
								'id'      => $prefix . 'footer' . '-shadow',
								'label'   => __( 'Footer shadow', 'wm_domain' ),
								'options' => array(
										''  => __( 'No shadow', 'wm_domain' ),
										'1' => __( 'Display shadow', 'wm_domain' )
									),
							),

							'footer' . 20 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Footer widgets', 'wm_domain' ) . '</h3>',
							),

								'footer' . 30 => array(
									'type'    => 'select',
									'id'      => $prefix . 'footer-widgets' . '-layout',
									'label'   => __( 'Footer widgets layout', 'wm_domain' ),
									'options' => array(
											1 => __( '1 column', 'wm_domain' ),
											2 => __( '2 columns', 'wm_domain' ),
											3 => __( '3 columns', 'wm_domain' ),
											4 => __( '4 columns', 'wm_domain' ),
											5 => __( '5 columns', 'wm_domain' ),
										),
								),
									'footer' . 40 => array(
										'type'    => 'html',
										'content' => '<p class="description">' . __( 'Footer widgets will be layed out into columns using masonry script.', 'wm_domain' ) . '</p>',
									),

								'footer' . 50 => array(
									'type'  => 'color',
									'id'    => $prefix . 'footer-widgets' . '-color',
									'label' => __( 'Text color', 'wm_domain' ),
								),
								'footer' . 60 => array(
									'type'  => 'color',
									'id'    => $prefix . 'footer-widgets' . '-accent-color',
									'label' => __( 'Accent color', 'wm_domain' ),
								),
								'footer' . 70 => array(
									'type'  => 'color',
									'id'    => $prefix . 'footer-widgets' . '-border-color',
									'label' => __( 'Borders color', 'wm_domain' ),
								),
								'footer' . 80 => array(
									'type'  => 'background',
									'id'    => $prefix . 'footer-widgets',
								),

							'footer' . 150 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Credits', 'wm_domain' ) . '</h3>',
							),

								'footer' . 160 => array(
									'type'  => 'color',
									'id'    => $prefix . 'credits' . '-color',
									'label' => __( 'Text color', 'wm_domain' ),
								),
								'footer' . 170 => array(
									'type'  => 'color',
									'id'    => $prefix . 'credits' . '-accent-color',
									'label' => __( 'Accent color', 'wm_domain' ),
								),
								'footer' . 180 => array(
									'type'  => 'color',
									'id'    => $prefix . 'credits' . '-border-color',
									'label' => __( 'Borders color', 'wm_domain' ),
								),
								'footer' . 190 => array(
									'type'  => 'background',
									'id'    => $prefix . 'credits',
								),



						/**
						 * Website Background
						 */
						'website-background' => array(
							'type'           => 'section',
							'create_section' => __( 'Background', 'wm_domain' ),
							'in_panel'       => _x( 'Theme', 'Customizer panel title.', 'wm_domain' ),
						),

							'website-background' . 5 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Website background', 'wm_domain' ) . '</h3>'
									. '<p class="description">' . __( 'Please note that this background is only visible when using boxed theme layout (set this under "Setup" section).', 'wm_domain' ) . '</p>',
							),

								'website-background' . 10 => array(
									'type' => 'background',
									'id'   => $prefix . 'html',
								),



						/**
						 * Global colors
						 */
						'colors-global' => array(
							'type'           => 'section',
							'create_section' => __( 'Colors', 'wm_domain' ),
							'in_panel'       => _x( 'Theme', 'Customizer panel title.', 'wm_domain' ),
						),

							'colors-global' . 10 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Global colors', 'wm_domain' ) . '</h3>',
							),

								'colors-global' . 20 => array(
									'type'  => 'color',
									'id'    => $prefix . 'accent-color',
									'label' => __( 'Accent color', 'wm_domain' ),
								),
									'colors-global' . 30 => array(
										'type'    => 'html',
										'content' => '<p class="description">' . __( 'Accent color is being used globally throughout the whole theme. All of theme design colors are being calculated automatically based on this color, so if you only want the basic theme design, just set this color. If you need to tweak the design settings, feel free to explore theme sections options below.', 'wm_domain' ) . '</p>',
									),

								//blue
									'colors-global' . 40 => array(
										'type'  => 'color',
										'id'    => $prefix . 'blue-color',
										'label' => __( 'General blue color', 'wm_domain' ),
									),
								//gray
									'colors-global' . 50 => array(
										'type'  => 'color',
										'id'    => $prefix . 'gray-color',
										'label' => __( 'General gray color', 'wm_domain' ),
									),
								//green
									'colors-global' . 60 => array(
										'type'  => 'color',
										'id'    => $prefix . 'green-color',
										'label' => __( 'General green color', 'wm_domain' ),
									),
								//orange
									'colors-global' . 70 => array(
										'type'  => 'color',
										'id'    => $prefix . 'orange-color',
										'label' => __( 'General orange color', 'wm_domain' ),
									),
								//red
									'colors-global' . 80 => array(
										'type'  => 'color',
										'id'    => $prefix . 'red-color',
										'label' => __( 'General red color', 'wm_domain' ),
									),

							'colors-global' . 90 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Color treshold', 'wm_domain' ) . '</h3>',
							),

								'colors-global' . 100 => array(
									'type'    => 'range',
									'id'      => $prefix . 'text-color-treshold',
									'label'   => __( 'Auto color treshold', 'wm_domain' ),
									'default' => 0,
									'min'     => -50,
									'max'     => 50,
									'step'    => 1,
								),
									'colors-global' . 110 => array(
										'type'    => 'html',
										'content' => '<p class="description">' . __( 'Auto color treshold is being used to automatically calculate the additional colors in the theme (such as text color from the background color). You can tweak the calculation treshold here.', 'wm_domain' ) . '</p>',
									),



						/**
						 * Branding
						 */
						'branding' => array(
							'type'           => 'section',
							'create_section' => __( 'Logo', 'wm_domain' ),
							'in_panel'       => _x( 'Theme', 'Customizer panel title.', 'wm_domain' ),
						),

							'branding' . 10 => array(
								'type'  => 'image',
								'id'    => $prefix . 'logo',
								'label' => __( 'Logo', 'wm_domain' ),
							),
							'branding' . 20 => array(
								'type'  => 'image',
								'id'    => $prefix . 'logo-hidpi',
								'label' => __( 'High DPI logo', 'wm_domain' ),
							),



						/**
						 * Images
						 */
						'images' => array(
							'type'           => 'section',
							'create_section' => __( 'Images', 'wm_domain' ),
							'in_panel'       => _x( 'Theme', 'Customizer panel title.', 'wm_domain' ),
						),

							'images' . 5 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Lightbox', 'wm_domain' ) . '</h3>',
							),

								'images' . 10 => array(
									'type'    => 'html',
									'content' => '<p class="description">' . __( 'If you use a special image lightbox effect plugin, you should disable the theme native effect below.', 'wm_domain' ) . '</p>',
								),
								'images' . 20 => array(
									'type'  => 'checkbox',
									'id'    => $prefix . 'disable-lightbox',
									'label' => __( 'Disable lightbox effect', 'wm_domain' ),
								),

							'images' . 30 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Image ratios', 'wm_domain' ) . '</h3>',
							),

								'images' . 40 => array(
									'type'    => 'html',
									'content' => '<p class="description">' . __( 'Set up image ratios for the different theme items.', 'wm_domain' ) . '</p>',
								),
								'images' . 50 => array(
									'type'    => 'select',
									'id'      => $prefix . 'image' . '-blog',
									'label'   => __( 'Blog list image', 'wm_domain' ),
									'options' => wm_helper_var( 'image-ratio' ),
								),
								'images' . 60 => array(
									'type'    => 'select',
									'id'      => $prefix . 'image' . '-posts',
									'label'   => __( '[wm_posts] shortcode image', 'wm_domain' ),
									'options' => wm_helper_var( 'image-ratio' ),
								),
								'images' . 70 => array(
									'type'    => 'select',
									'id'      => $prefix . 'image' . '-gallery',
									'label'   => __( '[gallery] shortcode image', 'wm_domain' ),
									'options' => wm_helper_var( 'image-ratio' ),
								),

							'images' . 80 => array(
								'type'    => 'html',
								'content' => '<p class="description">' . __( 'Please decide on, and set the image ratios up for different website sections right after the theme activation. If you change the image sizes later on, the settings will apply only on newly uploaded images - the images you upload after you have made an image ratio change. All previous images will keep their original sizes.', 'wm_domain' ) . '</p><p class="description">' . __( 'If you wish to resize the previously uploaded images to conform the new image ratios, you can use a plugin for this. Recommended plugins are <a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails</a> or <a href="http://wordpress.org/extend/plugins/ajax-thumbnail-rebuild/" target="_blank">AJAX Thumbnail Rebuild</a>.', 'wm_domain' ) . '</p>',
							),



						/**
						 * Fonts
						 */
						'fonts' => array(
							'type'           => 'section',
							'create_section' => __( 'Fonts', 'wm_domain' ),
							'in_panel'       => _x( 'Theme', 'Customizer panel title.', 'wm_domain' ),
						),

							'fonts' . 10 => array(
								'type'    => 'html',
								'content' => '<p class="description">' . __( 'Set the Google Font to be used for website headings and body text. You can additionally set a font subset for different character lists.', 'wm_domain' ) . '</p>',
							),

								'fonts-logo' => array(
									'type'    => 'select',
									'id'      => $prefix . 'font' . '-logo',
									'label'   => __( 'Text logo font', 'wm_domain' ),
									'options' => ( function_exists( 'wma_asort' ) ) ? ( wma_asort( wm_helper_var( 'google-fonts' ) ) ) : ( wm_helper_var( 'google-fonts' ) ),
								),
								'fonts' . 20 => array(
									'type'    => 'select',
									'id'      => $prefix . 'font' . '-headings',
									'label'   => __( 'Headings font', 'wm_domain' ),
									'options' => ( function_exists( 'wma_asort' ) ) ? ( wma_asort( wm_helper_var( 'google-fonts' ) ) ) : ( wm_helper_var( 'google-fonts' ) ),
								),
								'fonts' . 30 => array(
									'type'    => 'select',
									'id'      => $prefix . 'font' . '-body',
									'label'   => __( 'Body text font', 'wm_domain' ),
									'options' => ( function_exists( 'wma_asort' ) ) ? ( wma_asort( wm_helper_var( 'google-fonts' ) ) ) : ( wm_helper_var( 'google-fonts' ) ),
								),

								'fonts' . 40 => array(
									'type'    => 'multiselect',
									'id'      => $prefix . 'font' . '-subset',
									'label'   => __( 'Font subset', 'wm_domain' ),
									'options' => wm_helper_var( 'google-fonts-subset' ),
								),

							'fonts' . 50 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Font sizes', 'wm_domain' ) . '</h3>',
							),

								'fonts' . 60 => array(
									'type'          => 'range',
									'id'            => $prefix . 'font' . '-size-body',
									'label'         => __( 'Basic font size', 'wm_domain' ),
									'default'       => 14,
									'min'           => 10,
									'max'           => 20,
									'step'          => 1,
									'customizer_js' => array(
											'css' => array(
													'html, body' => array( array( 'font-size', 'px' ) ),
												),
										),
								),

								'fonts' . 70 => array(
									'type'    => 'html',
									'content' => '<p class="description">' . __( 'Heading font size is counted from the basic font size. Set the percentage of the basic font size for each heading.', 'wm_domain' ) . '</p>',
								),

									'fonts' . 80 => array(
										'type'          => 'range',
										'id'            => $prefix . 'font' . '-size-h1',
										'label'         => __( 'Heading H1 font size', 'wm_domain' ),
										'default'       => 100,
										'min'           => 75,
										'max'           => 450,
										'step'          => 5,
										'customizer_js' => array(
												'css' => array(
														'h1, .heading-style-1' => array( array( 'font-size', '%' ) ),
													),
											),
									),
									'fonts' . 90 => array(
										'type'          => 'range',
										'id'            => $prefix . 'font' . '-size-h2',
										'label'         => __( 'Heading H2 font size', 'wm_domain' ),
										'default'       => 100,
										'min'           => 75,
										'max'           => 450,
										'step'          => 5,
										'customizer_js' => array(
												'css' => array(
														'h2, .heading-style-2' => array( array( 'font-size', '%' ) ),
													),
											),
									),
									'fonts' . 100 => array(
										'type'          => 'range',
										'id'            => $prefix . 'font' . '-size-h3',
										'label'         => __( 'Heading H3 font size', 'wm_domain' ),
										'default'       => 100,
										'min'           => 75,
										'max'           => 450,
										'step'          => 5,
										'customizer_js' => array(
												'css' => array(
														'h3, .heading-style-3' => array( array( 'font-size', '%' ) ),
													),
											),
									),
									'fonts' . 110 => array(
										'type'          => 'range',
										'id'            => $prefix . 'font' . '-size-h4',
										'label'         => __( 'Heading H4, H5 and H6 font size', 'wm_domain' ),
										'default'       => 100,
										'min'           => 75,
										'max'           => 450,
										'step'          => 5,
										'customizer_js' => array(
												'css' => array(
														'h4, h5, h6, .heading-style-4, .heading-style-5, .heading-style-6' => array( array( 'font-size', '%' ) ),
													),
											),
									),



						/**
						 * Layout
						 */
						'layout' => array(
							'type'           => 'section',
							'create_section' => __( 'Layout', 'wm_domain' ),
							'in_panel'       => _x( 'Theme', 'Customizer panel title.', 'wm_domain' ),
						),

							'layout' . 10 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Layout', 'wm_domain' ) . '</h3>',
							),

								'layout' . 20 => array(
									'type'    => 'select',
									'id'      => $prefix . 'layout',
									'label'   => __( 'Website layout', 'wm_domain' ),
									'options' => array(
											'fullwidth' => __( 'Fullwidth', 'wm_domain' ),
											'boxed'     => __( 'Boxed', 'wm_domain' )
										),
								),

								'layout' . 40 => array(
									'type'          => 'range',
									'id'            => $prefix . 'website-width',
									'label'         => __( 'Website width', 'wm_domain' ),
									'default'       => 1020,
									'min'           => 1020,
									'max'           => 1920,
									'step'          => 20,
									'customizer_js' => array(
											'css' => array(
													'.boxed .wrap, .wrap.boxed, body.boxed.page-meta-layout .wrap, .wrap-inner' => array( array( 'width', 'px' ) ),
												),
										),
								),
									'layout' . 45 => array(
										'type'    => 'html',
										'content' => '<p class="description">' . __( 'The website width is being set up for the boxed layout. The actual website content width would be the website width minus the boxed layout paddings (160px). So if you set the width of 1480, the actual website content width will be 1320px (= 1480 - 160).', 'wm_domain' ) . '</p>',
									),



						/**
						 * Others
						 */
						'others' => array(
							'type'           => 'section',
							'create_section' => __( 'Others', 'wm_domain' ),
							'in_panel'       => _x( 'Theme', 'Customizer panel title.', 'wm_domain' ),
						),

							'others' . 10 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'CSS3 Animations', 'wm_domain' ) . '</h3>',
							),

								'others' . 20 => array(
									'type'  => 'checkbox',
									'id'    => $prefix . 'disable-animatecss',
									'label' => __( 'Disable Animate.css library', 'wm_domain' ),
								),

					);

			//Output
				return $wm_skin_design;
		}
	} // /wm_theme_options_skin_array

?>