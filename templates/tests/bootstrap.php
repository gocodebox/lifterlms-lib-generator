<?php
/**
 * Testing Bootstrap
 *
 * @package <%= package %>/Tests
 *
 * @since [version]
 * @version [version]
 */

require_once './vendor/lifterlms/lifterlms-tests/bootstrap.php';

class <%= generateClassname( 'Tests_Bootstrap', plugin_shortname ) %> extends LLMS_Tests_Bootstrap {

	/**
	 * __FILE__ reference, should be defined in the extending class
	 *
	 * @var [type]
	 */
	public $file = __FILE__;

	/**
	 * Name of the testing suite
	 *
	 * @var string
	 */
	public $suite_name = '<%= plugin_name %>';

	/**
	 * Main PHP File for the plugin
	 *
	 * @var string
	 */
	public $plugin_main = '<%= plugin_main_file %>';

}

return new <%= generateClassname( 'Tests_Bootstrap', plugin_shortname ) %>();
