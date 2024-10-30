<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.colijn-it.nl
 * @since      1.0.0
 *
 * @package    ione360_configurator
 * @subpackage ione360_configurator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    ione360_configurator
 * @subpackage ione360_configurator/admin
 * @author     Colijn-IT <info@colijn-it.nl>
 */
class ione360_configurator_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action('admin_menu', array( $this, 'addPluginAdminMenu' ), 9);
	  add_action('admin_init', array( $this, 'registerAndBuildFields' ));

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in ione360_configurator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The ione360_configurator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/configurator-iOne360-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in ione360_configurator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The ione360_configurator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/configurator-iOne360-admin.js', array( 'jquery' ), $this->version, false );

	}

		public function addPluginAdminMenu() {
			//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
			add_menu_page(  $this->plugin_name, 'iOne Configurator', 'administrator', $this->plugin_name, array( $this, 'displayPluginAdminDashboard' ), 'dashicons-visibility', 99 );

			//add_submenu_page( '$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
				add_submenu_page( $this->plugin_name, 'Configurator Render', 'Render Settings', 'administrator', $this->plugin_name.'-rendersettings', array( $this, 'displayPluginAdminSettingsrender' ));



		}
		public function displayPluginAdminDashboard() {
			require_once 'partials/'.$this->plugin_name.'-admin-display.php';
	  }
		public function displayPluginAdminSettings() {
			// set this var to be used in the settings-display view
			$active_tab = isset( $_GET[ 'tab' ] ) ? sanitize_text_field($_GET[ 'tab' ]) : 'general';
			if(isset($_GET['error_message'])){
					add_action('admin_notices', array($this,'settingsConfiguratorMessages'));
					do_action( 'admin_notices', $_GET['error_message'] );
			}
			require_once 'partials/'.$this->plugin_name.'-admin-settings-display.php';
		}

		public function displayPluginAdminSettingsrender() {
			// set this var to be used in the settings-display view
			$active_tab = isset( $_GET[ 'tab' ] ) ? sanitize_text_field($_GET[ 'tab' ]) : 'rendersettings';
			if(isset($_GET['error_message'])){
					add_action('admin_notices', array($this,'settingsConfiguratorMessages'));
					do_action( 'admin_notices', $_GET['error_message'] );
			}
			require_once 'partials/'.$this->plugin_name.'-admin-settings-render-display.php';
		}

		public function settingsConfiguratorMessages($error_message){
			switch ($error_message) {
					case '1':
							$message = __( 'There was an error adding this setting. Please try again.  If this persists, shoot us an email.', 'my-text-domain' );                 $err_code = esc_attr( 'configurator_example_setting' );                 $setting_field = 'configurator_example_setting';
							break;
			}
			$type = 'error';
			add_settings_error(
						$setting_field,
						$err_code,
						$message,
						$type
				);
		}
		public function registerAndBuildFields() {
				/**
			 * First, we add_settings_section. This is necessary since all future settings must belong to one.
			 * Second, add_settings_field
			 * Third, register_setting
			 */
			add_settings_section(
				// ID used to identify this section and with which to register options
				'configurator_general_section',
				// Title to be displayed on the administration page
				'',
				// Callback used to render the description of the section
					array( $this, 'configurator_display_general_account' ),
				// Page on which to add this section of options
				'configurator_general_settings'
			);

			add_settings_section(
				// ID used to identify this section and with which to register options
				'configurator_render_settings_section',
				// Title to be displayed on the administration page
				'',
				// Callback used to render the description of the section
					'',
				// Page on which to add this section of options
				'configurator_render_settings'
			);

			/* EXAMPLE INPUT
								'type'      => 'input',
								'subtype'   => '',
								'id'    => $this->plugin_name.'_example_setting',
								'name'      => $this->plugin_name.'_example_setting',
								'required' => 'required="required"',
								'get_option_list' => "",
									'value_type' = serialized OR normal,
			'wp_data'=>(option or post_meta),
			'post_id' =>
			*/

			unset($args);
			$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_endpoint_setting',
							'name'      => 'configurator_endpoint_setting',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_endpoint_setting',
			'iOne endpoint',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_general_settings',
			'configurator_general_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_scheme_setting',
							'name'      => 'configurator_scheme_setting',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_scheme_setting',
			'iOne scheme',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_general_settings',
			'configurator_general_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_version_setting',
							'name'      => 'configurator_version_setting',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_version_setting',
			'iOne version',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_general_settings',
			'configurator_general_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_cdn_setting',
							'name'      => 'configurator_cdn_setting',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_cdn_setting',
			'iOne cdn',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_general_settings',
			'configurator_general_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_assets_setting',
							'name'      => 'configurator_assets_setting',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_assets_setting',
			'iOne assets',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_general_settings',
			'configurator_general_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_language_setting',
							'name'      => 'configurator_language_setting',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_language_setting',
			'iOne language',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_general_settings',
			'configurator_general_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_gtm_setting',
							'name'      => 'configurator_gtm_setting',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
		);
		add_settings_field(
			'configurator_gtm_setting',
			'GTM Code',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_general_settings',
			'configurator_general_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_lightpresetsindex_setting',
							'name'      => 'configurator_lightpresetsindex_setting',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
		);
		add_settings_field(
			'configurator_lightpresetsindex_setting',
			'Light Presets Index',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_general_settings',
			'configurator_general_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_timeoutinms_setting',
							'name'      => 'configurator_timeoutinms_setting',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
		);
		add_settings_field(
			'configurator_timeoutinms_setting',
			'Timeout in Ms',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_general_settings',
			'configurator_general_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'checkbox',
							'id'    => 'configurator_standaloneARButton_setting',
							'name'      => 'configurator_standaloneARButton_setting',
							'required' => 'true',
							'value'		=>	'',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_standaloneARButton_setting',
			'iOne AR button',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_general_settings',
			'configurator_general_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'checkbox',
							'id'    => 'configurator_AREnabled_setting',
							'name'      => 'configurator_AREnabled_setting',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_AREnabled_setting',
			'AR enabled',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_general_settings',
			'configurator_general_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'checkbox',
							'id'    => 'configurator_standaloneFloors_setting',
							'name'      => 'configurator_standaloneFloors_setting',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'boolean',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_standaloneFloors_setting',
			'use standalone floors',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_general_settings',
			'configurator_general_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'checkbox',
							'id'    => 'configurator_inlineAnswers_setting',
							'name'      => 'configurator_inlineAnswers_setting',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_inlineAnswers_setting',
			'inline answers',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_general_settings',
			'configurator_general_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'checkbox',
							'id'    => 'configurator_showAsConfigured_setting',
							'name'      => 'configurator_showAsConfigured_setting',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_showAsConfigured_setting',
			'show as configured',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_general_settings',
			'configurator_general_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'checkbox',
							'id'    => 'configurator_vrEnabled_setting',
							'name'      => 'configurator_vrEnabled_setting',
							'required' => 'true',
							'value'		=>	'',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_vrEnabled_setting',
			'VR Enabled',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_general_settings',
			'configurator_general_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'checkbox',
							'id'    => 'configurator_show3dwatermark_setting',
							'name'      => 'configurator_show3dwatermark_setting',
							'required' => 'true',
							'value'		=>	'',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_show3dwatermark_setting',
			'Show 3D Watermark',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_general_settings',
			'configurator_general_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'checkbox',
							'id'    => 'configurator_showtagfilter_setting',
							'name'      => 'configurator_showtagfilter_setting',
							'required' => 'true',
							'value'		=>	'',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_showtagfilter_setting',
			'Show Tag Filter',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_general_settings',
			'configurator_general_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'checkbox',
							'id'    => 'configurator_showzoombutton_setting',
							'name'      => 'configurator_showzoombutton_setting',
							'required' => 'true',
							'value'		=>	'',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_showzoombutton_setting',
			'Show Zoom Button',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_general_settings',
			'configurator_general_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'checkbox',
							'id'    => 'configurator_showstockstatus_setting',
							'name'      => 'configurator_showstockstatus_setting',
							'required' => 'true',
							'value'		=>	'',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_showstockstatus_setting',
			'Show Stock Status',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_general_settings',
			'configurator_general_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_render_host_setting',
							'name'      => 'configurator_render_host_setting',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_render_host_setting',
			'iOne host adress',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_render_settings',
			'configurator_render_settings_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_render_port_setting',
							'name'      => 'configurator_render_port_setting',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_render_port_setting',
			'iOne port',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_render_settings',
			'configurator_render_settings_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_rendermode',
							'name'      => 'configurator_rendermode',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_rendermode',
			'Render Mode',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_render_settings',
			'configurator_render_settings_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_render_camRotationX',
							'name'      => 'configurator_render_camRotationX',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_render_camRotationX',
			'Camera Rotation X',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_render_settings',
			'configurator_render_settings_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_render_camRotationY',
							'name'      => 'configurator_render_camRotationY',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_render_camRotationY',
			'Camera Rotation Y',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_render_settings',
			'configurator_render_settings_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_render_environmentName',
							'name'      => 'configurator_render_environmentName',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_render_environmentName',
			'Environment Name',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_render_settings',
			'configurator_render_settings_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_render_environmentRotation',
							'name'      => 'configurator_render_environmentRotation',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_render_environmentRotation',
			'Environment Rotation',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_render_settings',
			'configurator_render_settings_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_render_environmentIntensity',
							'name'      => 'configurator_render_environmentIntensity',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_render_environmentIntensity',
			'Environment Intensity',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_render_settings',
			'configurator_render_settings_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_render_imageWidth',
							'name'      => 'configurator_render_imageWidth',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_render_imageWidth',
			'Image Width',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_render_settings',
			'configurator_render_settings_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_render_imageHeight',
							'name'      => 'configurator_render_imageHeight',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_render_imageHeight',
			'Image Height',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_render_settings',
			'configurator_render_settings_section',
			$args
		);
		$args = array (
							'type'      => 'input',
							'subtype'   => 'text',
							'id'    => 'configurator_render_boundingBoxFit',
							'name'      => 'configurator_render_boundingBoxFit',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_render_boundingBoxFit',
			'Bounding Box Fit',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_render_settings',
			'configurator_render_settings_section',
			$args
		);

		$args = array (
							'type'      => 'input',
							'subtype'   => 'checkbox',
							'id'    => 'configurator_render_button',
							'name'      => 'configurator_render_button',
							'required' => 'true',
							'get_options_list' => '',
							'value_type'=>'normal',
							'wp_data' => 'option',
							'sanitize_callback' => 'sanitize_text_field'
					);
		add_settings_field(
			'configurator_render_button',
			'Force Render Button',
			array( $this, 'configurator_render_settings_field' ),
			'configurator_render_settings',
			'configurator_render_settings_section',
			$args
		);

		register_setting('configurator_general_settings', 'configurator_endpoint_setting');
		register_setting('configurator_general_settings', 'configurator_scheme_setting');
		register_setting('configurator_general_settings',	'configurator_version_setting');
		register_setting('configurator_general_settings',	'configurator_cdn_setting');
		register_setting('configurator_general_settings',	'configurator_assets_setting');
		register_setting('configurator_general_settings',	'configurator_language_setting');
		register_setting('configurator_general_settings',	'configurator_gtm_setting');
		register_setting('configurator_general_settings',	'configurator_lightpresetsindex_setting');
		register_setting('configurator_general_settings',	'configurator_timeoutinms_setting');
		register_setting('configurator_general_settings', 'configurator_standaloneARButton_setting');
		register_setting('configurator_general_settings', 'configurator_AREnabled_setting');
		register_setting('configurator_general_settings', 'configurator_standaloneFloors_setting');
		register_setting('configurator_general_settings', 'configurator_inlineAnswers_setting');
		register_setting('configurator_general_settings', 'configurator_showAsConfigured_setting');
		register_setting('configurator_general_settings', 'configurator_vrEnabled_setting');
		register_setting('configurator_general_settings', 'configurator_show3dwatermark_setting');
		register_setting('configurator_general_settings', 'configurator_showtagfilter_setting');
		register_setting('configurator_general_settings', 'configurator_showzoombutton_setting');
		register_setting('configurator_general_settings', 'configurator_showstockstatus_setting');
		register_setting('configurator_render_settings', 'configurator_render_host_setting');
		register_setting('configurator_render_settings', 'configurator_render_port_setting');
		register_setting('configurator_render_settings', 'configurator_rendermode');
		register_setting('configurator_render_settings', 'configurator_render_camRotationX');
		register_setting('configurator_render_settings', 'configurator_render_camRotationY');
		register_setting('configurator_render_settings', 'configurator_render_environmentName');
		register_setting('configurator_render_settings', 'configurator_render_environmentRotation');
		register_setting('configurator_render_settings', 'configurator_render_environmentIntensity');
		register_setting('configurator_render_settings', 'configurator_render_imageWidth');
		register_setting('configurator_render_settings', 'configurator_render_imageHeight');
		register_setting('configurator_render_settings', 'configurator_render_boundingBoxFit');
		register_setting('configurator_render_settings', 'configurator_render_button');


		}
		public function configurator_display_general_account() {
			echo '<p>These are the iOne Configurator connection settings.</p>';
		}

		public function configurator_render_settings_field($args) {

			if($args['wp_data'] == 'option'){
				$wp_data_value = get_option($args['name']);
			} elseif($args['wp_data'] == 'post_meta'){
				$wp_data_value = get_post_meta($args['post_id'], $args['name'], true );
			}
			switch ($args['type']) {
				case 'input':
						$value = ($args['value_type'] == 'serialized') ? serialize($wp_data_value) : $wp_data_value;
						if($args['subtype'] != 'checkbox'){
								$prependStart = (isset($args['prepend_value'])) ? '<div class="input-prepend"> <span class="add-on">'.$args['prepend_value'].'</span>' : '';
								$prependEnd = (isset($args['prepend_value'])) ? '</div>' : '';
								$step = (isset($args['step'])) ? 'step="'.$args['step'].'"' : '';
								$min = (isset($args['min'])) ? 'min="'.$args['min'].'"' : '';
								$max = (isset($args['max'])) ? 'max="'.$args['max'].'"' : '';
								if(isset($args['enabled'])){
										// hide the actual input bc if it was just a disabled input the info saved in the database would be wrong - bc it would pass empty values and wipe the actual information
										echo esc_html($prependStart).'<input type="'.esc_attr($args['subtype']).'" id="'.esc_attr($args['id']).'_disabled" '.esc_attr($step).' '.esc_attr($max).' '.esc_attr($min).' name="'.esc_attr($args['name']).'_disabled" size="40" disabled value="' . esc_attr($value) . '" /><input type="hidden" id="'.esc_attr($args['id']).'" '.esc_attr($step).' '.esc_attr($max).' '.esc_attr($min).' name="'.esc_attr($args['name']).'" size="40" value="' . esc_attr($value) . '" />'.esc_attr($prependEnd);
								} else {
										echo esc_html($prependStart).'<input type="'.esc_attr($args['subtype']).'" id="'.esc_attr($args['id']).'" "'.esc_attr($args['required']).'" '.esc_attr($step).' '.esc_attr($max).' '.esc_attr($min).'name="'.esc_attr($args['name']).'" size="40" value="' . esc_attr($value) . '" />'.esc_attr($prependEnd);
								}
								/*<input required="required" '.$disabled.' type="number" step="any" id="'.$this->plugin_name.'_cost2" name="'.$this->plugin_name.'_cost2" value="' . esc_attr( $cost ) . '" size="25" /><input type="hidden" id="'.$this->plugin_name.'_cost" step="any" name="'.$this->plugin_name.'_cost" value="' . esc_attr( $cost ) . '" />*/
						} else {
								$checked = (esc_attr($value)) ? 'checked' : '';
								echo '<input type="'.esc_attr($args['subtype']).'" id="'.esc_attr($args['id']).'" "'.esc_attr($args['required']).'" name="'.esc_attr($args['name']).'" size="40" value="1" '.esc_attr($checked).' />';
						}
						break;
				default:
						# code...
						break;
			}
		}
}
