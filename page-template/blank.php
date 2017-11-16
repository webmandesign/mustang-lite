<?php
/**
 * Custom page template
 *
 * Template Name: Blank page
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Page Templates
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.8.1
 */



get_header();

if ( class_exists( 'WM_Amplifier' ) ) {

	echo '<div id="content-section" class="content-section wrap clearfix" role="main"' . wm_schema_org( 'main_content' ) . '>';

	get_template_part( 'loop', 'singular' );

	echo '</div>';

}

get_footer();
