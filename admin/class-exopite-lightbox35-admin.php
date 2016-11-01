<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://joe.szalai.org/
 * @since      1.0.0
 *
 * @package    exopite_Lightbox35
 * @subpackage exopite_Lightbox35/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    exopite_Lightbox35
 * @subpackage exopite_Lightbox35/admin
 * @author     Joe Szalai <joe@szalai.org>
 */
/**
 * ToDo:
 * - if a href <> img src, load a
 * - add download
 * - add humbnail list?
 * - add open in new window
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class exopite_Lightbox35_Admin {

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

	// From here
	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */

	public function add_plugin_admin_menu() {

	    /*
	     * Add a settings page for this plugin to the Settings menu.
	     *
	     * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
	     *
	     *        Administration Menus: http://codex.wordpress.org/Administration_Menus
	     *
	     */
	    //add_options_page( 'exopite LightBox35 Options Functions Setup', 'exopite LightBox35', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
	    add_submenu_page( 'plugins.php', 'Exopite LightBox35 Options Functions Setup', 'Exopite LightBox35', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
	    );
	}

	 /**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */

	public function add_action_links( $links ) {
	    /*
	    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
	    */
	   $settings_link = array(
	    '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	   );
	   return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_setup_page() {
	    include_once( 'partials/exopite-lightbox35-admin-display.php' );
	}

	/**
	 * Validate fields from admin area plugin settings form ('exopite-lazy-load-xt-admin-display.php')
	 * @param  mixed $input as field form settings form
	 * @return mixed as validated fields
	 */
	public function validate($input) {
	    // All checkboxes inputs
	    $valid = array();

		$valid['single_image_only'] = (isset($input['single_image_only']) && !empty($input['single_image_only'])) ? 1 : 0;
		$valid['hide_caption'] = (isset($input['hide_caption']) && !empty($input['hide_caption'])) ? 1 : 0;
		$valid['hide_thumbnails'] = (isset($input['hide_thumbnails']) && !empty($input['hide_thumbnails'])) ? 1 : 0;
		$valid['hide_open_in_new_window'] = (isset($input['hide_open_in_new_window']) && !empty($input['hide_open_in_new_window'])) ? 1 : 0;
		$valid['hide_download'] = (isset($input['hide_download']) && !empty($input['hide_download'])) ? 1 : 0;
	    $valid['style'] = (isset($input['style']) && !empty($input['style'])) ? esc_attr($input['style']) : 1;
	    $valid['animation'] = (isset($input['animation']) && !empty($input['animation'])) ? esc_attr($input['animation']) : 'slide';
	    $valid['main_container'] = (isset($input['main_container']) && !empty($input['main_container'])) ? esc_attr($input['main_container']) : '.entry-thumbnail, .entry-header, .entry-content';

	    return $valid;
	}

	public function options_update() {
		register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
	}

}
