<?php
/**
 * <%= plugin_main_class %> main class
 *
 * @package <%= package %>/Classes
 *
 * @since <%= plugin_version %>
 * @version <%= plugin_version %>
 */

defined( 'ABSPATH' ) || exit;

/**
 * <%= plugin_main_class %> class.
 *
 * @since <%= plugin_version %>
 */
final class <%= plugin_main_class %> {

	/**
	 * Current version of the plugin
	 *
	 * @var string
	 */
	public $version = '<%= plugin_version %>';

	/**
	 * Singleton instance of the class
	 *
	 * @var obj
	 */
	private static $_instance = null;

	/**
	 * Singleton Instance of the <%= plugin_main_class %> class
	 *
	 * @since <%= plugin_version %>
	 *
	 * @return obj  instance of the <%= plugin_main_class %> class
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since <%= plugin_version %>
	 *
	 * @return void
	 */
	private function __construct() {

		if ( ! defined( '<%= plugin_constant_prefix %>VERSION' ) ) {
			define( '<%= plugin_constant_prefix %>VERSION', $this->version );
		}

		add_action( 'init', array( $this, 'load_textdomain' ), 0 );

		// get started
		add_action( 'plugins_loaded', array( $this, 'init' ), 10 );

	}

	<% if ( 'integration' === plugin_type ) { %>

	/**
	 * Access the integration class
	 *
	 * @since <%= plugin_version %>
	 *
	 * @example $integration = <%= plugin_main_function %>()->get_integration();
	 *
	 * @return obj
	 */
	public function get_integration() {
		return LLMS()->integrations()->get_integration( '<%= plugin_name_unprefixed_lower_slugged %>' );
	}<% } %>

	/**
	 * Include files and instantiate classes
	 *
	 * @since <%= plugin_version %>
	 *
	 * @return void
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
	 *
	 * @since <%= plugin_version %>
	 *
	 * @return void
	 */
	public function init() {

		// only load if we have the minimum LifterLMS version installed & activated.
		if ( function_exists( 'LLMS' ) && version_compare( '<%= plugin_min_lifterlms_version %>', LLMS()->version, '<=' ) ) {
			<% if ( 'integration' === plugin_type ) { %>
			// require integration class.
			require_once <%= plugin_constant_prefix %>PLUGIN_DIR . 'includes/class-llms-integration-<%= plugin_name_unprefixed_lower_slugged.replace( '_', '-' ) %>.php';

			// register the integration.
			add_filter( 'lifterlms_integrations', array( $this, 'register_integration' ), 10, 1 );

			<% } %>
			// load includes.
			add_action( 'plugins_loaded', array( $this, 'includes' ), 100 );

		}

	}

	/**
	 * Load l10n files
	 * The first loaded file takes priority.
	 *
	 * Files can be found in the following order:
	 * 		WP_LANG_DIR/lifterlms/<%= plugin_text_domain %>-LOCALE.mo
	 * 		WP_LANG_DIR/plugins/<%= plugin_text_domain %>-LOCALE.mo
	 *
	 * @since <%= plugin_version %>
	 *
	 * @return void
	 */
	public function load_textdomain() {

		// load locale.
		$locale = apply_filters( 'plugin_locale', get_locale(), '<%= plugin_text_domain %>' );

		// load a lifterlms specific locale file if one exists.
		load_textdomain( '<%= plugin_text_domain %>', WP_LANG_DIR . '/lifterlms/<%= plugin_text_domain %>-' . $locale . '.mo' );

		// load localization files.
		load_plugin_textdomain( '<%= plugin_text_domain %>', false, dirname( plugin_basename( __FILE__ ) ) . '/<%= plugin_text_domain_path %>' );

	}
	<% if ( 'integration' === plugin_type ) { %>

	/**
	 * Register the integration with LifterLMS
	 *
	 * @since <%= plugin_version %>
	 *
	 * @param array $integrations Array of LifterLMS Integration Classes.
	 * @return array
	 */
	public function register_integration( $integrations ) {

		$integrations[] = '<%= plugin_integration_class %>';
		return $integrations;

	}<% } %>

}