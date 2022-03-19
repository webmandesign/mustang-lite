<?php
/**
 * Plugins Installation and Activation
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Plugins
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  2.0.0
 *
 * CONTENT:
 * - 10) Actions and filters
 * - 20) Functions
 */





/**
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		//Include the TGM_Plugin_Activation class.
			add_action( 'tgmpa_register', 'wm_register_required_plugins' );





/**
 * 20) Functions
 */

	/**
	 * Register the required plugins for the theme
	 *
	 * @link  https://github.com/thomasgriffin/TGM-Plugin-Activation/blob/develop/tgm-plugin-activation/example.php
	 */
	if ( ! function_exists( 'wm_register_required_plugins' ) ) {
		function wm_register_required_plugins() {

			/**
			 * Array of plugin arrays. Required keys are name and slug.
			 * If the source is NOT from the .org repo, then source is also required.
			 */
			$plugins = apply_filters( 'wmhook_wm_register_required_plugins', array(

					// Recommended

						'webman-amplifier' => array(
							'name'     => esc_html__( 'WebMan Amplifier (adding theme features)', 'mustang-lite' ),
							'slug'     => 'webman-amplifier',
							'required' => false,
						),

						'beaver-builder' => array(
							'name'        => esc_html__( 'Beaver Builder (easy page builder)', 'mustang-lite' ),
							'slug'        => 'beaver-builder-lite-version',
							'required'    => false,
							'is_callable' => 'FLBuilder::init',
						),

						'one-click-demo-import' => array(
							'name'     => esc_html__( 'One Click Demo Import (for installing theme demo content)', 'mustang-lite' ),
							'slug'     => 'one-click-demo-import',
							'required' => false,
						),

						'classic-widgets' => array(
							'name'        => esc_html_x( 'Classic Widgets', 'Plugin name.', 'mustang-lite' ),
							'description' => esc_html__( 'Improves widgets management screen.', 'mustang-lite' ) . ' ' . esc_html__( 'Restores the previous WordPress widgets settings screens.', 'mustang-lite' ) . ' ' . esc_html__( 'Sidebars and widgets are not going to be used in fully block themes in the future, so if your website still uses sidebars, it is better to use this plugin to enable classic user interface.', 'mustang-lite' ),
							'slug'        => 'classic-widgets',
							'required'    => false,
						),

				) );



			/**
			 * Array of configuration settings
			 */
			$config = apply_filters( 'wmhook_wm_register_required_plugins_config', array() );



			/**
			 * Actual action...
			 */
			tgmpa( $plugins, $config );

		}
	} // /wm_register_required_plugins
