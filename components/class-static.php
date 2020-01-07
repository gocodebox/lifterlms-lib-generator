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
	 * Static Constructor.
	 *
	 * @since <%= version %>
	 *
	 * @return void
	 */
	public static function init() {
	}

}

return <%= classname %>::init();
