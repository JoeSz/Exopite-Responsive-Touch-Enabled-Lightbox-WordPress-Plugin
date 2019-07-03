<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://joe.szalai.org/
 * @since             20180102
 * @package           exopite_Lightbox35
 *
 * @wordpress-plugin
 * Plugin Name:       Exopite Lightbox35
 * Plugin URI:        https://joe.szalai.org/exopite/lightbox35/
 * Description:       Responsive, Touch-enabled, jQuery Image Lightbox Plugin. Open images and divs (with class "lightbox35-lightbox") in the given selector. Fast, lightwieght and freeware.
 * Version:           20190521
 * Author:            Joe Szalai
 * Author URI:        https://joe.szalai.org/
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

define( 'EXOPITE_LIGHTBOX35_PATH', plugin_dir_path( __FILE__ ) );
define( 'EXOPITE_LIGHTBOX35_PLUGIN_NAME', 'exopite-lightbox35' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-exopite-lightbox35.php';

/*
 * Update
 */
if ( is_admin() ) {

    /**
     * A custom update checker for WordPress plugins.
     *
     * Useful if you don't want to host your project
     * in the official WP repository, but would still like it to support automatic updates.
     * Despite the name, it also works with themes.
     *
     * @link http://w-shadow.com/blog/2011/06/02/automatic-updates-for-commercial-themes/
     * @link https://github.com/YahnisElsts/plugin-update-checker
     * @link https://github.com/YahnisElsts/wp-update-server
     */
    if( ! class_exists( 'Puc_v4_Factory' ) ) {

        require_once join( DIRECTORY_SEPARATOR, array( EXOPITE_LIGHTBOX35_PATH, 'vendor', 'plugin-update-checker', 'plugin-update-checker.php' ) );

    }

    $MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
        'https://update.joeszalai.org/?action=get_metadata&slug=' . EXOPITE_LIGHTBOX35_PLUGIN_NAME, //Metadata URL.
        __FILE__, //Full path to the main plugin file.
        EXOPITE_LIGHTBOX35_PLUGIN_NAME //Plugin slug. Usually it's the same as the name of the directory.
    );

	/**
	 * add plugin upgrade notification
	 * https://andidittrich.de/2015/05/howto-upgrade-notice-for-wordpress-plugins.html
	 */
	add_action( 'in_plugin_update_message-' . EXOPITE_LIGHTBOX35_PLUGIN_NAME . '/' . EXOPITE_LIGHTBOX35_PLUGIN_NAME .'.php', 'exopite_lightbox35_show_upgrade_notification', 10, 2 );
	function exopite_lightbox35_show_upgrade_notification( $current_plugin_metadata, $new_plugin_metadata ) {

		/**
		 * Check "upgrade_notice" in readme.txt.
		 *
		 * Eg.:
		 * == Upgrade Notice ==
		 * = 20180624 = <- new version
		 * Notice		<- message
		 *
		 */
		if ( isset( $new_plugin_metadata->upgrade_notice ) && strlen( trim( $new_plugin_metadata->upgrade_notice ) ) > 0 ) {

			// Display "upgrade_notice".
			echo sprintf( '<span style="background-color:#d54e21;padding:10px;color:#f9f9f9;margin-top:10px;display:block;"><strong>%1$s: </strong>%2$s</span>', esc_attr( 'Important Upgrade Notice', 'exopite-multifilter' ), esc_html( rtrim( $new_plugin_metadata->upgrade_notice ) ) );

		}
    }

}
// End Update

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
