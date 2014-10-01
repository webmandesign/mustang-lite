<?php
/**
 * Widget Areas Generator
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Widget Areas Generator
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.2.1
 *
 * CONTENT:
 * - 1) Required files
 * - 10) Actions and filters
 * - 10) Widget areas registration
 */





/**
 * 1) Required files
 */

	//Add widgets
		locate_template( WM_SETUP_DIR . 'widgets/w-contact.php', true );
		locate_template( WM_SETUP_DIR . 'widgets/w-module.php',  true );
		locate_template( WM_SETUP_DIR . 'widgets/w-posts.php',   true );
		locate_template( WM_SETUP_DIR . 'widgets/w-subnav.php',  true );
		locate_template( WM_SETUP_DIR . 'widgets/w-twitter.php', true );
		if ( function_exists( 'wma_amplifier' ) ) {
			locate_template( WM_SETUP_DIR . 'widgets/w-tabbed-widgets.php', true );
		}





/**
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		//Register widget areas
			add_action( 'widgets_init', 'wm_register_widget_areas', 1 );



	/**
	 * Filters
	 */

		//Remove esc_html() from widget title
			remove_filter( 'widget_title', 'esc_html' );





/**
 * 10) Widget areas registration
 */

	/**
	 * Register predefined widget areas (sidebars)
	 *
	 * @since  1.2.1
	 */
	if ( ! function_exists( 'wm_register_widget_areas' ) ) {
		function wm_register_widget_areas() {
			foreach( wm_helper_var( 'widget-areas' ) as $area ) {
				register_sidebar( array(
						'name'          => $area['name'],
						'id'            => $area['id'],
						'description'   => $area['description'],
						'before_widget' => $area['before_widget'],
						'after_widget'  => $area['after_widget'],
						'before_title'  => $area['before_title'],
						'after_title'   => $area['after_title']
					) );
			}
		}
	} // /wm_register_widget_areas

?>