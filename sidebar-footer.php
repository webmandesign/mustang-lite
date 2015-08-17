<?php
/**
 * Footer widget area template
 *
 * @package    WebMan WordPress Theme Framework
 * @copyright  2014 WebMan - Oliver Juhas
 *
 * @since    1.1.1
 * @version  1.2.2
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

	$sidebar_id = 'footer-widgets';

	$widgets_count = wp_get_sidebars_widgets();
	if ( is_array( $widgets_count ) && isset( $widgets_count[ $sidebar_id ] ) ) {
		$widgets_count = $widgets_count[ $sidebar_id ];
	} else {
		$widgets_count = array();
	}



/**
 * Output
 */

	echo '<div class="footer-widgets clearfix columns-4 masonry-disabled" data-columns="4"><div class="wrap-inner"><div class="pane twelve">';

		echo wmhook_sidebars_before();

			echo "\r\n\r\n" . '<div class="wm-sidebar widget-area footer-widgets-container widgets-count-' . count( $widgets_count ) . '" data-id="' . $sidebar_id . '" data-widgets-count="' . count( $widgets_count ) . '">' . "\r\n";

				echo wmhook_sidebar_top();

				if ( is_active_sidebar( $sidebar_id ) ) {

					dynamic_sidebar( $sidebar_id );

				} else {

					echo '
							<div class="widget width-1-2" style="width: 48%;">
								<h3 class="widget-heading">About Mustang Lite</h3>
								<div class="widget-content">
									<strong>Mustang Lite</strong> WordPress Theme lets you create beautiful, professional business websites. By default you get the basic blog design which can be extended to full power of the theme with additional <a href="http://wordpress.org/plugins/webman-amplifier/" target="_blank"><strong>WebMan Amplifier</strong> plugin installation</a> (see the <a href="http://themedemos.webmandesign.eu/mustang/">full theme demo website</a>). This theme is a free, lite version of premium <a href="https://creativemarket.com/webmandesign/45467-Mustang-Multipurpose-WordPress-Theme?ref=mustang-lite" target="_blank"><strong>Mustang Multipurpose WordPress Theme</strong> by WebMan</a>. The lite version <strong>does not</strong> support WooCommerce eshop plugin, bbPress forums plugin and also does not contain the premium page builder and sliders plugins included in the paid version. Check out themes by WebMan at <a href="http://www.webmandesign.eu">www.webmandesign.eu</a>. Thank you for using Mustang Lite!<br /><br />
									Theme user manual with demo data can be found at <a href="http://www.webmandesign.eu/manual/mustang/">www.webmandesign.eu/manual/mustang/</a>.
								</div>
							</div>

							<div class="widget">
								<h3 class="widget-heading">Footer Widgets</h3>
								<div class="widget-content">
									To add custom widgets into footer, nagigate to <strong>Appearance &raquo; Widgets</strong> and add widgets into "Footer Widgets" area. <strong>Mustang Lite</strong> supports 4 widgets in the footer by default. <strong>After you install and activate the WebMan Amplifier plugin</strong>, you will get all the power of the theme: masonry footer layout, footer columns setup, "Credits" widget area.
								</div>
							</div>

							<div class="widget">
								<h3 class="widget-heading">WebMan Amplifier Plugin</h3>
								<div class="widget-content">
									The <a href="http://wordpress.org/plugins/webman-amplifier/" target="_blank"><strong>WebMan Amplifier</strong> plugin</a> was built specifically for themes created by WebMan (<a href="http://www.webmandesign.eu">www.webmandesign.eu</a>). This is a premium plugin offered for free via WordPress plugin repository. It extends the power of your theme beyond imagination! <a href="' . admin_url( 'themes.php?page=' . WM_THEME_SHORTNAME . '-about' ) . '"><strong>Install the plugin to use full potential of Mustang Lite theme!</strong></a>
								</div>
							</div>
						';
				}

				echo wmhook_sidebar_bottom();

			echo "\r\n" . '</div>' . "\r\n\r\n";

		echo wmhook_sidebars_after();

	echo '</div></div></div>';

?>