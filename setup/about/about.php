<?php
/**
 * About Page
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  About Page
 * @copyright   2014 WebMan - Oliver Juhas
 * @since       1.0
 * @version     1.2.2
 *
 * CONTENT:
 * - 10) Actions and filters
 * - 20) Styles and scripts
 * - 30) Renderer
 */





/**
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		//Display "About" page
			add_action( 'admin_menu', 'wm_add_about_screen' );
		//Display "About" page admin notice
			add_action( 'current_screen', 'wm_about_screen_notice' );





/**
 * 20) Styles and scripts
 */

	/**
	 * About theme page styles
	 */
	if ( ! function_exists( 'wm_about_css' ) ) {
		function wm_about_css() {
			wp_enqueue_style( 'wm-about' );
			wp_enqueue_style( 'wm-about-custom' );

			if (
					is_rtl()
					&& apply_filters( 'wmhook_wm_about_css_enable_rtl', false )
				) {
				wp_enqueue_style( 'wm-about-rtl' );
			}
		}
	} // /wm_about_css





/**
 * 30) Renderer
 */

	/**
	 * Add "About" screen notice
	 *
	 * @since  1.2.2
	 */
	if ( ! function_exists( 'wm_about_screen_notice' ) ) {
		function wm_about_screen_notice() {
			//Output
				if (
						3 > absint( get_option( WM_THEME_SETTINGS_INSTALL ) )
						&& ! isset( $wp_customize )
					) {
						$screen = get_current_screen();

						if (
								isset( $screen->id )
								&& 'themes' === $screen->id
							) {
							$message = '<a href="' . admin_url( 'themes.php?page=' . WM_THEME_SHORTNAME . '-about' ) . '" class="button button-primary button-hero" style="text-decoration: none; float: right;" title="Go to the ' . WM_THEME_NAME . ' about page">' . WM_THEME_NAME . ' setup &raquo;</a><span style="font-size: 1.25em;">Thank you for <a href="' . admin_url( 'themes.php?page=' . WM_THEME_SHORTNAME . '-about' ) . '">installing <strong>' . WM_THEME_NAME . '</strong></a> WordPress theme by <a href="' . WM_DEVELOPER_URL . '" target="_blank">WebMan</a>!</span><br /><strong>Please, set the theme up according to "<a href="' . admin_url( 'themes.php?page=' . WM_THEME_SHORTNAME . '-about' ) . '"><em>' . sprintf( 'About %s', WM_THEME_NAME ) . '</em></a>" page first.</strong>';

							set_transient( 'wm-admin-notice', array( $message, '', 'switch_themes' ), ( 60 * 60 * 24 ) );
						}
				}
		}
	} // /wm_about_screen_notice



	/**
	 * Add "About" screen to WordPress menu
	 */
	if ( ! function_exists( 'wm_add_about_screen' ) ) {
		function wm_add_about_screen() {
			//Output
				if ( 3 > absint( get_option( WM_THEME_SETTINGS_INSTALL ) ) ) {
					$page_title = sprintf( 'About %s', WM_THEME_NAME );
					$screen     = add_theme_page( $page_title, $page_title, 'switch_themes', WM_THEME_SHORTNAME . '-about', 'wm_about_screen' );

					add_action( 'admin_print_styles-' . $screen, 'wm_about_css' );
				}
		}
	} // /wm_add_about_screen



	/**
	 * Render the "About" screen content
	 *
	 * @since    1.0
	 * @version  1.2.2
	 */
	if ( ! function_exists( 'wm_about_screen' ) ) {
		function wm_about_screen() {
			?>
			<div class="wrap about-wrap">

				<!-- header -->
					<h1><?php printf( 'Welcome to <strong>%s</strong> <small>v%s</small>', WM_THEME_NAME, WM_THEME_VERSION ); ?></h1>

					<div class="about-text">
						Thank you for downloading the free lite version of the powerful <strong><?php echo str_replace( array( ' Lite', ' lite' ), '', WM_THEME_NAME ); ?></strong> WordPress theme by <a href="<?php echo WM_DEVELOPER_URL; ?>" target="_blank">WebMan</a>!<br />Let's unleash the power of flexibility and bring it to HiDPI/Retina displays!<br />Please take time to read the 3 steps below to set the theme up.
					</div>

					<p class="wm-actions">
						<a href="<?php echo admin_url( 'themes.php?page=tgmpa-install-plugins' ); ?>" class="button button-primary button-hero" target="_blank" title="Opens in new tab/window">Install <strong>WebMan Amplifier</strong> &raquo;</a>
						<a href="<?php echo WM_ONLINE_MANUAL_URL; ?>" class="button button-primary button-hero" target="_blank">User Manual</a>
						<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://themedemos.webmandesign.eu/<?php echo WM_THEME_SHORTNAME; ?>/" data-text="I'm using awesome <?php echo str_replace( array( ' Lite', ' lite' ), '', WM_THEME_NAME ); ?> WordPress theme!" data-via="WebMan" data-size="large" data-hashtags="webmandesigneu">Tweet</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					</p>

				<!-- content -->

					<div class="changelog">

						<div class="wm-notes special">
							<h3 class="mt0">Lite Version Difference</h3>
							<p>Please note that this lite version of the <strong><?php echo str_replace( array( ' Lite', ' lite' ), '', WM_THEME_NAME ); ?></strong> theme <strong>does not</strong> provide integration with WooCommerce and bbPress plugins. For easier content building the theme supports premium Visual Composer, Master Slider and LayerSlider plugins which are not included with the lite version (all of them are 3rd party software).</p>
							<p>Please, consider <a href="<?php echo trailingslashit( WM_DEVELOPER_URL ) . WM_THEME_SHORTNAME . '-lite#comparison'; ?>" target="_blank">upgrading to premium version</a> of the theme to get more functionality and to support WebMan.</p>
							<a href="<?php echo trailingslashit( WM_DEVELOPER_URL ) . WM_THEME_SHORTNAME . '-lite#comparison'; ?>" class="button button-primary button-hero" target="_blank"><strong style="text-transform: uppercase;">Upgrade the theme &raquo;</strong></a>
						</div>

						<div class="wm-notes special">
							<span class="dropcap">1</span>
							<h3 class="mt0">IMPORTANT!</h3>
							<h4 class="mt0">READ BEFORE YOU SET UP THE THEME</h4>
							<p>To keep the theme as flexible, open and future-proof, as possible, it uses the <strong>WebMan Amplifier</strong> plugin.<br /><strong>Please, install and activate this plugin before you set the theme up.</strong></p>
							<a href="<?php echo admin_url( 'themes.php?page=tgmpa-install-plugins' ); ?>" class="button button-primary button-hero" target="_blank" title="Opens in new tab/window">Install <strong>WebMan Amplifier</strong> plugin &raquo;</a>
						</div>

						<div class="feature-section col two-col">

							<h3 class="mt0">Quick-start Guide</h3>

							<div>
								<h4>Start with WordPress settings</h4>
								<p>
									<span class="dropcap">2</span>
									Please navigate to <strong>Settings</strong> section of the main WordPress admin menu and go through the subsections and options..
								</p>
								<p>
									<small><strong>Tip:</strong> <em>
									For better Search Engine Optimization (SEO) it is recommended to set permalinks structure to "Post name".
									</em></small>
								</p>
								<p>
									<small><strong>Tip:</strong> <em>
									Read more about <a href="http://codex.wordpress.org/Administration_Screens#Settings_-_Configuration_Settings" target="_blank">WordPress settings</a>.
									</em></small>
								</p>
								<p>
									<small><strong>Tip:</strong> <em>
									If you are new to WordPress, you can find some instructions on how to use this system in <a href='http://codex.wordpress.org/WordPress_Lessons' target='_blank'>WordPress lessons</a> or in <a href="http://wordpress.tv/category/how-to/" target="_blank">WordPress TV</a>.
									</em></small>
								</p>
								<a class="button button-primary button-hero" href="<?php echo admin_url( 'options-general.php' ); ?>" target="_blank" title="Opens in new tab/window">Set up WordPress &raquo;</a>
							</div>

							<div class="last-feature">
								<h4>Customize the theme</h4>
								<p><small><strong>IMPORTANT: This step is available only after WebMan Amplifier plugin activation.</strong></small></p>
								<p>
									<span class="dropcap">3</span>
									<?php echo WM_THEME_NAME; ?> will let you customize its appearance using <abbr title="What You See Is What You Get">WYSIWYG</abbr> editor. You can apply a certain design changes with no fear of them being displayed on your live website. Nothing is going live until you save the changes! Keep your designs and save them in skins!
								</p>
								<p>
									<small><strong>IMPORTANT:</strong> <em>
									Saving apperance customization will regenerate and rebuild the existing main theme CSS stylesheet file. Also, the main stylesheet file will be regenerated after activation of certain plugins. Please refer to <a href="<?php echo WM_ONLINE_MANUAL_URL; ?>" target="_blank">theme user manual</a> for supported plugins list.
									</em></small>
								</p>
								<a href="<?php echo admin_url( 'customize.php' ); ?>" class="button button-primary button-hero" target="_blank" title="Opens in new tab/window">Customize the Theme &raquo;</a>
							</div>

						</div>

					</div>

				<!-- footer -->

					<hr />

					<div class="feature-section congrats">
						<p><strong>And that's it! Once again, thank you and enjoy your theme! :)</strong></p>
						<p style="font-family: Georgia, serif;"><em><a href="<?php echo WM_DEVELOPER_URL; ?>" target="_blank" style="text-decoration: none;">WebMan Design</a></em></p>
					</div>
			</div>
			<?php
		}
	} // /wm_about_screen

?>