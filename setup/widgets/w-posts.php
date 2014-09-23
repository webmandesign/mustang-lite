<?php
/**
 * Widget: Posts
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

		add_action( 'widgets_init', 'wm_posts_widget_registration' );





/**
 * 20) Helpers
 */

	/**
	 * Widget registration
	 */
	function wm_posts_widget_registration() {
		register_widget( 'wm_posts_widget' );
	} // /wm_posts_widget_registration





/**
 * 30) Widget class
 */

	class wm_posts_widget extends WP_Widget {

		/**
		 * Constructor
		 */
		function __construct() {

			//Helper variables
				$atts = array();

				$atts['id']          = 'wm-posts-widget';
				$atts['name']        = WM_THEME_NAME . ' ' . __( 'Posts and Projects', 'wm_domain' );
				$atts['widget_ops']  = array(
						'classname'   => 'wm-posts-widget',
						'description' => __( 'Lists posts or projects', 'wm_domain' )
					);
				$atts['control_ops'] = array();

				$atts = apply_filters( 'wmhook_custom_widget_atts_' . 'wm_posts_widget', $atts );

			//Register widget attributes
				parent::__construct( $atts['id'], $atts['name'], $atts['widget_ops'], $atts['control_ops'] );

		} // /__construct



		/**
		 * Options form
		 */
		function form( $instance ) {

			//Helper variables
				$instance = wp_parse_args( $instance, array(
						'class'     => '',
						'count'     => 4,
						'order'     => 'new',
						'post_type' => 'post',
						'taxonomy'  => '',
						'title'     => '',
					) );

			//Output
				?>
				<p class="wm-desc"><?php _e( 'Displays list of Posts or Projects.', 'wm_domain' ) ?></p>

				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wm_domain' ) ?></label><br />
					<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Post type:', 'wm_domain' ); ?></label><br />
					<select class="widefat" name="<?php echo $this->get_field_name( 'post_type' ); ?>" id="<?php echo $this->get_field_id( 'post_type' ); ?>">
						<?php
						$options = array(
								'post'        => __( 'Posts', 'wm_domain' ),
								'wm_projects' => __( 'Projects', 'wm_domain' ),
							);
						foreach ( $options as $value => $name ) {
							echo '<option value="' . $value . '" ' . selected( esc_attr( $instance['post_type'] ), $value, false ) . '>' . $name . '</option>';
						}
						?>
					</select>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Posts count:', 'wm_domain' ) ?></label><br />
					<input class="text-center" type="number" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo absint( $instance['count'] ); ?>" size="5" maxlength="2" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Ordering:', 'wm_domain' ); ?></label><br />
					<select class="widefat" name="<?php echo $this->get_field_name( 'order' ); ?>" id="<?php echo $this->get_field_id( 'order' ); ?>">
						<?php
						$options = array(
								'new'    => __( 'Newest first', 'wm_domain' ),
								'old'    => __( 'Oldest first', 'wm_domain' ),
								'name'   => __( 'Alphabetically', 'wm_domain' ),
								'random' => __( 'Randomly', 'wm_domain' ),
							);
						foreach ( $options as $value => $name ) {
							echo '<option value="' . $value . '" ' . selected( esc_attr( $instance['order'] ), $value, false ) . '>' . $name . '</option>';
						}
						?>
					</select>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'taxonomy' ); ?>"><?php _e( 'Optional posts taxonomy:', 'wm_domain' ); ?></label><br />
					<select class="widefat" name="<?php echo $this->get_field_name( 'taxonomy' ); ?>" id="<?php echo $this->get_field_id( 'taxonomy' ); ?>">
						<?php
						if ( function_exists( 'wma_taxonomy_array' ) ) {

							$taxonomy_args = apply_filters( 'wmhook_wm_posts_widget_taxonomy_args', array(
									'post'        => array(
											'all'          => false,
											'hierarchical' => '0',
											'tax_name'     => 'post_tag',
										),
									'wm_projects' => array(
											'all'          => false,
											'hierarchical' => '0',
											'tax_name'     => 'project_tag',
										),
								) );

							//All option
								echo '<option value="" ' . selected( esc_attr( $instance['taxonomy'] ), '', false ) . '>' . __( '- All posts/projects -', 'wm_domain' ) . '</option>';

							//Post tags
								echo '<optgroup label="' . __( 'Posts tags', 'wm_domain' ) . '">';

									$options = wma_taxonomy_array( $taxonomy_args['post'] );

									foreach ( $options as $value => $name ) {
										echo '<option value="' . $taxonomy_args['post']['tax_name'] . ':' . $value . '" ' . selected( esc_attr( $instance['taxonomy'] ), $taxonomy_args['post']['tax_name'] . ':' . $value, false ) . '>' . $name . '</option>';
									}

								echo '</optgroup>';

							//Project tags
								echo '<optgroup label="' . __( 'Projects tags', 'wm_domain' ) . '">';

									$options = wma_taxonomy_array( $taxonomy_args['wm_projects'] );

									foreach ( $options as $value => $name ) {
										echo '<option value="' . $taxonomy_args['wm_projects']['tax_name'] . ':' . $value . '" ' . selected( esc_attr( $instance['taxonomy'] ), $taxonomy_args['wm_projects']['tax_name'] . ':' . $value, false ) . '>' . $name . '</option>';
									}

								echo '</optgroup>';

						}
						?>
					</select>
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'class' ); ?>"><?php _e( 'Optional CSS class:', 'wm_domain' ) ?></label><br />
					<input class="widefat" id="<?php echo $this->get_field_id( 'class' ); ?>" name="<?php echo $this->get_field_name( 'class' ); ?>" type="text" value="<?php echo esc_attr( $instance['class'] ); ?>" />
				</p>
				<?php

				do_action( 'wmhook_wm_posts_widget_form', $instance );

		} // /form



		/**
		 * Save the options
		 */
		function update( $new_instance, $old_instance ) {

			//Helper variables
				$instance = $old_instance;

			//Preparing output
				$instance['class']     = $new_instance['class'];
				$instance['count']     = ( 0 < absint( $new_instance['count'] ) ) ? ( absint( $new_instance['count'] ) ) : ( 4 );
				$instance['order']     = $new_instance['order'];
				$instance['post_type'] = $new_instance['post_type'];
				$instance['taxonomy']  = $new_instance['taxonomy'];
				$instance['title']     = $new_instance['title'];

			//Output
				return apply_filters( 'wmhook_wm_posts_widget_instance', $instance, $new_instance, $old_instance );

		} // /update



		/**
		 * Widget HTML
		 */
		function widget( $args, $instance ) {

			//Helper variables
				$output = '';

				$instance = wp_parse_args( $instance, apply_filters( 'wmhook_wm_posts_widget_defaults', array(
						'class'     => '',
						'count'     => 4,
						'layout'    => array(
								'post'        => 'widget',
								'wm_projects' => 'widget',
							),
						'order'     => 'new',
						'post_type' => 'post',
						'taxonomy'  => '',
						'title'     => '',
					) ) );

			//Praparing output
				$output .= $args['before_widget'];

				if ( trim( $instance['title'] ) ) {
					$output .= $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
				}

				$output .= do_shortcode( apply_filters( 'wmhook_wm_posts_widget_shortcode', '[wm_posts class="' . $instance['class'] . '" columns="1" count="' . $instance['count'] . '" image_size="admin-thumbnail" layout="' . $instance['layout'][ $instance['post_type'] ] . '" order="' . $instance['order'] . '" post_type="' . $instance['post_type'] . '" taxonomy="' . $instance['taxonomy'] . '" /]', $args, $instance ) );

				$output .= $args['after_widget'];

			//Output
				echo apply_filters( 'wmhook_wm_posts_widget_output', $output, $args, $instance );

		} // /widget

	} // /wm_posts_widget

?>