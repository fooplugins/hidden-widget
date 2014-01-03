<?php
/*
Plugin Name: Hidden HTML Widget
Plugin URI: https://github.com/fooplugins/hidden-widget
Description: Append a hidden div element onto the end of your body, using a widget
Version: 1.0.0
Author: bradvin
Author URI: http://fooplugins.com
Text Domain: hidden-widget
Network: false
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright 2014 bradvin (http://fooplugins.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( plugin_dir_path( __FILE__ ) . 'includes/class-hidden-widget.php' );

class Foo_Hidden_HTML_Widget {

	/**
	 * Instance of this class.
	 * @var      Foo_Hidden_HTML_Widget
	 */
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 * @return    Foo_Hidden_HTML_Widget    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * The array of content to be added to the end of the body
	 * @var array
	 */
	private $content = array();

	/**
	 * Foo_Hidden_HTML_Widget constructor
	 */
	function __construct() {
		add_action( 'widgets_init', array( $this, 'register_widget' ) );
		add_action( 'wp_footer', array( $this, 'append_to_body' ), 99);
	}

	/**
	 * Register our widget
	 */
	function register_widget() {
		register_widget('Hidden_HTML_Widget');
	}

	/**
	 * Appends all the hidden widgets to the end of the body
	 */
	function append_to_body() {
		if (count($this->content) > 0) {
			foreach( $this->content as $item ) {
				$id = empty( $item['id'] ) ? '' : "id=\"{$item['id']}\" ";
				?><div <?php echo $id; ?>style="display:none"><?php echo $item['html']; ?></div><?php
			}
		}
	}

	/**
	 * Used by the Hidden_HTML_Widget class to add widget content to be added to the end of the body
	 * @param string $html
	 * @param string $id
	 */
	function add_content($html, $id = null) {
		$this->content[] = array(
			'html' => $html,
			'id' => $id
		);
	}
}

/**
 * start things up!
 */
add_action( 'plugins_loaded', array( 'Foo_Hidden_HTML_Widget', 'get_instance' ) );



