<?php
defined( 'ABSPATH' ) || exit;

/**
 * Enqueue Scripts & Styles
 * @since    <%= plugin_version %>
 * @version  <%= plugin_version %>
 */
class <%= generateClassname( plugin_shortname, 'Assets' ) %> {

	/**
	 * Constructor
	 * @since    <%= plugin_version %>
	 * @version  <%= plugin_version %>
	 */
	public function __construct() {

		add_action( 'wp', array( $this, 'init' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin' ) );

	}

	/**
	 * Register, enqueue, & localize frontend scripts
	 * @return   void
	 * @since    <%= plugin_version %>
	 * @version  <%= plugin_version %>
	 */
	public function enqueue() {

		// wp_register_style( 'llms-<%= plugin_shortname_lower %>', <%= plugin_constant_prefix %>PLUGIN_URL . 'assets/css/llms-<%= plugin_shortname_lower %>' . LLMS_ASSETS_SUFFIX . '.css', array(), <%= plugin_constant_prefix %>VERSION );
		// wp_enqueue_style( 'llms-<%= plugin_shortname_lower %>' );

		// wp_style_add_data( 'llms-<%= plugin_shortname_lower %>', 'rtl', 'replace' );
		// wp_style_add_data( 'llms-<%= plugin_shortname_lower %>', 'suffix', LLMS_ASSETS_SUFFIX );

		// wp_register_script( 'llms-<%= plugin_shortname_lower %>', plugins_url( 'assets/js/llms-<%= plugin_shortname_lower %>' . $this->minify . '.js', <%= plugin_constant_prefix %>PLUGIN_FILE ), array( 'jquery' ), <%= plugin_constant_prefix %>VERSION, true );
		// wp_enqueue_script( 'llms-<%= plugin_shortname_lower %>' );

	}

	/**
	 * Register, enqueue, & localize admin scripts
	 * @return   void
	 * @since    <%= plugin_version %>
	 * @version  <%= plugin_version %>
	 */
	public function enqueue_admin() {

		// wp_register_style( 'llms-<%= plugin_shortname_lower %>-admin', <%= plugin_constant_prefix %>PLUGIN_URL . 'assets/css/llms-<%= plugin_shortname_lower %>-admin' . LLMS_ASSETS_SUFFIX . '.css', array(), <%= plugin_constant_prefix %>VERSION );
		// wp_enqueue_style( 'llms-<%= plugin_shortname_lower %>-admin' );

		// wp_style_add_data( 'llms-<%= plugin_shortname_lower %>', 'rtl', 'replace' );
		// wp_style_add_data( 'llms-<%= plugin_shortname_lower %>', 'suffix', LLMS_ASSETS_SUFFIX );

		// wp_register_script( 'llms-<%= plugin_shortname_lower %>-admin', plugins_url( 'assets/js/llms-<%= plugin_shortname_lower %>-admin' . $this->minify . '.js', <%= plugin_constant_prefix %>PLUGIN_FILE ), array( 'jquery' ), <%= plugin_constant_prefix %>VERSION, true );
		// wp_enqueue_script( 'llms-<%= plugin_shortname_lower %>-admin' );

	}

	/**
	 * Get started
	 * @return   void
	 * @since    <%= plugin_version %>
	 * @version  <%= plugin_version %>
	 */
	public function init() {

		if ( is_admin() ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

	}

}
return new <%= generateClassname( plugin_shortname, 'Assets' ) %>();
