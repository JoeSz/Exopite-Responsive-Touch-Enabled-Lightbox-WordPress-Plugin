<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://joe.szalai.org/
 * @since      1.0.0
 *
 * @package    exopite_Lightbox35
 * @subpackage exopite_Lightbox35/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    exopite_Lightbox35
 * @subpackage exopite_Lightbox35/includes
 * @author     Joe Szalai <joe@szalai.org>
 */
class exopite_Lightbox35_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'exopite-lightbox35',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
