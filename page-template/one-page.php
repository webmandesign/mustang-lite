<?php
/**
 * Custom page template
 *
 * Template Name: One page with anchor navigation
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Page Templates
 * @copyright   2014 WebMan - Oliver Juhas
 */



get_header();

if ( function_exists( 'wma_amplifier' ) ) {
	get_template_part( 'loop', 'singular' );
}

get_footer();

?>