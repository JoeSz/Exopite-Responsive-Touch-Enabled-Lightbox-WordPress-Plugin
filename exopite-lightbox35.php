<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://joe.szalai.org/
 * @since             20170726
 * @package           exopite_Lightbox35
 *
 * @wordpress-plugin
 * Plugin Name:       Exopite Lightbox35
 * Plugin URI:        http://joe.szalai.org/
 * Description:       Responsive, Touch-enabled, jQuery Image Lightbox Plugin. Open images and divs (with class "lightbox35-lightbox") in the given selector. Fast, lightwieght and freeware. Based on: http://vilsoni.info/demo/?i=ilb.
 * Version:           1.1.0
 * Author:            Joe Szalai
 * Author URI:        http://joe.szalai.org/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       exopite-lightbox35
 * Domain Path:       /languages
 */

/*
Guide:
Boilerplate
https://scotch.io/tutorials/how-to-build-a-wordpress-plugin-part-1
https://www.sitepoint.com/wordpress-plugin-boilerplate-part-2-developing-a-plugin/

WordPress i18n and Localization
https://www.sitepoint.com/wordpress-i18n/
https://www.sitepoint.com/wordpress-i18n-make-your-plugin-translation-ready/
 */
/*
ToDo:
 - hooks?
 - wrap it in a class
 - fix __/_e Text Domain
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-exopite-lightbox35.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_exopite_lightbox35() {

	$plugin = new exopite_Lightbox35();
	$plugin->run();

}
run_exopite_lightbox35();
