<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://twitter.com/gozmike
 * @since             1.0.0
 * @package           Smooch
 *
 * @wordpress-plugin
 * Plugin Name:       Smooch
 * Plugin URI:        https://smooch.io
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Mike Gozzo
 * Author URI:        https://twitter.com/gozmike
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       smooch
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-smooch-activator.php
 */
function activate_smooch() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-smooch-activator.php';
	Smooch_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-smooch-deactivator.php
 */
function deactivate_smooch() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-smooch-deactivator.php';
	Smooch_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_smooch' );
register_deactivation_hook( __FILE__, 'deactivate_smooch' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-smooch.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_smooch() {

	$plugin = new Smooch();
	$plugin->run();

}
run_smooch();
