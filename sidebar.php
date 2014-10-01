<?php
/**
 * Sidebar template
 *
 * @package    WebMan WordPress Theme Framework
 * @copyright  2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.2.1
 */



/**
 * Requirements check
 *
 * This is specially for plugins like WooCommerce
 *
 * @since  1.2.1
 */

	if ( function_exists( 'wma_sidebar' ) ) {
		return;
	}



/**
 * Helper variables
 */

	$sidebar_id = 'general';

	$widgets_count = wp_get_sidebars_widgets();
	if ( is_array( $widgets_count ) && isset( $widgets_count[ $sidebar_id ] ) ) {
		$widgets_count = $widgets_count[ $sidebar_id ];
	} else {
		$widgets_count = array();
	}



/**
 * Output
 */

	echo wmhook_sidebars_before();

		echo "\r\n\r\n" . '<aside class="wm-sidebar sidebar widget-area clearfix sidebar-right pane four widgets-count-' . count( $widgets_count ) . '" data-id="' . $sidebar_id . '" data-widgets-count="' . count( $widgets_count ) . '">' . "\r\n";

			echo wmhook_sidebar_top();

			if ( is_active_sidebar( $sidebar_id ) ) {

				dynamic_sidebar( $sidebar_id );

			} else {

				echo '
						<div class="widget widget_search">' . get_search_form( false ) . '</div>

						<div class="widget">
							<h3 class="widget-heading">About Mustang Lite</h3>
							<div class="widget-content">
								<strong>Mustang Lite</strong> WordPress Theme lets you create beautiful, professional business websites. By default you get the basic blog design which can be extended to full power of the theme with additional <a href="http://wordpress.org/plugins/webman-amplifier/" target="_blank"><strong>WebMan Amplifier</strong> plugin installation</a> (see the <a href="http://themedemos.webmandesign.eu/mustang/">full theme demo website</a>). This theme is a free, lite version of premium <a href="https://creativemarket.com/webmandesign/45467-Mustang-Multipurpose-WordPress-Theme?ref=mustang-lite" target="_blank"><strong>Mustang Multipurpose WordPress Theme</strong> by WebMan</a>. The lite version <strong>does not</strong> support WooCommerce eshop plugin, bbPress forums plugin and also does not contain the premium page builder and sliders plugins included in the paid version. Check out themes by WebMan at <a href="http://www.webmandesign.eu">www.webmandesign.eu</a>. Thank you for using Mustang Lite!<br /><br />
								Theme user manual with demo data can be found at <a href="http://www.webmandesign.eu/manual/mustang/">www.webmandesign.eu/manual/mustang/</a>.
							</div>
						</div>
					';

			}

			echo wmhook_sidebar_bottom();

		echo "\r\n" . '</aside>' . "\r\n\r\n";

	echo wmhook_sidebars_after();

?>