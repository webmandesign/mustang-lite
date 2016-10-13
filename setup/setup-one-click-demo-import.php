<?php
/**
 * One Click Demo Import Class
 *
 * @package    Mustang
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.6
 * @version  1.7
 *
 * Contents:
 *
 *  0) Init
 * 10) Files
 * 20) Texts
 * 30) Setup
 */
class Mustang_One_Click_Demo_Import {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.6
		 * @version  1.6
		 */
		private function __construct() {

			// Requirements check

				if ( ! class_exists( 'PT_One_Click_Demo_Import' ) || ! is_admin() ) {
					return;
				}


			// Processing

				// Hooks

					// Actions

						add_action( 'pt-ocdi/after_import', __CLASS__ . '::after' );

						add_action( 'pt-ocdi/before_widgets_import ', __CLASS__ . '::before_widgets_import ' );

					// Filters

						add_filter( 'pt-ocdi/import_files', __CLASS__ . '::files' );

						add_filter( 'pt-ocdi/plugin_intro_text', __CLASS__ . '::info' );

		} // /__construct



		/**
		 * Initialization (get instance)
		 *
		 * @since    1.6
		 * @version  1.6
		 */
		public static function init() {

			// Processing

				if ( null === self::$instance ) {
					self::$instance = new self;
				}


			// Output

				return self::$instance;

		} // /init





	/**
	 * 10) Files
	 */

		/**
		 * Import files setup
		 *
		 * @since    1.6
		 * @version  1.6
		 */
		public static function files() {

			// Output

				return array(

						array(
							'import_file_name'       => esc_html__( 'Theme demo content', 'mustang-lite' ),
							'import_file_url'        => esc_url_raw( 'https://raw.githubusercontent.com/webmandesign/demo-content/master/mustang/content/demo-content-mustang.xml' ),
							'import_widget_file_url' => esc_url_raw( 'https://raw.githubusercontent.com/webmandesign/demo-content/master/mustang/widgets/mustang-widgets.wie' ),
						),

					);

		} // /files





	/**
	 * 20) Texts
	 */

		/**
		 * Info texts
		 *
		 * @since    1.6
		 * @version  1.6
		 *
		 * @param  string $text  Default intro text.
		 */
		public static function info( $text = '' ) {

			// Processing

				$text .= '<div class="media-files-quality-info">';

					$text .= '<h3>';
					$text .= esc_html__( 'Media files quality', 'mustang-lite' );
					$text .= '</h3>';

					$text .= '<p>';
					$text .= esc_html__( 'Please note that imported media files (such as images, video and audio files) are of low quality to prevent copyright infringement.', 'mustang-lite' );
					$text .= ' ' . esc_html__( 'Please read "Credits" section of theme documentation for reference where the demo media files were obtained from.', 'mustang-lite' );
					$text .= ' <a href="https://www.webmandesign.eu/manual/mustang/#credits" target="_blank">' . esc_html__( 'Get media for your website &raquo;', 'mustang-lite' ) . '</a>';
					$text .= '</p>';

				$text .= '</div>';

				$text .= '<div class="ocdi__demo-import-notice">';

					$text .= '<h3>';
					$text .= esc_html__( 'Install required plugins!', 'mustang-lite' );
					$text .= '</h3>';

					$text .= '<p>';
					$text .= esc_html__( 'Please read the information about the theme demo required plugins first.', 'mustang-lite' );
					$text .= ' ' . esc_html__( 'If you do not install and activate demo required plugins, some of the content will not be imported.', 'mustang-lite' );
					$text .= ' <a href="https://github.com/webmandesign/demo-content/tree/master/mustang/content#before-you-begin" target="_blank" title="' . esc_attr__( 'Read the information before you run the theme demo content import process.', 'mustang-lite' ) . '"><strong>';
					$text .= esc_html__( 'View the list of required plugins &raquo;', 'mustang-lite' );
					$text .= '</strong></a>';
					$text .= '</p>';

				$text .= '</div>';


			// Output

				return $text;

		} // /info





	/**
	 * 30) Setup
	 */

		/**
		 * After import actions
		 *
		 * @since    1.6
		 * @version  1.6
		 *
		 * @param  string $selected_import
		 */
		public static function after( $selected_import = '' ) {

			// Processing

				// Front and blog page

					self::front_and_blog_page();

				// WooCommerce pages

					self::woocommerce_pages();

				// Menu locations

					self::menu_locations();

		} // /after



		/**
		 * Setup front and blog page
		 *
		 * @since    1.6
		 * @version  1.6
		 */
		public static function front_and_blog_page() {

			// Processing

				update_option( 'show_on_front', 'page' );

				// Front page

					$page_front = get_page_by_path( 'home' );

					update_option( 'page_on_front', $page_front->ID );

				// Blog page

					$page_blog = get_page_by_path( 'blog' );

					update_option( 'page_for_posts', $page_blog->ID );

		} // /front_and_blog_page



		/**
		 * Setup WooCommerce pages
		 *
		 * @since    1.6
		 * @version  1.7
		 */
		public static function woocommerce_pages() {

			// Requirements check

				if ( ! function_exists( 'wm_is_woocommerce' ) ) {
					return;
				}


			// Processing

				// Shop page

					$page_front = get_page_by_path( 'shop' );

					update_option( 'woocommerce_shop_page_id', $page_front->ID );

				// Cart page

					$page_blog = get_page_by_path( 'shopping-cart' );

					update_option( 'woocommerce_cart_page_id', $page_blog->ID );

				// Checkout page

					$page_blog = get_page_by_path( 'checkout' );

					update_option( 'woocommerce_checkout_page_id', $page_blog->ID );

		} // /woocommerce_pages



		/**
		 * Setup navigation menu locations
		 *
		 * @since    1.6
		 * @version  1.6
		 */
		public static function menu_locations() {

			// Helper variables

				$menu         = array();
				$menu['main'] = get_term_by( 'slug', 'main', 'nav_menu' );


			// Processing

				set_theme_mod( 'nav_menu_locations', array(
						'main' => ( isset( $menu['main']->term_id ) ) ? ( $menu['main']->term_id ) : ( null ),
					) );

		} // /menu_locations



		/**
		 * Remove all widgets from sidebars first
		 *
		 * @since    1.6
		 * @version  1.6
		 */
		public static function before_widgets_import() {

			// Processing

				update_option( 'sidebars_widgets', array() );

		} // /before_widgets_import





} // /Mustang_One_Click_Demo_Import

add_action( 'after_setup_theme', 'Mustang_One_Click_Demo_Import::init', 5 );
