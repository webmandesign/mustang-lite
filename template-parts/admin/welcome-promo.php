<?php
/**
 * Admin "Welcome" page content component.
 *
 * Theme update guide.
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

<div class="welcome__section welcome__section--promo" id="welcome-promo">

	<h2>
		<span class="welcome__icon dashicons dashicons-superhero-alt"></span>
		<?php esc_html_e( 'Like the theme?', 'mustang-lite' ); ?>
	</h2>

	<p>
		<?php esc_html_e( 'You are using a fully functional 100% free WordPress theme.', 'mustang-lite' ); ?>
		<?php esc_html_e( 'If you find it helpful, please support its updates and technical support service with a donation at WebManDesign.eu.', 'mustang-lite' ); ?>
		<?php esc_html_e( 'Thank you!', 'mustang-lite' ); ?>
	</p>

	<p><a href="https://www.webmandesign.eu/contact/#donation"><strong><?php esc_html_e( 'Visit WebMan Design website now &rarr;', 'mustang-lite' ); ?></strong></a></p>

</div>
