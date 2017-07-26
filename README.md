# Responsive Touch-enabled Jquery Image Lightbox
## Wordpress Plugin

- Author: Joe Szalai
- Original idea von Wily
- Version: 20170726
- Plugin URL: https://github.com/JoeSz/exopite-lightbox35
- Author URL: http://joe.szalai.org
- License: GNU General Public License v3 or later
- License URI: http://www.gnu.org/licenses/gpl-3.0.html

DESCRIPTION
-----------

Responsive Touch-enabled jQuery Image Lightbox. (See screenshots)

- Open images and divs with lightbox effect.
- Navigate through arrow keys, mouse wheel, click, tap or swipe.
- Responsive (working well on mobiles too).
- Touch-enabled.
- Thumbnail navigation.
- Translation ready.
- Fast and lightweight. (The JavaScript is only  8.32 KB)
- Auto, gallery and single mode

#### Open images and divs

- Open all divs with a class `lightbox35-lightbox`.
- Open all images which inside a link tag, except with `lightbox35-no-lightbox` class.
- With the class `lightbox35-no-gallery`, will not listed in the gallery, but opens individually.
- Gallery mode: open images with a class `lightbox35-gallery` and navigate between them, every other, images open as single

#### Navigate through elements

- Arrow keys.
- Mouse wheel.
- Click on the left or right side of the images.
- Tap on the left or right side of the images.
- Thumbnail navigation.

#### Caption on the image

Caption on the image, the program looking for the div inside in the link (A) tag with a class "lightbox35-lightbox-caption", if none, then looking for the image title attribute. With CSS you can customize the look and feel. You can use HTML inside div caption but because nested link are invalid, please place your link inside caption div like: [url="link" attribute="value"]name of the link[/url].

Deskop                     |  Mobile                |  Admin options
:-------------------------:|:----------------------:|:-------------------------:
![](assets/screenshot-1.jpg)      |  ![](assets/screenshot-2.jpg) |  ![](assets/screenshot-3.jpg)

REQUIREMENTS
------------

Server

* WordPress 4.0+ (May work with earlier versions too)
* PHP 5.3+ (Required)
* jQuery 1.9.1+

Browsers

* Modern Browsers
* Firefox, Chrome, Safari, Opera, IE 10+
* Tested on Firefox, Chrome, Edge, IE 11

INSTALLATION
------------

1. Upload "lightbox35" to the "/wp-content/plugins/" directory.
2. Activate the plugin through the "Plugins" menu in WordPress.

INSTALLATION
------------

1. [x] Upload `exopite-lightbox35` to the `/wp-content/plugins/exopite-lightbox35/` directory

OR

1. [ ] ~~Install plugin from WordPress repository (not yet)~~

2. [x] Activate the plugin through the 'Plugins' menu in WordPress

CHANGELOG
---------

= 20170726 =
* ADDED: Gallery mode, open gallery with a class, every other image as single

= 20170725 =
* FIX: multiple image with anchor point not to image

= 1.1.0 =
* Initial release


LICENSE DETAILS
---------------
The GPL license of Sticky anything without cloning it grants you the right to use, study, share (copy), modify and (re)distribute the software, as long as these license terms are retained.

DISCLAMER
---------

NO WARRANTY OF ANY KIND! USE THIS SOFTWARES AND INFORMATIONS AT YOUR OWN RISK! READ DISCLAMER.TXT!
License: GNU General Public License v3
