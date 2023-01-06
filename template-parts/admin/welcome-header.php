<?php
/**
 * Admin "Welcome" page content component.
 *
 * Header.
 *
 * @package    Mustang
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  2.1.0
 */

if ( ! class_exists( 'Mustang_Welcome' ) ) {
	return;
}

$theme = 'mustang-lite';

?>

<div class="welcome__section welcome__header">

	<h1>
		<?php echo wp_get_theme( $theme )->display( 'Name' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
		<small><?php echo WM_THEME_VERSION; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?></small>
	</h1>

	<p class="welcome__intro">
		<?php

		printf(
			/* translators: 1: theme name, 2: theme developer link. */
			esc_html__( 'Congratulations and thank you for choosing %1$s theme by %2$s!', 'mustang-lite' ),
			'<strong>' . wp_get_theme( $theme )->display( 'Name' ) . '</strong>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'<a href="' . esc_url( wp_get_theme( $theme )->get( 'AuthorURI' ) ) . '"><strong>WebMan Design</strong></a>'
		);

		?>
		<?php esc_html_e( 'Information on this page introduces the theme and provides useful tips.', 'mustang-lite' ); ?>
	</p>

	<nav class="welcome__nav">
		<ul>
			<li><a href="#welcome-guide"><?php esc_html_e( 'Quickstart', 'mustang-lite' ); ?></a></li>
			<li><a href="#welcome-demo"><?php esc_html_e( 'Demo content', 'mustang-lite' ); ?></a></li>
			<li><a href="#welcome-promo"><?php esc_html_e( 'Upgrade', 'mustang-lite' ); ?></a></li>
		</ul>
	</nav>

	<p>
		<a href="https://webmandesign.github.io/docs/mustang/" class="button button-hero button-primary"><?php esc_html_e( 'Documentation &rarr;', 'mustang-lite' ); ?></a>
		<a href="https://support.webmandesign.eu/forums/forum/mustang/" class="button button-hero button-primary"><?php esc_html_e( 'Support Forum &rarr;', 'mustang-lite' ); ?></a>
	</p>

	<p class="welcome__alert welcome__alert--tip">
		<strong class="welcome__badge"><?php echo esc_html_x( 'Tip:', 'Notice, hint.', 'mustang-lite' ); ?></strong>
		<?php echo Mustang_Welcome::get_info_like(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
	</p>

</div>

<div class="welcome-content">
