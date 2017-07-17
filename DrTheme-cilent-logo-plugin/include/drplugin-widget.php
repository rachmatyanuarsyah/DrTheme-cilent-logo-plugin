<?php

/**
 * DrTheme cilent logo plugin: WP_Widget
 *
 * @Since 1.0.0
 * 
 */
 
 class DrThemeCilentLogoWidget extends WP_Widget {
 	
 	public static function register() {
        register_widget( __CLASS__ );
    }
 	/**
	 * Sets up a new DrTheme cilent logo plugin widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => DRTHEME_LOGO_PLUGIN_BASENAME.'_Widget',
			'description' => __( 'Add a cilent logo to your sidebar.','drtheme' )
		);
		parent::__construct( DRTHEME_LOGO_PLUGIN_BASENAME.'_Widget',__('Simple Cilent Logo','drtheme'), $widget_ops );
	}
	 
	/**
	 * Outputs the content for the current Cilent Logo widget instance.
	 *
	 * @since 1.0.0
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Custom Menu widget instance.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __('Our Cilent','drtheme_widget') : $instance['title'] );
		$num_logo_show = ( ! empty( $instance['num_logo_show'] ) ) ? absint( $instance['num_logo_show'] ) : 5;
		echo $args['before_widget'];
		if ( !empty($title) )
			echo $args['before_title'] . $title . $args['after_title'];
			echo do_shortcode('[CilentLogoShortCode image_display='.$num_logo_show.']');
		echo $args['after_widget'];
	}
	
	/**
	 * Outputs the settings form for the DrTheme Cilent Logo widget.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$num_logo_show = isset( $instance['num_logo_show'] ) ? $instance['num_logo_show'] : 5;
		
		?>
		<div class="nav-menu-widget-form-controls">
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','drtheme' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'num_logo_show' ); ?>"><?php _e( 'Number of Logo To Show:','drtheme' ); ?></label>
				<input class="tiny-text" id="<?php echo $this->get_field_id( 'num_logo_show' ); ?>" name="<?php echo $this->get_field_name( 'num_logo_show' ); ?>" type="number" step="1" min="1" value="<?php echo $num_logo_show; ?>" size="3" />
			</p>
		</div>
		<?php
	}
	
	/**
	 * Handles updating settings for the current Cilent Logo widget instance.
	 *
	 * @since 1.0.0
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		if ( ! empty( $new_instance['title'] ) ) {
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
		}
		if ( ! empty( $new_instance['num_logo_show'] ) ) {
			$instance['num_logo_show'] = (int) $new_instance['num_logo_show'];
		}
		return $instance;
	}
 }
