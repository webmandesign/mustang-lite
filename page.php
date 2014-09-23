<?php
/**
 * Page default template
 *
 * @package    WebMan WordPress Theme Framework
 * @copyright  2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.1.1
 */



get_header();

if ( function_exists( 'wma_amplifier' ) ) {
	get_template_part( 'loop', 'singular' );
} else {
	get_template_part( 'loop', 'page' );
}

get_footer();

?>