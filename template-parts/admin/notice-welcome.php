<?php
/**
 * Admin notice: Welcome.
 *
 * @package    Mustang
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  2.1.0
 */

if ( ! class_exists( 'Mustang_Welcome' ) ) {
	return;
}

$theme_name = wp_get_theme( 'mustang-lite' )->display( 'Name' );

?>

<div class="notice notice-info is-dismissible theme-welcome-notice">

	<h2>
		<?php

		printf(
			/* translators: %s: Theme name. */
			esc_html__( 'Thank you for installing %s theme!', 'mustang-lite' ),
			'<strong>' . $theme_name . '</strong>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);

		?>
	</h2>

	<p>
		<?php esc_html_e( 'Visit "Welcome" page for information on how to set up your website.', 'mustang-lite' ); ?>
		<br class="linebreak">
		<?php echo Mustang_Welcome::get_info_like(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
	</p>

	<p class="call-to-action">
		<a href="<?php echo esc_url( admin_url( 'themes.php?page=mustang-lite-welcome' ) ); ?>" class="button button-primary button-hero"><?php

			echo esc_html__( 'Let\'s Get Started &raquo;', 'mustang-lite' );

		?></a>
	</p>

</div>

<style type="text/css" media="screen">

	.theme-welcome-notice {
		padding: 2em 2em 1.5em;
		font-size: 1.25em;
	}

	.theme-welcome-notice h2 {
		margin: 0 0 1em;
	}

	.theme-welcome-notice p {
		font-size: inherit;
	}

	.theme-welcome-notice br:not(.linebreak) {
		display: none;
	}

	.theme-welcome-notice .dashicons {
		width: 1em;
		height: 1em;
		font-size: 1.15em;
	}

</style>
