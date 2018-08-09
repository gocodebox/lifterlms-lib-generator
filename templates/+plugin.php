<?php
/**
 * Plugin Name: <%= plugin_name %>
 * Plugin URI: <%= plugin_uri %>
 * Description: <%= plugin_description %>
 * Version: <%= plugin_version %>
 * Author: <%= plugin_author_name %>
 * Author URI: <%= plugin_author_uri %>
 * Text Domain: <%= plugin_text_domain %>
 * Domain Path: <%= plugin_text_domain_path %>
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * LifterLMS Minimum Version: <%= plugin_min_lifterlms_version %>
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '<%= plugin_main_class %>' ) ) :

final class <%= plugin_main_class %> {

	/**
	 * Current version of the plugin
	 * @var string
	 */
	public $version = '<%= plugin_version %>';

	/**
	 * Singleton instance of the class
	 * @var     obj
	 */
	private static $_instance = null;

	/**
	 * Singleton Instance of the <%= plugin_main_class %> class
	 * @return   obj  instance of the <%= plugin_main_class %> class
	 * @since    <%= plugin_version %>
	 * @version  <%= plugin_version %>
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;

	}

	/**
	 * Constructor
	 * @return   void
	 * @since    <%= plugin_version %>
	 * @version  <%= plugin_version %>
	 */
	private function __construct() {

		// define plugin constants
		$this->define_constants();

		add_action( 'init', array( $this, 'load_textdomain' ), 0 );

		// get started
		add_action( 'plugins_loaded', array( $this, 'init' ), 10 );

	}

	/**
	 * Define all constants used by the plugin
	 * @return   void
	 * @since    <%= plugin_version %>
	 * @version  <%= plugin_version %>
	 */
	private function define_constants() {

		if ( ! defined( '<%= plugin_constant_prefix %>PLUGIN_FILE' ) ) {
			define( '<%= plugin_constant_prefix %>PLUGIN_FILE', __FILE__ );
		}

		if ( ! defined( '<%= plugin_constant_prefix %>PLUGIN_DIR' ) ) {
			define( '<%= plugin_constant_prefix %>PLUGIN_DIR', WP_PLUGIN_DIR . "/" . plugin_basename( dirname(__FILE__ ) ) . '/' );
		}

		if ( ! defined( '<%= plugin_constant_prefix %>PLUGIN_URL' ) ) {
			define( '<%= plugin_constant_prefix %>PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
		}

		if ( ! defined( '<%= plugin_constant_prefix %>VERSION' ) ) {
			define( '<%= plugin_constant_prefix %>VERSION', $this->version );
		}

	}
	<% if ( 'integration' === plugin_type ) { %>

	/**
	 * Access the integration class
	 * @example  $integration = <%= plugin_main_function %>()->get_integration();
	 * @return   obj
	 * @since    <%= plugin_version %>
	 * @version  <%= plugin_version %>
	 */
	public function get_integration() {
		return LLMS()->integrations()->get_integration( '<%= plugin_name_unprefixed_lower_slugged %>' );
	}<% } %>

	/**
	 * Include files and instantiate classes
	 * @return  void
	 * @since    <%= plugin_version %>
	 * @version  <%= plugin_version %>
	 */
	public function includes() {
		<% if ( 'integration' === plugin_type ) { %>
		if ( ! $this->get_integration() ) {
			return;
		}
		<% } %>
		require_once <%= plugin_constant_prefix %>PLUGIN_DIR . 'includes/class-llms-<%= plugin_shortname_lower %>-assets.php';

	}

	/**
	 * Include all required files and classes
	 * @return  void
	 * @since    <%= plugin_version %>
	 * @version  <%= plugin_version %>
	 */
	public function init() {

		// only load if we have the minimum LifterLMS version installed & activated
		if ( function_exists( 'LLMS' ) && version_compare( '<%= plugin_min_lifterlms_version %>', LLMS()->version, '<=' ) ) {
			<% if ( 'integration' === plugin_type ) { %>
			// require integration class
			require_once <%= plugin_constant_prefix %>PLUGIN_DIR . 'includes/class-llms-integration-<%= plugin_name_unprefixed_lower_slugged.replace( '_', '-' ) %>.php';

			// register the integration
			add_filter( 'lifterlms_integrations', array( $this, 'register_integration' ), 10, 1 );

			<% } %>
			// load includes
			add_action( 'plugins_loaded', array( $this, 'includes' ), 100 );

		}

	}

	/**
	 * Load l10n files
	 * The first loaded file takes priority
	 *
	 * Files can be found in the following order:
	 * 		WP_LANG_DIR/lifterlms/<%= plugin_text_domain %>-LOCALE.mo
	 * 		WP_LANG_DIR/plugins/<%= plugin_text_domain %>-LOCALE.mo
	 *
	 * @return   void
	 * @since    <%= plugin_version %>
	 * @version  <%= plugin_version %>
	 */
	public function load_textdomain() {

		// load locale
		$locale = apply_filters( 'plugin_locale', get_locale(), '<%= plugin_text_domain %>' );

		// load a lifterlms specific locale file if one exists
		load_textdomain( '<%= plugin_text_domain %>', WP_LANG_DIR . '/lifterlms/<%= plugin_text_domain %>-' . $locale . '.mo' );

		// load localization files
		load_plugin_textdomain( '<%= plugin_text_domain %>', false, dirname( plugin_basename( __FILE__ ) ) . '/<%= plugin_text_domain_path %>' );

	}
	<% if ( 'integration' === plugin_type ) { %>

	/**
	 * Register the integration with LifterLMS
	 * @param    array     $integrations  array of LifterLMS Integration Classes
	 * @return   array
	 * @since    <%= plugin_version %>
	 * @version  <%= plugin_version %>
	 */
	public function register_integration( $integrations ) {

		$integrations[] = '<%= plugin_integration_class %>';
		return $integrations;

	}<% } %>

}
endif;

/**
 * Main Plugin Instance
 * @since    <%= plugin_version %>
 * @version  <%= plugin_version %>
 */
function <%= plugin_main_function %>() {
	return <%= plugin_main_class %>::instance();
}

return <%= plugin_main_function %>();
