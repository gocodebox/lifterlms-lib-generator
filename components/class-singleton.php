<?php
/**
 * <%= description %>.
 *
<% if ( package ) { %> * @package  <%= package %>
 * <% } %>
 * @since <%= version %>
 * @version <%= version %>
 */

defined( 'ABSPATH' ) || exit;

/**
 * <%= description_class %>.
 *
 * @since <%= version %>
 */
class <%= classname %> {

	/**
	 * Singleton instance
	 *
	 * @var  null
	 */
	protected static $instance = null;

	/**
	 * Get Main Singleton Instance.
	 *
	 * @since <%= version %>
	 *
	 * @return <%= classname %>
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Private Constructor.
	 *
	 * @since <%= version %>
	 *
	 * @return void
	 */
	private function __construct() {
	}

}
