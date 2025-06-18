<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.wilhemarnoldy.fr
 * @since             1.2
 * @package           Wa_AetJ
 *
 * @wordpress-plugin
 * Plugin Name:       WA ART&JARDINS Global functions
 * Plugin URI:        https://www.wilhemarnoldy.fr
 * Description:       A plugin to add functionnalities to the Arts & Jardins website.
 * Version:           1.0
 * Author:            Wilhem Arnoldy
 * Author URI:        https://www.wilhemarnoldy.fr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wa-aetj
 * Domain Path:       /languages
 * https://wppb.me
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if( !defined("IS_ADMIN"))
	define("IS_ADMIN",  is_admin());

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WA_AETJ_VERSION', '1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wa-aetj-activator.php
 */
function activate_wa_aetj() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wa-aetj-activator.php';
	Wa_AetJ_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wa-aetj-deactivator.php
 */
function deactivate_wa_aetj() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wa-aetj-deactivator.php';
	Wa_AetJ_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wa_aetj' );
register_deactivation_hook( __FILE__, 'deactivate_wa_aetj' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wa-aetj.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wa_aetj() {

	$plugin = new Wa_AetJ();
	$plugin->run();

}
run_wa_aetj();