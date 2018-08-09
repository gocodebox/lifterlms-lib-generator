<?php
defined( 'ABSPATH' ) || exit;

/**
 * <%= description %>
 * @since    <%= version %>
 * @version  <%= version %>
 */
class <%= classname %> {

	/**
	 * Singleton instance
	 * @var  null
	 */
	protected static $_instance = null;

	/**
	 * Get Main Singleton Instance
	 * @return   <%= classname %>
	 * @since    <%= version %>
	 * @version  <%= version %>
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Private Constructor
	 * @since    <%= version %>
	 * @version  <%= version %>
	 */
	private function __construct() {
	}

}
