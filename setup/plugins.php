<?php
/**
 * Plugins Installation and Activation
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Plugins
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.4
 *
 * CONTENT:
 * - 10) Actions and filters
 * - 20) Funcions
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
 * 20) Funcions
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

					/**
					 * WordPress Repository plugins
					 */

						//Recommended

							'wma' => array(
								'name'     => 'WebMan Amplifier',
								'slug'     => 'webman-amplifier',
								'required' => false,
								'version'  => '1.1.6',
							),
							'ws' => array(
								'name'     => 'WooSidebars',
								'slug'     => 'woosidebars',
								'required' => false,
							),
							'bnxt' => array(
								'name'     => 'Breadcrumb NavXT',
								'slug'     => 'breadcrumb-navxt',
								'required' => false,
							),
							'ms' => array(
								'name'     => 'Master Slider - Responsive Touch Slider',
								'slug'     => 'master-slider',
								'required' => false,
							),
							'cei' => array(
								'name'     => 'Customizer Export/Import',
								'slug'     => 'customizer-export-import',
								'required' => false,
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

?>