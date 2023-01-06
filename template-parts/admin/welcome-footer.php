<?php
/**
 * Admin "Welcome" page content component
 *
 * Footer.
 *
 * @package    Mustang
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  2.1.0
 */

if ( ! class_exists( 'Mustang_Welcome' ) ) {
	return;
}

?>

<div class="welcome__section welcome__footer">
	<p><?php echo Mustang_Welcome::get_info_like(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?></p>
	<p><?php echo Mustang_Welcome::get_info_support(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?></p>
</div>

<div class="welcome__section welcome__section--colophon">
	<p><small><em><?php esc_html_e( 'You can disable this page in Appearance &rarr; Customize &rarr; Theme Options &rarr; Others.', 'mustang-lite' ); ?></em></small></p>
</div>
