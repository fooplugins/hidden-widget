<?php
/**
 * @package Hidden HTML Widget
 * @author 	bradvin
 * @created 3 Jan 2014
 *
 * Hidden_Widget class
 */
class Hidden_HTML_Widget extends WP_Widget {

	function __construct() {
		//relies on the Foo_Hidden_HTML_Widget class
		if (!class_exists('Foo_Hidden_HTML_Widget')) {
			throw exception(__('The Hidden HTML Widget relies on the Foo_Hidden_HTML_Widget class to function!', 'hidden-widget'));
		}

		$widget_ops = array('classname' => 'widget_hidden', 'description' => __('HTML that will be hidden.', 'hidden-widget'));
		$control_ops = array('width' => 400, 'height' => 350);
		parent::__construct('hidden', __('Hidden HTML', 'hidden-widget'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$html = apply_filters( 'hidden_html_widget_html', empty( $instance['html'] ) ? '' : $instance['html'], $instance );
		$id = apply_filters( 'hidden_html_widget_id', empty( $instance['id'] ) ? '' : $instance['id'], $instance, $this->id_base );
		Foo_Hidden_HTML_Widget::get_instance()->add_content( $html, $id );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['id'] = $new_instance['id'];
		$instance['html'] = $new_instance['html'];
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'id' => '', 'html' => '' ) );
		$id = strip_tags($instance['id']);
		$html = esc_textarea($instance['html']);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('ID of the hidden element: (Optional)', 'hidden-widget'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo $id; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('html'); ?>"><?php _e('HTML:', 'hidden-widget'); ?></label>
			<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('html'); ?>" name="<?php echo $this->get_field_name('html'); ?>"><?php echo $html; ?></textarea>
		</p>
	<?php
	}
} // end Hidden_HTML_Widget class