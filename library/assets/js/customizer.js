/**
 * Theme Customizer Scripts
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Skinning System
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @since       3.0
 * @version     2.0.0
 */

( function( wp, $ ) {

	/**
	 * Custom radio select
	 *
	 * @since 3.1
	 */
	$( '.custom-radio-container' ).on( 'change', 'input', function() {
		$( this ).parent().addClass( 'active' ).siblings().removeClass( 'active' );
	} );

	/**
	 * Run actions after customizer saving.
	 *
	 * IMPORTANT:
	 * This can not be done with jQuery.on() as it does not work.
	 * We have to use jQuery.bind() here still, unfortunately.
	 *
	 * @since    3.0
	 * @version  2.0.0
	 */
	wp.customize.bind( 'saved', function() {
		if (
			$( '#customize-control-wm-' + wmCustomizerHelper.wmThemeShortname + '-skin-wm-skin-new input' ).val()
			|| $( '#customize-control-wm-' + wmCustomizerHelper.wmThemeShortname + '-skin-wm-skin-load select' ).val()
		) {
			//Trigger action when customizer saved and new skin/load skin set

			//Refresh the page when loading skin (will empty also the new skin/load skin fields)
			if ( $( '#customize-control-wm-' + wmCustomizerHelper.wmThemeShortname + '-skin-wm-skin-load select' ).val() ) {
				document.location.reload( true );
			}

			//Empty the new skin field
			$( '#customize-control-wm-' + wmCustomizerHelper.wmThemeShortname + '-skin-wm-skin-new input' ).val( '' );

		}

	} );

} )( wp, jQuery );
