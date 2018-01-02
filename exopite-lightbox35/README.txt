=== Plugin Name ===
Contributors: (this should be a list of wordpress.org userid's)
Donate link: http://joe.szalai.org/
Tags: lightbox, photo, photos, image, images, video, gallery, lightview, picture, pictures, overlay
Version: 20180102
Requires at least: 4.0
Tested up to: 4.2
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Responsive Touch-enabled jQuery Image Lightbox Plugin.

== Description ==
Responsive Touch-enabled jQuery Image Lightbox. (See screenshots)

- Open images and divs with lightbox effect.
- Navigate through arrow keys, mouse wheel, click, tap or swipe.
- Responsive (working well on mobiles too).
- Touch-enabled.
- Thumbnail navigation.
- Translation ready.
- Fast and lightweight. (The JavaScript is only  8.32 KB)
- Auto, gallery and single mode

Live preview: https://joe.szalai.org/exopite/lightbox35/

#### Open images and divs

- Open all divs with a class `lightbox35-lightbox`.
- Open all images which inside a link tag, except with `lightbox35-no-lightbox` class.
- With the class `lightbox35-no-gallery`, will not listed in the gallery, but opens individually.
- Gallery mode: open images with a class `lightbox35-gallery` and navigate between them, every other, images open as single

#### Navigate through elements

- Awrow keys.
- Mouse wheel.
- Click on the left or right side of the images.
- Tap on the left or right side of the images.
- Thumbnail navigation.

#### Caption on the image

Caption on the image, the program looking for the div inside in the link (A) tag with a class "lightbox35-lightbox-caption", if none, then looking for the image title attribute. With CSS you can customize the look and feel. You can use HTML inside div caption but because nested link are invalid, please place your link inside caption div like: [url="link" attribute="value"]name of the link[/url].

= Requirements =

Server

* WordPress 4.0+ (May work with earlier versions too)
* PHP 5+ (Required)
* jQuery 1.9.1+

Browsers

* Modern Browsers
* Firefox, Chrome, Safari, Opera, IE 10+
* Tested on Firefox, Chrome, Edge, IE 11

== Installation ==

1. Upload "lightbox35" to the "/wp-content/plugins/" directory.
2. Activate the plugin through the "Plugins" menu in WordPress.

== Screenshots ==

1. Looks.(screenshot-1.jpg).

== Changelog ==

= 20180102 - 2018-01-02 =
* Added: new options menu.

= 20170727 =
* FIXED: Remove broken link from info
* ENHANCEMENT: Regroup "modes"

= 20170726 =
* ADDED: Gallery mode, open gallery with a class, every other image as single

= 20170725 =
* FIXED: multiple image with anchor point not to image

= 1.1.0 =
* Initial release.

== License Details ==

The GPL license of Sticky anything without cloning it grants you the right to use, study, share (copy), modify and (re)distribute the software, as long as these license terms are retained.
