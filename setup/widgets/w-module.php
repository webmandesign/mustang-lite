<?php
/**
 * Widget: Content Module
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Widgets
 * @copyright   2014 WebMan - Oliver Juhas
 * @version     2.0
 *
 * CONTENT:
 * - 10) Actions and filters
 * - 20) Helpers
 * - 30) Widget class
 */





/**
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		add_action( 'widgets_init', 'wm_module_widget_registration' );





/**
 * 20) Helpers
 */

	/**
	 * Widget registration
	 */
	function wm_module_widget_registration() {
		register_widget( 'wm_module_widget' );
	} // /wm_module_widget_registration





/**
 * 30) Widget class
 */

	class wm_module_widget extends WP_Widget {

		/**
		 * Constructor
		 */
		function __construct() {

			//Helper variables
				$atts = array();

				$atts['id']          = 'wm-module-widget';
				$atts['name']        = WM_THEME_NAME . ' ' . __( 'Content Module', 'wm_domain' );
				$atts['widget_ops']  = array(
						'classname'   => 'wm-module-widget',
						'description' => __( 'Displays specific Content Module post', 'wm_domain' )
					);
				$atts['control_ops'] = array();

				$atts = apply_filters( 'wmhook_custom_widget_atts_' . 'wm_module_widget', $atts );

			//Register widget attributes
				parent::__construct( $atts['id'], $atts['name'], $atts['widget_ops'], $atts['control_ops'] );

		} // /__construct



		/**
		 * Options form
		 */
		function form( $instance ) {

			//Helper variables
				$instance = wp_parse_args( $instance, array(
						'class'  => '',
						'module' => '',
						'title'  => '',
					) );

			//Output
				?>
				<p class="wm-desc"><?php _e( 'Displays content of the specific Content Module custom post. Please choose the Content Module below.', 'wm_domain' ) ?></p>

				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wm_domain' ) ?></label><br />
					<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
				</p>

				<p>
					<?php
					$posts = get_posts( array(
							'posts_per_page' => -1,
							'orderby'        => 'title',
							'order'          => 'ASC',
							'post_type'      => 'wm_modules',
						) );

					if ( ! empty( $posts ) ) {
						?>
						<label for="<?php echo $this->get_field_id( 'module' ); ?>"><?php _e( 'Content Module to display:', 'wm_domain' ) ?></label><br />
						<select class="widefat" id="<?php echo $this->get_field_id( 'module' ); ?>" name="<?php echo $this->get_field_name( 'module' ); ?>">
							<option value="" <?php selected( $instance['module'], '' ); ?>><?php _e( '- Select Content Module -', 'wm_domain' ); ?></option>
						<?php
						foreach ( $posts as $post ) {
							$terms = get_the_terms( $post->ID , apply_filters( 'wmhook_wm_module_widget_taxonomy', 'module_tag' ) );
							$tags  = '';
							if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
								$taxonomy = array();
								foreach ( $terms as $term ) {
									if ( isset( $term->name ) ) {
										$taxonomy[] = $term->name;
									}
								}
								$tags .= sprintf( __( ' (tags: %s)', 'wm_domain' ), implode( ', ', $taxonomy ) );
							}

							?>
							<option<?php echo ' value="'. $post->post_name . '" '; selected( $instance['module'], $post->post_name ); ?>><?php echo $post->post_title . $tags; ?></option>
							<?php
						}
						?>
						</select>
						<?php
					} else {
						_e( 'There are no Content Modules to choose from. Please add a new Content Module first.', 'wm_domain' );
					};
					?>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'class' ); ?>"><?php _e( 'Optional CSS class:', 'wm_domain' ) ?></label><br />
					<input class="widefat" id="<?php echo $this->get_field_id( 'class' ); ?>" name="<?php echo $this->get_field_name( 'class' ); ?>" type="text" value="<?php echo esc_attr( $instance['class'] ); ?>" />
				</p>
				<?php

				do_action( 'wmhook_wm_module_widget_form', $instance );

		} // /form



		/**
		 * Save the options
		 */
		function update( $new_instance, $old_instance ) {

			//Helper variables
				$instance = $old_instance;

			//Preparing output
				$instance['class']  = $new_instance['class'];
				$instance['module'] = $new_instance['module'];
				$instance['title']  = $new_instance['title'];

			//Output
				return apply_filters( 'wmhook_wm_module_widget_instance', $instance, $new_instance, $old_instance );

		} // /update



		/**
		 * Widget HTML
		 */
		function widget( $args, $instance ) {

			//Helper variables
				$output = '';

				$instance = wp_parse_args( $instance, array(
						'class'  => '',
						'module' => '',
						'title'  => '',
					) );

			//Praparing output
				$output .= $args['before_widget'];

				if ( trim( $instance['title'] ) ) {
					$output .= $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
				}

				$output .= do_shortcode( apply_filters( 'wmhook_wm_module_widget_shortcode', '[wm_content_module class="' . $instance['class'] . '" module="' . $instance['module'] . '" /]', $args, $instance ) );

				$output .= $args['after_widget'];

			//Output
				echo apply_filters( 'wmhook_wm_module_widget_output', $output, $args, $instance );

		} // /widget

	} // /wm_module_widget

?>