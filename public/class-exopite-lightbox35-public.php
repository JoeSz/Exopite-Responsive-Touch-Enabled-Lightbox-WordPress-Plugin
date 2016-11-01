<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://joe.szalai.org/
 * @since      1.0.0
 *
 * @package    exopite_Lightbox35
 * @subpackage exopite_Lightbox35/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    exopite_Lightbox35
 * @subpackage exopite_Lightbox35/public
 * @author     Joe Szalai <joe@szalai.org>
 */
class exopite_Lightbox35_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in exopite_Lightbox35_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The exopite_Lightbox35_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/exopite-lightbox35-public.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in exopite_Lightbox35_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The exopite_Lightbox35_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_script('jquery-touch-swipe', "https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.15/jquery.touchSwipe.min.js", array('jquery'), '1.9.1', true);
		wp_enqueue_script('jquery-touch-swipe');

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/exopite-lightbox35-public.min.js', array( 'jquery-touch-swipe' ), $this->version, true );

		// pass args to jQuery
		// Source: http://code.tutsplus.com/tutorials/how-to-pass-php-data-and-strings-to-javascript-in-wordpress--wp-34699
		$options = get_option($this->plugin_name);
        $style = (isset($options['style']) && !empty($options['style'])) ? esc_attr($options['style']) : '1';
        $animation = (isset($options['animation']) && !empty($options['animation'])) ? esc_attr($options['animation']) : 'slide';
        $main_container = (isset($options['main_container']) && !empty($options['main_container'])) ? esc_attr($options['main_container']) : '.entry-thumbnail, .entry-header, .entry-content';
        $single_image_only = (isset($options['single_image_only']) && !empty($options['single_image_only'])) ? 1 : 0;
        $hide_caption = (isset($options['hide_caption']) && !empty($options['hide_caption'])) ? 1 : 0;
        $hide_thumbnails = (isset($options['hide_thumbnails']) && !empty($options['hide_thumbnails'])) ? 1 : 0;
        $hide_open_in_new_window = (isset($options['hide_open_in_new_window']) && !empty($options['hide_open_in_new_window'])) ? 1 : 0;
        $hide_download = (isset($options['hide_download']) && !empty($options['hide_download'])) ? 1 : 0;

		$exopite_lightbox35_js_options = array(
		    'main_container'  	=> $main_container,
		    'lightbox35_style'	=> $style,
		    'animation'			=> $animation,
		    'single_image_only'	=> $single_image_only,
		    'hide_caption'		=> $hide_caption,
		    'hide_thumbnails'	=> $hide_thumbnails,
		    'hide_open_in_new_window' 	=> $hide_open_in_new_window,
		    'hide_download'		=> $hide_download,
		    'plugin_url'		=> plugins_url() . '/' . $this->plugin_name,
		    'lang_download'			=> __('download', $this->plugin_name),
		    'lang_openInNewWindow'			=> __('open', $this->plugin_name),

		);
		wp_localize_script( $this->plugin_name, 'exopite_lightbox35_vars', $exopite_lightbox35_js_options );
	}

}
