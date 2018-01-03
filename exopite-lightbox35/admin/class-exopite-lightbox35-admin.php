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

	public function add_plugin_admin_menu() { }

    public function create_menu() {

        $config = array(
            'type'              => 'menu',                          // Required, menu or metabox
            'id'                => $this->plugin_name,    // Required, meta box id, unique per page, to save: get_option( id )
            'menu'              => 'plugins.php',                   // Required, sub page to your options page
            'submenu'           => true,                            // Required for submenu
            'title'             => 'Exopite LightBox35',               //The name of this page
            'capability'        => 'manage_options',                // The capability needed to view the page
            'plugin_basename'   =>  plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' ),
            'tabbed'            => false,
        );

        $fields[] = array(
            'name'   => 'first',
            'fields' => array(

                array(
                    'type'    => 'card',
                    'content' => '<p>' . esc_attr__( 'Responsive Touch-enabled jQuery Image Lightbox Plugin.', 'exopite-lightbox35' ) . '</p>' .
                        esc_attr__( 'Open all DIVs (required class "lightbox35-lightbox") and images (for images no class required!) on the page, which inside a link tag, except with "lightbox35-no-lightbox" class (this only required for images, div without the "lightbox35-lightbox" class will not listed automatically). Also if the link tag has the class "lightbox35-no-gallery", will not listed in the gallery, but opens individually.', 'exopite-lightbox35' ) . '</p>' .
                        esc_attr__( 'Caption on the image, the program looking for the div inside in the link (A) tag with a class "lightbox35-lightbox-caption", if none, then looking for the image title attribute. With CSS you can customize the look and feel. You can use HTML inside div caption but because nested link are invalid, please place your link inside caption div like: [url="link" attribute="value"]name of the link[/url].', 'exopite-lightbox35' ) . '</p>' .
                        esc_attr__( 'Navigate between images with the arrow keys, mouse wheel, click on image left or right side and with a swipe as well.', 'exopite-lightbox35' ) . '</p>' .
                        esc_attr__( 'Responsive (working well on mobiles too).', 'exopite-lightbox35' ) . '</p>' .
                        esc_attr__( 'Feel free to modify and share!', 'exopite-lightbox35' ) . '</p>',
                    'header' => esc_attr__( 'Information', 'exopite-lightbox35' ),
                ),

                array(
                    'id'      => 'single_image_only',
                    'type'    => 'switcher',
                    'title'   => esc_attr__( 'Single image mode', 'exopite-lightbox35' ),
                    'default' => 'no',
                ),

                array(
                    'id'      => 'hide_caption',
                    'type'    => 'switcher',
                    'title'   => esc_attr__( 'Hide caption', 'exopite-lightbox35' ),
                    'default' => 'no',
                ),

                array(
                    'id'      => 'hide_thumbnails',
                    'type'    => 'switcher',
                    'title'   => esc_attr__( 'Hide thumbnails', 'exopite-lightbox35' ),
                    'default' => 'no',
                ),

                array(
                    'id'      => 'hide_open_in_new_window',
                    'type'    => 'switcher',
                    'title'   => esc_attr__( 'Hide open in new window', 'exopite-lightbox35' ),
                    'default' => 'no',
                ),

                array(
                    'id'      => 'hide_download',
                    'type'    => 'switcher',
                    'title'   => esc_attr__( 'Hide download', 'exopite-lightbox35' ),
                    'default' => 'no',
                ),

                array(
                    'id'            => 'style',
                    'type'          => 'select',
                    'title'         => esc_attr__( 'Caption style', 'exopite-lightbox35' ),
                    'options'       => array(
                        '1'             => esc_attr__( 'Inline caption', 'exopite-lightbox35' ),
                        '2'             => esc_attr__( 'Caption under the image', 'exopite-lightbox35' ),
                    ),
                    'default'       => '1',
                    'class'         => 'chosen',
                    'dependency' => array( 'hide_caption', '==', 'false' ),
                ),

                array(
                    'id'            => 'animation',
                    'type'          => 'select',
                    'title'         => esc_attr__( 'Changing slide animation', 'exopite-lightbox35' ),
                    'options'       => array(
                        'slide'         => esc_attr__( 'Slide', 'exopite-lightbox35' ),
                        'fade'          => esc_attr__( 'Fade', 'exopite-lightbox35' ),
                    ),
                    'default'       => 'slide',
                    'class'         => 'chosen',
                ),

                array(
                    'id'        => 'main_container',
                    'type'      => 'text',
                    'title'     => esc_attr__( 'Lightbox Main Container', 'exopite-lightbox35' ),
                    'default'   => '.entry-thumbnail, .entry-header, .entry-content',
                    'before'    => esc_attr__( 'You can specify main container here. Exopite LightBox35 looking images for lightbox effect only inside this container.', 'exopite-lightbox35' ),
                ),

                array(
                    'id'      => 'gallery_mode',
                    'type'    => 'switcher',
                    'title'   => esc_attr__( 'Gallery mode', 'exopite-lightbox35' ),
                    'default' => 'no',
                ),

                array(
                    'id'        => 'gallery_mode_container',
                    'type'      => 'text',
                    'title'     => esc_attr__( 'Gallery Mode Container', 'exopite-lightbox35' ),
                    'default'   => 'lightbox35-gallery',
                    'before'    => esc_attr__( 'You can specify gallery mode class here. Exopite LightBox35 looking images as gallery with this class. Other images will be opened as single. Without the leading point.', 'exopite-lightbox35' ),
                    'dependency' => array( 'gallery_mode', '==', 'true' ),
                ),

                array(
                    'type'    => 'content',
                    'content' => '<ul style="list-style: disc; padding-left: 30px; font-size: 0.8em; line-height: 1.3em; max-width: 100%;"><li><a target="_blank" href="http://wppb.io/"><b>The WordPress Plugin Boilerplate</b></a>' . esc_attr__("A standardized, organized, object-oriented foundation for building high-quality WordPress Plugins.", 'exopite-lightbox35' ) . '</li></ul>',
                ),

            ),
        );

        /**
         * instantiate your admin page
         */
        $options_panel = new Exopite_Simple_Options_Framework( $config, $fields );

    }


}
