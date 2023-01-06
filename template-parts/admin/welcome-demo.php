<?php
/**
 * Admin "Welcome" page content component
 *
 * Demo content installation.
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

<div class="welcome__section welcome__section--demo" id="welcome-demo">

	<h2>
		<span class="welcome__icon dashicons dashicons-database-add"></span>
		<?php esc_html_e( 'Theme Demo Content', 'mustang-lite' ); ?>
	</h2>

	<div class="welcome__section--child">
		<h3><?php esc_html_e( 'Full theme demo content', 'mustang-lite' ); ?></h3>

		<p>
			<?php esc_html_e( 'You can install a full theme demo content to match the theme demo website.', 'mustang-lite' ); ?>
			<a href="https://themedemos.webmandesign.eu/mustang/"><?php esc_html_e( '(Preview the demo &rarr;)', 'mustang-lite' ); ?></a>
			<?php esc_html_e( 'This provides a comprehensive start for building your own website.', 'mustang-lite' ); ?>
		</p>

		<p>
			<?php esc_html_e( 'Please check out these information:', 'mustang-lite' ); ?>
			<br><a href="https://webmandesign.github.io/docs/mustang/#demo-content"><?php esc_html_e( 'Information about theme demo content &rarr;', 'mustang-lite' ); ?></a>
			<br><a href="https://github.com/webmandesign/demo-content/tree/master/mustang/"><?php esc_html_e( 'Specific instructions on how to install theme demo content &rarr;', 'mustang-lite' ); ?></a>
		</p>

		<?php if ( class_exists( 'OCDI_Plugin' ) ) : ?>
			<p>
				<a class="button button-hero" href="<?php echo esc_url( 'themes.php?page=pt-one-click-demo-import' ); ?>"><?php esc_html_e( 'Install demo content', 'mustang-lite' ); ?></a>
				&ensp;
				<small><em><?php esc_html_e( '(Appearance &rarr; Import Demo Data)', 'mustang-lite' ); ?></em></small>
			</p>
		<?php else : ?>
			<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>"><?php esc_html_e( 'Use "One Click Demo Import" plugin &rarr;', 'mustang-lite' ); ?></a></p>
		<?php endif; ?>
	</div>

</div>
