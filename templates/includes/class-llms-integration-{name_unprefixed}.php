<?php
/**
 * <%= plugin_name %> Integration Class
 *
 * @package <%= package %>/Classes
 *
 * @since <%= plugin_version %>
 * @version <%= plugin_version %>
 */

defined( 'ABSPATH' ) || exit;

/**
 * <%= plugin_integration_class %> class.
 *
 * * @since <%= plugin_version %>
 */
class <%= plugin_integration_class %> extends LLMS_Abstract_Integration {

	/**
	 * Integration ID
	 *
	 * @var string
	 */
	public $id = '<%= plugin_name_unprefixed_lower_slugged %>';

	/**
	 * Integration title
	 *
	 * @var string
	 */
	public $title = '';

	/**
	 * Integration Description
	 *
	 * @var string
	 */
	public $description = '';

	/**
	 * Integration Priority
	 * Detemines the order of the settings on the Integrations settings table
	 * Core integrations fire at 5
	 *
	 * @var integer
	 */
	protected $priority = 20;

	/**
	 * Integration Constructor
	 *
	 * @since <%= plugin_version %>
	 */
	protected function configure() {

		$this->title = __( '<%= plugin_name %>', '<%= plugin_text_domain %>' );
		$this->description = __( '<%= plugin_description %>', '<%= plugin_text_domain %>' );

		add_action( 'lifterlms_settings_save_integrations', array( $this, 'after_settings_save' ), 999 );

	}

	/**
	 * Run actions after the integration is saved
	 *
	 * @since <%= plugin_version %>
	 *
	 * @return void
	 */
	public function after_settings_save() {

		if ( ! $this->is_available() ) {
			return;
		}

	}

	/**
	 * Get additional settings specific to the integration
	 * extending classes should override this with the settings
	 * specific to the integration
	 *
	 * @since <%= plugin_version %>
	 *
	 * @return array
	 */
	protected function get_integration_settings() {

		$settings = array();

		$settings[] = array(
			'desc' => '<br>' . __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '<%= plugin_text_domain %>' ),
			'default' => __( 'Default Text Value', '<%= plugin_text_domain %>' ),
			'id' => $this->get_option_name( 'text_option' ),
			'title' => __( 'Text Input Setting', '<%= plugin_text_domain %>' ),
			'type' => 'text',
		);

		$settings[] = array(
			'class' => 'llms-select2-post',
			'custom_attributes' => array(
				'data-post-type' => 'page',
				'data-placeholder' => __( 'Select a page...', '<%= plugin_text_domain %>' ),
			),
			'desc' => '<br>' . __( 'Select a page for a setting.', '<%= plugin_text_domain %>' ),
			'id' => $this->get_option_name( 'page_setting' ),
			'options' => llms_make_select2_post_array( $this->get_option( 'page_setting' ) ),
			'title' => __( 'Page Selection Option', '<%= plugin_text_domain %>' ),
			'type' => 'select',
		);

		$settings[] = array(
			'class' => 'llms-select2',
			'default' => 'lorem',
			'desc' => '<br>' . __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '<%= plugin_text_domain %>' ),
			'id' => $this->get_option_name( 'select_name' ),
			'options' => array(
				'lorem' => __( 'Lorem', '<%= plugin_text_domain %>' ),
				'ipsum' => __( 'Ipsum', '<%= plugin_text_domain %>' ),
				'dolor' => __( 'Dolor', '<%= plugin_text_domain %>' ),
			),
			'title' => __( 'Select Setting', '<%= plugin_text_domain %>' ),
			'type' => 'select',
		);

		$settings[] = array(
			'desc' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '<%= plugin_text_domain %>' ),
			'title' => __( 'Settings Section Subtitle', '<%= plugin_text_domain %>' ),
			'type' => 'subtitle',
		);

		// checkbox setting
		$settings[] = array(
			'default' => 0,
			'desc' => __( 'Enable this Setting', '<%= plugin_text_domain %>' ),
			'id' => $this->get_option_name( 'checkbox_name' ),
			'title' => __( 'Checbox Setting Title', 'lifterlms' ),
			'type' => 'checkbox',
		);

		return $settings;

	}

	/**
	 * Determine if integration dependencies are available
	 *
	 * @since <%= plugin_version %>
	 *
	 * @return boolean
	 */
	public function is_installed() {
		return true;
	}

}
