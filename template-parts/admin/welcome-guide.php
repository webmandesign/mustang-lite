<?php
/**
 * Admin "Welcome" page content component.
 *
 * Quickstart guide.
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

<div class="welcome__section welcome__section--guide" id="welcome-guide">

	<h2><?php esc_html_e( 'Quickstart Guide', 'mustang-lite' ); ?></h2>

	<div class="welcome__column welcome__guide--settings">
		<h3>
			<span class="welcome__icon dashicons dashicons-admin-plugins"></span>
			<?php esc_html_e( 'WebMan Amplifier', 'mustang-lite' ); ?>
		</h3>
		<p>
			<?php printf( esc_html_x( 'To make the theme highly flexible, open and future-proof, it uses the %s plugin.', '%s: plugin name.', 'mustang-lite' ), '<a href="https://wordpress.org/plugins/webman-amplifier/" target="_blank"><strong>WebMan Amplifier</strong></a>' ); ?>
			<?php esc_html_e( 'Please, install and activate this plugin to unveil the additional functionality.', 'mustang-lite' ); ?>
		</p>
		<?php if ( ! class_exists( 'WM_Amplifier' ) ) : ?>
			<p><a class="button button-hero" href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>"><?php printf( esc_html_x( 'Install %s &raquo;', '%s: plugin name.', 'mustang-lite' ), '<strong>WebMan Amplifier</strong>' ); ?></a></p>
		<?php endif; ?>
	</div>

	<div class="welcome__column welcome__guide--settings">
		<h3>
			<span class="welcome__icon dashicons dashicons-admin-settings"></span>
			<?php esc_html_e( 'Set up', 'mustang-lite' ); ?>
		</h3>
		<p>
			<?php esc_html_e( 'Make sure to tweak "Settings" section of your site.', 'mustang-lite' ); ?>
			<?php esc_html_e( 'Please go through all the subsections and options.', 'mustang-lite' ); ?>
			<?php esc_html_e( 'This step is required for all WordPress websites.', 'mustang-lite' ); ?>
		</p>
		<p><a class="button button-hero" href="<?php echo esc_url( admin_url( 'options-general.php' ) ); ?>"><?php esc_html_e( 'Settings', 'mustang-lite' ); ?></a></p>
	</div>

	<div class="welcome__column welcome__guide--customize">
		<h3>
			<span class="welcome__icon dashicons dashicons-admin-customizer"></span>
			<?php esc_html_e( 'Customize', 'mustang-lite' ); ?>
		</h3>
		<p>
			<?php esc_html_e( 'You can customize your website using a live-preview editor.', 'mustang-lite' ); ?>
			<?php esc_html_e( 'Customization changes apply only after you publish them.', 'mustang-lite' ); ?>
		</p>
		<p><a class="button button-hero" href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><?php esc_html_e( 'Customize', 'mustang-lite' ); ?></a></p>
	</div>

	<div class="welcome__column welcome__guide--wordpress">
		<h3>
			<span class="welcome__icon dashicons dashicons-wordpress-alt"></span>
			<?php esc_html_e( 'New to WordPress?', 'mustang-lite' ); ?>
		</h3>
		<p><?php esc_html_e( 'If you are new to WordPress check out info in theme documentation.', 'mustang-lite' ); ?></p>
		<p><a href="https://webmandesign.github.io/docs/mustang/#wordpress"><?php esc_html_e( 'Get to know WordPress &rarr;', 'mustang-lite' ); ?></a></p>
	</div>

</div>
