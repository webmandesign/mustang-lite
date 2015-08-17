<?php
/**
 * Mustang Lite WordPress Theme
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() conditional) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * Mustang Lite WordPress Theme, Copyright 2014 WebMan [http://www.webmandesign.eu/]
 * Mustang Lite is distributed under the terms of the GNU GPL
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Alternatively you can use filter and action hooks applied in almost every
 * theme and WebMan Amplifier plugin function.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package    WebMan WordPress Theme Framework
 * @author     WebMan
 * @license    GPL-2.0+
 * @link       http://www.webmandesign.eu
 * @copyright  2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.5
 */





/**
 * Constants
 */

	//Helper variables
		$theme_data = wp_get_theme();

	//Basic constants
		if ( ! defined( 'WM_THEME_NAME' ) )               define( 'WM_THEME_NAME',               $theme_data->Name                                            );
		if ( ! defined( 'WM_THEME_SHORTNAME' ) )          define( 'WM_THEME_SHORTNAME',          str_replace( '-lite', '', get_template() )                   );
		if ( ! defined( 'WM_THEME_VERSION' ) )            define( 'WM_THEME_VERSION',            $theme_data->Version                                         );

		if ( ! defined( 'WM_THEME_SETTINGS_PREFIX' ) )    define( 'WM_THEME_SETTINGS_PREFIX',    'wm-'                                                        );
		if ( ! defined( 'WM_THEME_SETTINGS' ) )           define( 'WM_THEME_SETTINGS',           WM_THEME_SETTINGS_PREFIX . WM_THEME_SHORTNAME                );
		if ( ! defined( 'WM_THEME_SETTINGS_INSTALL' ) )   define( 'WM_THEME_SETTINGS_INSTALL',   WM_THEME_SETTINGS . '-install'                               );
		if ( ! defined( 'WM_THEME_SETTINGS_SKIN' ) )      define( 'WM_THEME_SETTINGS_SKIN',      'theme_mods_' . WM_THEME_SHORTNAME                           );
		if ( ! defined( 'WM_THEME_SETTINGS_VERSION' ) )   define( 'WM_THEME_SETTINGS_VERSION',   WM_THEME_SETTINGS . '-version'                               );

		if ( ! defined( 'WM_DEFAULT_EXCERPT_LENGTH' ) )   define( 'WM_DEFAULT_EXCERPT_LENGTH',   40                                                           ); //words count
		if ( ! defined( 'WM_SCRIPTS_VERSION' ) )          define( 'WM_SCRIPTS_VERSION',          esc_attr( trim( WM_THEME_VERSION ) )                         );
		if ( ! defined( 'WM_WP_COMPATIBILITY' ) )         define( 'WM_WP_COMPATIBILITY',         4.1                                                          );

		if ( ! defined( 'WM_LITE_THEME' ) )               define( 'WM_LITE_THEME',               true                                                         );
		if ( ! defined( 'WM_WEBMAN_AMPLIFIER_THEME' ) )   define( 'WM_WEBMAN_AMPLIFIER_THEME',   true                                                         );

	//Dir constants
		if ( ! defined( 'WM_LANGUAGES' ) )                define( 'WM_LANGUAGES',                get_template_directory() . '/languages'                      );
		if ( ! defined( 'WM_LIBRARY_DIR' ) )              define( 'WM_LIBRARY_DIR',              trailingslashit( 'library' )                                 );

	//Setup dir
		if ( ! defined( 'WM_SETUP_DIR' ) )                define( 'WM_SETUP_DIR',                trailingslashit( 'setup' )                                   );
		if ( ! defined( 'WM_SETUP' ) )                    define( 'WM_SETUP',                    trailingslashit( get_template_directory() ) . WM_SETUP_DIR   );
		if ( ! defined( 'WM_SETUP_CHILD' ) )              define( 'WM_SETUP_CHILD',              trailingslashit( get_stylesheet_directory() ) . WM_SETUP_DIR );
		if ( ! defined( 'WM_SKINS' ) )                    define( 'WM_SKINS',                    trailingslashit( WM_SETUP . 'skins' )                        );
		if ( ! defined( 'WM_SKINS_CHILD' ) )              define( 'WM_SKINS_CHILD',              trailingslashit( WM_SETUP_CHILD . 'skins' )                  );

	//URL constants
		if ( ! defined( 'WM_DEVELOPER_URL' ) )            define( 'WM_DEVELOPER_URL',            'http://www.webmandesign.eu'                                 );
		if ( ! defined( 'WM_SUPPORT_URL' ) )              define( 'WM_SUPPORT_URL',              'http://support.webmandesign.eu'                             );
		if ( ! defined( 'WM_ONLINE_MANUAL_URL' ) )        define( 'WM_ONLINE_MANUAL_URL',        WM_DEVELOPER_URL . '/manual/' . WM_THEME_SHORTNAME . '/'     );

	//Theme design constants
		if ( ! defined( 'WM_DEFAULT_LOGO_SIZE' ) )        define( 'WM_DEFAULT_LOGO_SIZE',        '157x40'                                                     );
		if ( ! defined( 'WM_DEFAULT_IMAGE_SIZE' ) )       define( 'WM_DEFAULT_IMAGE_SIZE',       'ratio-169'                                                  );
		if ( ! defined( 'WM_DEFAULT_SIDEBAR_POSITION' ) ) define( 'WM_DEFAULT_SIDEBAR_POSITION', 'right'                                                      ); // none/left/right
		if ( ! defined( 'WM_DEFAULT_SIDEBAR_WIDTH' ) )    define( 'WM_DEFAULT_SIDEBAR_WIDTH',    ' pane three; pane nine'                                     );





/**
 * Global variables
 */

	//Get theme options
		$wm_theme_options = get_option( WM_THEME_SETTINGS_SKIN );

		if ( empty( $wm_theme_options ) ) {
			$wm_theme_options = array();
		}





/**
 * Required files
 */

	//Global functions
		locate_template( WM_LIBRARY_DIR . 'core.php',  true );

	//Theme settings
		locate_template( WM_SETUP_DIR . 'setup.php',   true );

	//Admin functions
		locate_template( WM_LIBRARY_DIR . 'admin.php', true );

?>