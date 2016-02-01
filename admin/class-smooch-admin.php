<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://twitter.com/gozmike
 * @since      1.0.0
 *
 * @package    Smooch
 * @subpackage Smooch/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Smooch
 * @subpackage Smooch/admin
 * @author     Mike Gozzo <mike@smooch.io>
 */
class Smooch_Admin {

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
		 * defined in Smooch_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Smooch_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/smooch-admin.css', array(), $this->version, 'all' );

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
		 * defined in Smooch_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Smooch_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/smooch-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Adds a settings page link to a menu
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function add_menu() {
		// add_options_page( $page_title, $menu_title, $capability, $menu_slug, $callback );

		add_options_page(
			apply_filters( $this->plugin_name . '-settings-page-title', __( 'Smooch Settings', 'smooch-wordpress' ) ),
			apply_filters( $this->plugin_name . '-settings-menu-title', __( 'Smooch', 'smooch-wordpress' ) ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'options_page' )
		);

	} // add_menu()	

	public function options_page() {

		?><h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
		<form method="post" action="options.php"><?php

		settings_fields( $this->plugin_name . '-options' );

		do_settings_sections( $this->plugin_name );

		submit_button( 'Save Settings' );

		?></form><?php

	} // options_page()	

	/**
	 * Registers plugin settings, sections, and fields
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function register_settings() {

		// register_setting( $option_group, $option_name, $sanitize_callback );

		register_setting(
			$this->plugin_name . '-options',
			$this->plugin_name . '-options',
			array( $this, 'validate_options' )
		);

		// add_settings_section( $id, $title, $callback, $menu_slug );

		add_settings_section(
			$this->plugin_name . '-basic-info',
			apply_filters( $this->plugin_name . '-display-section-title', __( 'Connecting Smooch to your WordPress Site', 'smooch-wordpress' ) ),
			array( $this, 'display_options_section' ),
			$this->plugin_name
		);

		// add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );

		add_settings_field(
			'app-token',
			apply_filters( $this->plugin_name . '-app-token-label', __( 'App Token', 'smooch-wordpress' ) ),
			array( $this, 'app_token_field' ),
			$this->plugin_name,
			$this->plugin_name . '-basic-info'
		);

	} // register_settings()

	/**
	 * Creates a settings section
	 *
	 * @since 		1.0.0
	 * @param 		array 		$params 		Array of parameters for the section
	 * @return 		mixed 						The settings section
	 */
	public function display_options_section( $params ) {
		?> 
		<p>Smooch lets you speak to your web visitors or app users from your inbox, Slack, Help Scout or favourite CRM. This plugin makes connecting your WordPress site to Smooch a breeze.</p>
		<p>It's free to use on the web. Get an app token by logging in (or signing up for free) at <a href="https://app.smooch.io">app.smooch.io</a>. Paste this token into the field below and you'll be ready for action.</p>
		<?php
	} // display_options_section()

	/**
	 * Creates a settings field
	 *
	 * @since 		1.0.0
	 * @return 		mixed 			The settings field
	 */
	public function app_token_field() {

		$options 	= get_option( $this->plugin_name . '-options' );
		$option 	= 0;

		if ( ! empty( $options['app-token'] ) ) {

			$option = $options['app-token'];

		}

		?><input type="text" id="<?php echo $this->plugin_name; ?>-options[app-token]" name="<?php echo $this->plugin_name; ?>-options[app-token]" value="<?php echo esc_attr( $option ); ?>"><?php

	} // display_options_field()

	/**
	 * Validates saved options
	 *
	 * @since 		1.0.0
	 * @param 		array 		$input 			array of submitted plugin options
	 * @return 		array 						array of validated plugin options
	 */
	public function validate_options( $input ) {

		$valid = array();

		if ( isset( $input['app-token'] ) ) {

			$app_token 			= trim( $input['app-token'] );
			$valid['app-token'] 	= sanitize_text_field( $app_token );

			if ( $valid['app-token'] != $input['app-token'] ) {

				add_settings_error( 'app-token', 'app-token-error', __( 'App token error.', 'smooch-wordpress' ), 'error' );

			}

		}

		return $valid;

	} // validate_options()
}
