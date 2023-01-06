<?php
/**
 * Welcome Page Class.
 *
 * @package    Mustang
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  2.1.0
 */
class Mustang_Welcome {

	/**
	 * Initialization.
	 *
	 * @since  2.1.0
	 */
	public static function init() {

		// Requirements check

			if ( ! is_admin() ) {
				return;
			}


		// Processing

			// Hooks

				// Actions

					add_action( 'admin_enqueue_scripts', __CLASS__ . '::styles' );

					add_action( 'admin_menu', __CLASS__ . '::admin_menu' );

					add_action( 'load-themes.php', __CLASS__ . '::activation_notice_display' );

	} // /init

	/**
	 * Render the screen content.
	 *
	 * @since  2.1.0
	 */
	public static function render() {

		// Variables

			$sections = (array) apply_filters( 'wmhook_mustang_welcome_render_sections', array(
				0   => 'header',
				20  => 'guide',
				30  => 'demo',
				40  => 'promo',
				100 => 'footer',
			) );

			ksort( $sections );


		// Output

			?>

			<div class="wrap welcome__container">

				<?php

				do_action( 'wmhook_mustang_welcome_render_top' );

				foreach ( $sections as $section ) {
					get_template_part( 'template-parts/admin/welcome', $section );
				}

				do_action( 'wmhook_mustang_welcome_render_bottom' );

				?>

			</div>

			<?php

	} // /render

	/**
	 * Welcome screen CSS styles.
	 *
	 * @since  2.1.0
	 *
	 * @param  string $hook
	 *
	 * @return  void
	 */
	public static function styles( $hook = '' ) {

		// Requirements check

			if ( 'appearance_page_mustang-lite-welcome' !== $hook ) {
				return;
			}


		// Processing

			// Styles

				wp_enqueue_style(
					'mustang-lite-welcome',
					get_theme_file_uri( 'assets/css/welcome.css' ),
					array( 'about' ),
					'v' . WM_THEME_VERSION
				);

	} // /styles

	/**
	 * Add screen to WordPress admin menu.
	 *
	 * @since  2.1.0
	 */
	public static function admin_menu() {

		// Processing

			add_theme_page(
				// $page_title
				esc_html__( 'Welcome', 'mustang-lite' ),
				// $menu_title
				esc_html__( 'Welcome', 'mustang-lite' ),
				// $capability
				'edit_theme_options',
				// $menu_slug
				'mustang-lite-welcome',
				// $function
				__CLASS__ . '::render'
			);

	} // /admin_menu

	/**
	 * Initiate "Welcome" admin notice after theme activation.
	 *
	 * @since  2.1.0
	 *
	 * @return  void
	 */
	public static function activation_notice_display() {

		// Processing

			global $pagenow;

			if (
				is_admin()
				&& 'themes.php' == $pagenow
				&& isset( $_GET['activated'] )
			) {
				add_action( 'admin_notices', __CLASS__ . '::activation_notice_content', 99 );
			}

	} // /activation_notice_display

	/**
	 * Display "Welcome" admin notice after theme activation.
	 *
	 * @since  2.1.0
	 *
	 * @return  void
	 */
	public static function activation_notice_content() {

		// Processing

			get_template_part( 'template-parts/admin/notice', 'welcome' );

	} // /activation_notice_content

	/**
	 * Info text: Rate the theme.
	 *
	 * @since  2.1.0
	 */
	public static function get_info_like() {

		// Output

			return
				sprintf(
					/* translators: %1$s: heart icon, %2$s: star icons. */
					esc_html__( 'If you %1$s love this theme don\'t forget to rate it %2$s.', 'mustang-lite' ),
					'<span class="dashicons dashicons-heart" style="color: red; vertical-align: middle;"></span>',
					'<a href="https://wordpress.org/support/theme/mustang-lite/reviews/#new-post" style="display: inline-block; color: goldenrod; text-decoration-style: wavy; vertical-align: middle;"><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span></span></a>'
				)
				. ' '
				. '<br>'
				. '<a href="https://www.webmandesign.eu/contact/#donation">'
				. esc_html__( 'And/or please consider a donation.', 'mustang-lite' )
				. '</a>'
				. ' '
				. esc_html__( 'Thank you!', 'mustang-lite' );

	} // /get_info_like

	/**
	 * Info text: Contact support.
	 *
	 * @since  2.1.0
	 */
	public static function get_info_support() {

		// Output

			return
				esc_html__( 'Have a suggestion for improvement or something is not working as it should?', 'mustang-lite' )
				. ' <a href="https://support.webmandesign.eu/forums/forum/mustang/">'
				. esc_html__( '&rarr; Contact support', 'mustang-lite' )
				. '</a>';

	} // /get_info_support

} // /Mustang_Welcome

add_action( 'after_setup_theme', 'Mustang_Welcome::init' );
