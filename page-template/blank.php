<?php
/**
 * Custom page template
 *
 * Template Name: Blank page
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Page Templates
 * @copyright   2014 WebMan - Oliver Juhas
 */



get_header();

if ( function_exists( 'wma_amplifier' ) ) {

	echo '<div id="content-section" class="content-section wrap clearfix" role="main"' . wm_schema_org( 'main_content' ) . '>';

	get_template_part( 'loop', 'singular' );

	echo '</div>';

}

get_footer();

?>