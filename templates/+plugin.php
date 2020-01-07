<?php
/**
 * <%= plugin_name %> Plugin
 *
 * @package  <%= package %>/Main
 *
 * @since <%= plugin_version %>
 * @version <%= plugin_version %>
 *
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

// Define Constants.
if ( ! defined( '<%= plugin_constant_prefix %>PLUGIN_FILE' ) ) {
	define( '<%= plugin_constant_prefix %>PLUGIN_FILE', __FILE__ );
}

if ( ! defined( '<%= plugin_constant_prefix %>PLUGIN_DIR' ) ) {
	define( '<%= plugin_constant_prefix %>PLUGIN_DIR', dirname( __FILE__ ) . '/' );
}

if ( ! defined( '<%= plugin_constant_prefix %>PLUGIN_URL' ) ) {
	define( '<%= plugin_constant_prefix %>PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
}

// Load Plugin.
if ( ! class_exists( '<%= plugin_main_class %>' ) ) {
	require_once <%= plugin_constant_prefix %>PLUGIN_DIR . 'class-<%= plugin_main_class_slugged %>.php';
}

// phpcs:disable WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
/**
 * Main Plugin Instance
 *
 * @since <%= plugin_version %>
 *
 * @return <%= plugin_main_function %>
 */
function <%= plugin_main_function %>() {
	return <%= plugin_main_class %>::instance();
}

return <%= plugin_main_function %>();
// phpcs:enable
