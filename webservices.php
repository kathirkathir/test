<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://localhost/foodtruck/
 * @since             1.0.0
 * @package           Webservices
 *
 * @wordpress-plugin
 * Plugin Name:       Webservices
 * Plugin URI:        webservices
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Developer
 * Author URI:        http://localhost/foodtruck/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       webservices
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-webservices-activator.php
 */
function activate_webservices() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-webservices-activator.php';
	Webservices_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-webservices-deactivator.php
 */
function deactivate_webservices() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-webservices-deactivator.php';
	Webservices_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_webservices' );
register_deactivation_hook( __FILE__, 'deactivate_webservices' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-webservices.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_webservices() {

	$plugin = new Webservices();
	$plugin->run();

}
run_webservices();
