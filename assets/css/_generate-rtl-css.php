<?php
/**
 * Main RTL CSS Stylesheet Generator
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Main CSS Stylesheet Generator
 * @copyright   2014 WebMan - Oliver Juhas
 * @since       1.0
 * @version     1.2
 * @uses        Custom CSS Styles Generator
 * @uses        require() instead of require_once() due to previous inclusion of files when building global CSS stylesheet
 */





/**
 * Helper variables
 */

	$output = '';

	$wm_css_content      = array();
	$wm_theme_responsive = ( ! wm_option( 'skin-disable-responsive' ) ) ? ( 'responsive' ) : ( 'static' );
	$wm_theme_css_files  = array(
			10  => 'rtl',
			20  => 'rtl-responsive',
		);

		//Responsive support
			if ( 'static' === $wm_theme_responsive ) {
				unset( $wm_theme_css_files[20] );
			}



		/**
		 * @since  Mustang Lite (WooCommerce and bbPress stylesheets removed)
		 */



		/**
		 * Allow filtering of the CSS files array
		 */

			$wm_theme_css_files = apply_filters( 'wmhook_wm_theme_css_files_rtl', $wm_theme_css_files );

			ksort( $wm_theme_css_files );





/**
 * Preparing output
 */

	//Buffer
		ob_start();

			//Start including files and editing output
				foreach ( $wm_theme_css_files as $css_file_name ) {
					if ( is_array( $css_file_name ) ) {

						/**
						 * For custom CSS file paths use this structure:
						 * array( 'CUSTOM_CSS_FILE_FOLDER_PATH', 'CUSTOM_CSS_FILE_SLUG' )
						 */
						$css_file_path = trailingslashit( $css_file_name[0] ) . $css_file_name[1] . '.css';

						//Print file URL at the beginning of its content
							echo "\r\n\r\n\r\n/* $css_file_path */\r\n\r\n";

						if ( file_exists( $css_file_path ) ) {
							require( $css_file_path );
						}

					} else {

						$css_file_path = 'assets/css/' . $css_file_name . '.css';

						//Print file URL at the beginning of its content
							echo "\r\n\r\n\r\n/* $css_file_path */\r\n\r\n";

						/**
						 * For basic CSS file paths use this structure:
						 * 'CUSTOM_CSS_FILE_SLUG'
						 */
						locate_template( $css_file_path, true, false );

					}

					$wm_css_content[] = $css_file_path;
				}

		$output = trim( apply_filters( 'wmhook_generate_css_output_start', '@charset "UTF-8";' . "\r\n\r\n/**\r\n * CONTENT:\r\n *\r\n * " . implode( "\r\n * ", $wm_css_content ) . "\r\n */", $wm_css_content ) ) . "\r\n\r\n\r\n" . ob_get_clean();

	//Replace paths (do not use relative paths in stylesheets!)
		$replacements = (array) apply_filters( 'wmhook_generate_css_replacements', array() );

		if ( is_array( $replacements ) && ! empty( $replacements ) ) {
			$output = strtr( $output, $replacements );
		}





/**
 * Custom styles from skin editor
 */

	// locate_template( 'assets/css/_custom-styles.php', true ); //Must be in separate file for WordPress customizer

	$output .= "\r\n\r\n\r\n/**\r\n * Skin styles\r\n */\r\n\r\n" . wm_custom_styles() . "\r\n\r\n" . '/* End of file */';





/**
 * Output
 */

	echo $output;

?>