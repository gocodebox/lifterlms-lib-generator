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
	 * Constructor.
	 *
	 * @since <%= version %>
	 *
	 * @return void
	 */
	public function __construct() {
	}

}

return new <%= classname %>();
