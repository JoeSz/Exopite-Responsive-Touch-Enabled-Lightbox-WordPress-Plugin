<?php

/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://joe.szalai.org/
 * @since      1.0.0
 *
 * @package    exopite_Lightbox35
 * @subpackage exopite_Lightbox35/admin/partials
 */
// From here
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h2>Exopite LightBox35 <?php _e(' Options', $this->plugin_name); ?></h2>
    <form method="post" name="cleanup_options" action="options.php">
    <?php
        //Grab all options
        $options = get_option($this->plugin_name);

        $style = (isset($options['style']) && !empty($options['style'])) ? esc_attr($options['style']) : '1';
        $animation = (isset($options['animation']) && !empty($options['animation'])) ? esc_attr($options['animation']) : 'slide';
        $main_container = (isset($options['main_container']) && !empty($options['main_container'])) ? esc_attr($options['main_container']) : '.entry-thumbnail, .entry-header, .entry-content';
        $single_image_only = (isset($options['single_image_only']) && !empty($options['single_image_only'])) ? 1 : 0;
        $hide_caption = (isset($options['hide_caption']) && !empty($options['hide_caption'])) ? 1 : 0;
        $hide_thumbnails = (isset($options['hide_thumbnails']) && !empty($options['hide_thumbnails'])) ? 1 : 0;
        $hide_open_in_new_window = (isset($options['hide_open_in_new_window']) && !empty($options['hide_open_in_new_window'])) ? 1 : 0;
        $hide_download = (isset($options['hide_download']) && !empty($options['hide_download'])) ? 1 : 0;

        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);

        // Sources: - http://searchengineland.com/tested-googlebot-crawls-javascript-heres-learned-220157
        //          - http://dinbror.dk/blog/lazy-load-images-seo-problem/
        //          - https://webmasters.googleblog.com/2015/10/deprecating-our-ajax-crawling-scheme.html
    ?>
    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-1">
            <div id="post-body-content">

                <div class="meta-box-sortables ui-sortable">

                    <div class="postbox">

                        <div class="handlediv" title="Click to toggle"><br></div>
                        <!-- Toggle -->

                        <h2 class="hndle"><span><?php esc_attr_e( 'Information', $this->plugin_name ); ?></span>
                        </h2>

                        <div class="inside">
                            <p><?php _e('Responsive Touch-enabled jQuery Image Lightbox Plugin. Based on:', $this->plugin_name); ?> <a target="_blank" href="http://vilsoni.info/demo/?i=ilb">http://vilsoni.info/demo/?i=ilb</a>.</p>
                            <p><?php _e('Open all DIVs (required class "lightbox35-lightbox") and images (for images no class required!) on the page, which inside a link tag, except with "lightbox35-no-lightbox" class (this only required for images, div without the "lightbox35-lightbox" class will not listed automatically). Also if the link tag has the class "lightbox35-no-gallery", will not listed in the gallery, but opens individually.', $this->plugin_name); ?></p>
                            <p><?php _e('Caption on the image, the program looking for the div inside in the link (A) tag with a class "lightbox35-lightbox-caption", if none, then looking for the image title attribute. With CSS you can customize the look and feel. You can use HTML inside div caption but because nested link are invalid, please place your link inside caption div like: [url="link" attribute="value"]name of the link[/url].', $this->plugin_name); ?></p>
                            <p><?php _e('Navigate between images with the arrow keys, mouse wheel, click on image left or right side and with a swipe as well.', $this->plugin_name); ?></p>
                            <p><?php _e('Responsive (working well on mobiles too).', $this->plugin_name); ?></p>
                            <p><?php _e('Feel free to modify and share!', $this->plugin_name); ?></p>
                            <p><?php _e('Have fun and thank you for Wily!', $this->plugin_name); ?></p>
                        </div>
                        <!-- .inside -->

                    </div>
                    <!-- .postbox -->

                </div>
                <!-- .meta-box-sortables .ui-sortable -->

            </div>
        </div>
    </div>
    <br class="clear">

    <!-- Single image only -->
    <fieldset>
        <legend class="screen-reader-text">
            <span><?php _e('single_image_only', $this->plugin_name); ?></span>
        </legend>
        <label for="<?php echo $this->plugin_name; ?>-single_image_only">
            <input type="checkbox" id="<?php echo $this->plugin_name; ?>-single_image_only" name="<?php echo $this->plugin_name; ?>[single_image_only]" value="1" <?php checked( $single_image_only, 1 ); ?> />
            <span><?php esc_attr_e('Single image only', $this->plugin_name); ?></span>
        </label>
    </fieldset>

    <!-- Hide caption -->
    <fieldset>
        <legend class="screen-reader-text">
            <span><?php _e('Hide caption', $this->plugin_name); ?></span>
        </legend>
        <label for="<?php echo $this->plugin_name; ?>-hide_caption">
            <input type="checkbox" id="<?php echo $this->plugin_name; ?>-hide_caption" name="<?php echo $this->plugin_name; ?>[hide_caption]" value="1" <?php checked( $hide_caption, 1 ); ?> />
            <span><?php esc_attr_e('Hide caption', $this->plugin_name); ?></span>
        </label>
    </fieldset>

    <!-- Hide thumbnails -->
    <fieldset>
        <legend class="screen-reader-text">
            <span><?php _e('Hide thumbnails', $this->plugin_name); ?></span>
        </legend>
        <label for="<?php echo $this->plugin_name; ?>-hide_thumbnails">
            <input type="checkbox" id="<?php echo $this->plugin_name; ?>-hide_thumbnails" name="<?php echo $this->plugin_name; ?>[hide_thumbnails]" value="1" <?php checked($hide_thumbnails, 1); ?> />
            <span><?php esc_attr_e('Hide thumbnails', $this->plugin_name); ?></span>
        </label>
    </fieldset>

    <!-- Hide open in new window -->
    <fieldset>
        <legend class="screen-reader-text">
            <span><?php _e('Hide open in new window', $this->plugin_name); ?></span>
        </legend>
        <label for="<?php echo $this->plugin_name; ?>-hide_open_in_new_window">
            <input type="checkbox" id="<?php echo $this->plugin_name; ?>-hide_open_in_new_window" name="<?php echo $this->plugin_name; ?>[hide_open_in_new_window]" value="1" <?php checked( $hide_open_in_new_window, 1 ); ?> />
            <span><?php esc_attr_e('Hide open in new window', $this->plugin_name); ?></span>
        </label>
    </fieldset>

    <!-- Hide download -->
    <fieldset>
        <legend class="screen-reader-text">
            <span><?php _e('Hide download', $this->plugin_name); ?></span>
        </legend>
        <label for="<?php echo $this->plugin_name; ?>-hide_download">
            <input type="checkbox" id="<?php echo $this->plugin_name; ?>-hide_download" name="<?php echo $this->plugin_name; ?>[hide_download]" value="1" <?php checked( $hide_download, 1 ); ?> />
            <span><?php esc_attr_e('Hide download', $this->plugin_name); ?></span>
        </label>
    </fieldset>

    <!-- Select Style -->
    <fieldset>
    	<p><?php _e('Caption style.', $this->plugin_name); ?></p>
        <legend class="screen-reader-text">
            <span><?php _e('Caption style', $this->plugin_name); ?></span>
        </legend>
        <label for="lightbox35-style">
			<select name="<?php echo $this->plugin_name; ?>[style]" id="<?php echo $this->plugin_name; ?>-style">
				<option <?php if ( $style == '1' ) echo 'selected="selected"'; ?> value="1">Inline caption</option>
				<option <?php if ( $style == '2' ) echo 'selected="selected"'; ?> value="2">Caption under the image</option>
			</select>
        </label>
    </fieldset>

    <!-- Select Animation -->
    <fieldset>
        <p><?php _e('Changing slide animation.', $this->plugin_name); ?></p>
        <legend class="screen-reader-text">
            <span><?php _e('Changing slide animation', $this->plugin_name); ?></span>
        </legend>
        <label for="lightbox35-animation">
            <select name="<?php echo $this->plugin_name; ?>[animation]" id="<?php echo $this->plugin_name; ?>-animation">
                <option <?php if ( $animation == 'slide' ) echo 'selected="selected"'; ?> value="slide">Slide</option>
                <option <?php if ( $animation == 'fade' ) echo 'selected="selected"'; ?> value="fade">Fade</option>
            </select>
        </label>
    </fieldset>

    <!-- Main container -->
    <fieldset>
        <p><?php _e('You can specify main container here. Exopite LightBox35 looking images for lightbox effect only inside this container.', $this->plugin_name); ?></p>
        <legend class="screen-reader-text">
        	<span><?php _e('Lightbox Main Container', $this->plugin_name); ?></span>
        </legend>
        <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-main_container" name="<?php echo $this->plugin_name; ?>[main_container]" value="<?php if(!empty($main_container)) echo $main_container; else echo '#slide-up-content-container'; ?>"/>
    </fieldset>

	<?php submit_button(__('Save all changes', $this->plugin_name), 'primary','submit', TRUE); ?>
    </form>
</div>
<div>
    <ul style="list-style: disc; padding-left: 30px; font-size: 0.8em; line-height: 1.3em; max-width: 100%;">
        <li><a target="_blank" href="http://wppb.io/"><b>The WordPress Plugin Boilerplate</b></a> <?php _e("A standardized, organized, object-oriented foundation for building high-quality WordPress Plugins.", $this->plugin_name); ?></li>
    </ul>
</div>