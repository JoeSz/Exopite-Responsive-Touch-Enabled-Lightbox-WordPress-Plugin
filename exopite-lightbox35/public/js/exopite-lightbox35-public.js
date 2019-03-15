jQuery(document).ready(function($) {
/*
ToDo:
 - compress: https://jscompress.com/
 - hooks?
 - wrap it in a class
*/
var current, size;

// Get style from plugin settings
// Main element to check image in anchor tags. Can be empty (for all in page) or class (multiple blocks)
// Get container from plugin settings
var container = exopite_lightbox35_vars.main_container;
// style-1 -> below the slide, style-2 -> inside, on the bottom of the slide
var captionStyle = 'lightbox35-caption-style-' + exopite_lightbox35_vars.lightbox35_style;
// Get every image which inside in container + a element without the class "lightbox35-no-lightbox". Can be nested too.
// If you want to use in wordpress, you may add your content selector before the a:not..., otherwise may list your logos, etc. as well.
var selector = container;    // Don't activate lightbox effect link item has "lightbox35-no-lightbox" class
var insideElement = 'a:not(.lightbox35-no-lightbox) img, .lightbox35-lightbox'; // Select all image and elements with 'lightbox35-lightbox' class
var insideElementFigcation = 'a:not(.lightbox35-no-lightbox) figcaption'; // Select images inside figcation to support theme animation
var noGallery = false; // image separated from gallery
var plugin_url = exopite_lightbox35_vars.plugin_url; // Get plugin url for download function
// no automatic gallery, open all images separately
var singleImageOnly = (exopite_lightbox35_vars.single_image_only == 1) ? true : false;
var hideCaption = (exopite_lightbox35_vars.hide_caption == 1) ? true : false;
var hideThumbnails = (exopite_lightbox35_vars.hide_thumbnails == 1) ? true : false;
var hideOpenInNewWindow = (exopite_lightbox35_vars.hide_open_in_new_window == 1) ? true : false;
var hideDownload = (exopite_lightbox35_vars.hide_download == 1) ? true : false;
var isVisible = false;
var lang_download = exopite_lightbox35_vars.lang_download;
var lang_openInNewWindow = exopite_lightbox35_vars.lang_openInNewWindow;
var animation = exopite_lightbox35_vars.animation; // slide, fade
var captionOn = {};
    captionOn["div"] = true;
    captionOn["title"] = true;

if (singleImageOnly) noGallery = true;

var galleryMode = ( exopite_lightbox35_vars.gallery_mode == 1 ) ? true : false;
var galleryModeClass = exopite_lightbox35_vars.gallery_mode_container;

onLoad();

function isImage( $item ) {
    if ( $item.is("img") || $item.is("figcaption") ) {
        var $href =  $item.closest('a').attr('href');
        if ( isImageExt( $href ) ) {
            return true;
        }
    }
}

function selectedIndex( that, $selectedItems ) {
    if ( isImage( $( that ) ) ) {
        return $selectedItems.index( that );
    }
}

function itemsSize( $selectedItems ) {
    var i = 0;
    $selectedItems.each(function(index, el) {
        if ( isImage( $( el ) ) ) i++;
    });
    return i;
}

function onLoad() {
    // Add a cover to the clickable elements, so like youtube opening in click insted of starting
    $(selector).find(insideElement).each(function() {
        $(this).append('<div class="cover"></div>');
    });
}

function createOrShowLightbox35( that ) {

    if ( galleryMode ) {
        insideElement = '.' + galleryModeClass;
    }

    isVisible = true;

    // Exclude item if element (image or element) or parent link has "lightbox35-no-gallery" class
    if ($(that).closest('a').hasClass('lightbox35-no-gallery') || $(that).hasClass('lightbox35-no-gallery') || ( galleryMode && ! $(that).hasClass( galleryModeClass ) ) ) {
        // Remove lighbox if exist, if user clicked on a no-gallery item
        if ( $('#lightbox35').length > 0) $('#lightbox35').remove();
        if (!singleImageOnly) noGallery = true;
    } else {
        if (!singleImageOnly) noGallery = false;
    }

    var $selectedItems = $( selector ).find( insideElement ).not( '.lightbox35-no-gallery' ).filter(function(index) {
        return isImage( $( this ) );
    });

    // determine the index of clicked trigger
    var slideNum = selectedIndex(that, $selectedItems);

    size = itemsSize( $selectedItems );

    // need to check on every click, we may have mixed gallery and no gallery item on the page
    hideThumbnails = ( noGallery || size < 2 || singleImageOnly ) ? true : false;

    /**
     * React on DOM change. If lightbox already exist, check if slide is loaded.
     * If not, reload all.
     */
    if ($('#lightbox35').length > 0) {
        var slidesClicked = slideNum + 1;
        var slidesSum = $('#lightbox35 .thumbnail').length;
        if (slidesClicked > slidesSum) {
            $('#lightbox35').remove();
        }

        if ($(that).closest('a').attr('href') != $('#lightbox35 .slide:eq(' + (slideNum) + ')').find('img').attr('src')) {
            $('#lightbox35').remove();
        }
    }

    // find out if #lightbox exists
    if ($('#lightbox35').length > 0) {
        // #lightbox exists
        $('#lightbox35').fadeIn(300);

    } else {
        // #lightbox does not exist - create and insert (runs 1st time only on automatic gallery, on single run on every click)
        // create HTML markup for lightbox window
        var downloadOprions = (hideOpenInNewWindow && hideDownload) ? '' : displayDownloadOptions();
        var lighbox_nav = (noGallery || size < 2) ? '' : '<span class="nav-left">&#10094;</span><span class="nav-right">&#10095;</span>';
        var lightbox = '<div id="lightbox35" ><div class="position"></div>' + lighbox_nav + downloadOprions + '<div class="thumbnails"></div></div>';

        //insert lightbox HTML into the page
        $('body').append(lightbox);

        // Add a div frame, so I can put anything inside (navigation, download, etc...), not only images
        var frame_begin = '<div class="slide" style="display:none;">';
        var frame_middle = '<div class="slide-frame"><a class="close-thik"></a>';
        var frame_end = '</div></div>';

        // add item to #lightbox35 (image or element)
        function addSlide(item, index) {
            // If element is an image
            if ($(item).is("img")) {
                var $href = $(item).closest('a').attr('href');
                var attrTitle = $(item).attr('title');
                var attrAlt = $(item).attr('alt');
                var caption = (hideCaption) ? '' : getCaption(item);
                var lightBoxSrc = '';

                // Add image to the lightbox
                if ( ! isImageExt( $href ) ) {
                    lightBoxSrc = $(item).attr('src');
                } else {
                    lightBoxSrc = $href;
                }

                // orig $href;
                $('#lightbox35').append(frame_begin + frame_middle + '<img src="' + lightBoxSrc + '">' + caption + frame_end);

                // Add thumbnail to lightbox thumbnail
                if(!hideThumbnails) {
                    $('#lightbox35 .thumbnails').append('<div class="thumbnail" style="background-image: url('+lightBoxSrc+')"></div>');
                }
            } else {
                // If element is not an image (such as div, iframe, a, etc...)
                var $content = '<div class="inner-div">' + $(item).html() + '</div>';
                $('#lightbox35').append(frame_begin + frame_middle + $content +  frame_end);

                // Set item bg color, otherweise it is transparent
                var elementBackgroundColor = $(item).css('background-color');
                if (elementBackgroundColor==='rgba(0, 0, 0, 0)' || elementBackgroundColor==='transparent') elementBackgroundColor = '#fff';
                $('#lightbox35 .inner-div').css('background-color', elementBackgroundColor);

                if(!hideThumbnails) {
                    $('#lightbox35 .thumbnails').append('<div class="thumbnail thumbnail-div">' + (index + 1) + '</div>');
                }
            }

            // Set bottom padding, if thumbnail is turned off
            if( hideThumbnails ) {
                $('#lightbox35 .slide').css('padding-bottom', '22px');
            }
        }

        // Fill lightbox with elements, content or images
        if (noGallery) {
            // If no gallery, then only selected current one
            addSlide(that, 0);
        } else {
            $(selector).find(insideElement).not('.lightbox35-no-gallery').each(function(index) {
                if (! $(this).closest('a').hasClass('lightbox35-no-gallery') || $(this).hasClass('lightbox35-no-gallery')) {
                    if ( isImage( $(this) ) ) addSlide(this, index);
                }
            });
        }

        // Set clicked slide to current
        if (size == 1) {
            current = 0;
        } else {
            current = slideNum;
        }

    }
    // Select current (clicked) slide
    selectSlide(slideNum);
}

/*
 * HELPER FUNCTIONS
 */
function getCaption(item) {
    var caption = '';
    // Get ".lightbox35-lightbox-caption" if exist
    var htmlCaption = $(item).closest("a").find('div.lightbox35-lightbox-caption').html();
    // For some browsers, 'attr' is undefined; for others, 'attr' is false. Check for both.
    if (typeof htmlCaption !== typeof undefined && htmlCaption !== false && htmlCaption !== '' && captionOn["div"]) {
        // Because nested link are invalid, please place your link inside caption div like:
        // [url="link" more=attribute]name of the link[/url]
        var regex = /\[url="((?:ftp|https?):\/\/.*?)"(.*?)\](.*?)\[\/url\]/i;
        // add div caption and replace link
        caption = '<div class="' + captionStyle + '">' + htmlCaption.replace(regex, '<a href="$1"$2>$3</a>') + '</div>';
    } else if (typeof attrTitle !== typeof undefined && attrTitle !== false && attrTitle !== '' && captionOn["title"]) {
        // if no div caption then choose image title
        caption = '<div class="' + captionStyle + '">' + $(item).attr('title') + '</div>';
    };
    return caption;
}

function displayDownloadOptions() {
    var downloadOptions =  '<div class="control-row"><div class="slide-controls">';
    // Add link to "open image plain in new tab"
    if(!hideOpenInNewWindow) {
        downloadOptions += '<span class="lightbox35-open"><i class="fa fa-external-link-square" aria-hidden="true"></i>' + lang_openInNewWindow + '</span>'; //open plain image in new tab
    }
    // Add link to "download image"
    if(!hideDownload) {
        // Open plain image in new tab for modern browsers, but not working on safari
        // downloadOptions += '<a href="' + $href + '" download>download</a>';

        // Open plain image in new tab, working on safari, required an extra php file
        downloadOptions += '<span class="lightbox35-download"><i class="fa fa-download" aria-hidden="true"></i>' + lang_download + '</span>';
    }
    downloadOptions += '</div></div>';
    return downloadOptions;
}

function selectSlide(slideNum) {
    // Hide previous slide only, if it is not single slide
    if (!noGallery) {
        // Hide previous slide.
        $('#lightbox35 .slide').hide();
        current = slideNum;
    }

    // Show current slide.
    loadSlide();

    // Adding swipe event to dynamically loaded content with jquery
    // Source: http://stackoverflow.com/questions/17267030/adding-swipe-event-to-dynamically-loaded-content-with-jquery
    addSwipeTo('.slide-frame');
}

function loadSlide() {
    var $slide = $('#lightbox35 .slide:eq(' + current + ')');

    if($('#lightbox35 .slide:eq(' + current + ') .inner-div').length ) {
        positionElement();
    } else {
        positionImage();
    };

    if (!hideThumbnails) calcuateThumbnailPosition();

    // Display current slide position on bottom of the page
    if (!noGallery && size > 1) $('#lightbox35 .position').text((current + 1) + ' / ' + size);
}

function isImageExt(url) {
    // Check image end for images, async image check has a lot of problem and waiting time.
    // Source: http://stackoverflow.com/questions/9714525/javascript-image-url-verify
    return(url.match(/\.(jpeg|jpg|gif|png)$/i) != null);
}

function calcuateThumbnailPosition() {
    // Remove "current" class.
    $('#lightbox35 .thumbnail').removeClass('current');
    // Get current thumbnail
    var $currentThumbnail = $('#lightbox35 .thumbnail:eq(' + current + ')');
    // Get left offset (thumbnail and thumbnail container)
    var thumbnailLeft = $currentThumbnail.offset().left;
    var thumbnailsLeft = $('#lightbox35 .thumbnails').offset().left;
    // Set new left positiob to thumbnail container
    var marginLeft = thumbnailsLeft-thumbnailLeft;
    $('#lightbox35 .thumbnails').animate({"margin-left":marginLeft-25},300);
    // Mark current thumbnail as "current"
    $currentThumbnail.addClass('current');
}

function calculateSlidePosition(pos, size) {
    if (pos < 0) {
        pos = size - 1;
    } else if (pos > size - 1) {
        pos = 0;
    }
    return pos;
}

function calculateTopPosition($slide, isImg) {
    var top_position = 0;
    // Add admin bar height if exist
    if ($('#wpadminbar').length) {
        top_position += $('#wpadminbar').height();
    }
    if (isImg=='img') {
        $('#lightbox35 .control-row').show();
        // Add image "control" row height (row for download and open in new window) if exist
        if(!hideOpenInNewWindow || !hideDownload) {
            $('#lightbox35 .control-row').css('top', top_position);
            top_position += $('#lightbox35 .control-row').height();
        }
    } else {
        $('#lightbox35 .control-row').hide();
    }

    $slide.css('padding-top', (top_position + 10) + 'px');
    $('#lightbox35 .slide:eq(' + current + ')').show();
}

function positionElement() {
    var innerDiv = $('#lightbox35 .slide:eq(' + current + ') .inner-div');
    var $slide = $('#lightbox35 .slide:eq(' + current + ')');
    var $frame = $('#lightbox35 .slide:eq(' + current + ') .slide-frame');

    calculateTopPosition($slide, 'nonimg');
    // Add max-height to positioning element in center with scrollbar, if content height is bigger then viewport
    $('#lightbox35 .slide:eq(' + current + ') .inner-div').css('max-height', ($slide.height() - 50) + 'px');

    if (innerDiv.height() < $frame.height()) {
        // Calculte position
        var frameLeftPos = ($slide.width() - $($frame).outerWidth())/2;
        var frameRightPos = ($slide.height() - $($frame).outerHeight())/2;
        // Move slide-frame to center/middle
        $($frame).css({ left: frameLeftPos, top: frameRightPos });
    }
}

function positionImage() {
    var img = new Image();
    img.src = $('#lightbox35 .slide:eq(' + current + ') img').attr("src");

    // Get image original size
    var width = img.naturalWidth;
    var height = img.naturalHeight;

    if (width < 1 || height < 1) {
        // Sometimes after click on download or open in new tab, chrome return img size 0
        // In that case, we will need to wait until image is loaded again
        // Do no do this automatically, because it is slowing done first image open
        $(img).on('load',function(){
            width = img.naturalWidth;
            height = img.naturalHeight;
            calculateImagePosition(img, width, height);
        });
    } else {
        calculateImagePosition(img, width, height);
    }
}

function calculateImagePosition(img, width, height) {
    var $slide = $('#lightbox35 .slide:eq(' + current + ')');
    var $frame = $('#lightbox35 .slide:eq(' + current + ') .slide-frame');

    calculateTopPosition($slide, 'img');

    var navHeight = $('#lightbox35 .nav-arrow.nav-arrow-left').height();
    var slideHeight = $slide.height() - navHeight;
    var maxWidth = $slide.width();
    var maxHeight = slideHeight;

    if (width < maxWidth && height < maxHeight) {
        // Image smaller then slide-frame, no need to resize
        maxWidth = width;
        maxHeight = height;
    } else {
        // Make sure image fit in slide-frame
        // Source: http://www.webdeveloper.com/forum/showthread.php?98502-How-to-get-image-size-using-JavaScript&p=951590#post951590
        if ( width >= height ) {
            // landscape
            var tmpy = height*maxWidth/width;
            if ( tmpy <= maxHeight ) {
                maxHeight = tmpy;
            } else {
                maxWidth = width*maxHeight/height;
            }
        } else {
            // portrait
            tmpx = width*maxHeight/height;
            if ( tmpx <= maxWidth ) {
                maxWidth = tmpx;
            } else {
                maxHeight = height*maxWidth/width;
            }
        }
    }

    // Resize frame to resized image size
    $($frame).css({ width: maxWidth, height: maxHeight });
    // Calculte position
    var frameLeftPos = ($slide.width() - $($frame).outerWidth())/2;
    var frameRightPos = (slideHeight - $($frame).outerHeight())/2;
    // Move slide-frame to middle center
    $($frame).css({ left: frameLeftPos, top: frameRightPos });
    //$('#lightbox35 .slide:eq(' + current + ')').fadeIn();
    $('#lightbox35 .slide:eq(' + current + ')').fadeIn();
}

function changeEvent(slide) {
    if (($('#lightbox35 .slide-frame').length < 1) || noGallery || size < 2 ) return;
    var next;
    var endPosition = -100;
    //var endPosition = -($('#lightbox35').width() / 2);
    var duration = 150;

    // Determinate to call next, previous item or slide index
    if (slide == 'next') {
        next = calculateSlidePosition(current + 1, size);
    } else if (slide == 'prev') {
        next = calculateSlidePosition(current - 1, size);
        endPosition = endPosition - (endPosition * 2);
    } else {
        // This is a slide number
        next = slide;
        if ( current > next ) {
            endPosition = endPosition - (endPosition * 2);
        }
    };

    // Animation
    if ( animation === 'fade' ) {
        // FadeOut curent slide, FadeIn next/prev slide
        $('#lightbox35 .slide:eq(' + current + ')').fadeOut();
        $('#lightbox35 .slide:eq(' + next + ')').fadeIn();
        current = next;
        loadSlide();
    } else {
        var startPosition = endPosition - (endPosition * 2);
        $('#lightbox35 .slide:eq(' + current + ')').stop().animate({
            opacity: 'hide', // animate fadeOut
            left: endPosition
        }, duration, function() {
            $(this).css({'left':'0'});
            $('#lightbox35 .slide:eq(' + next + ')').css({'left':startPosition + 'px'});
            $('#lightbox35 .slide:eq(' + next + ')').animate({
                opacity: 'show', // animate fadeOut
                left: 0
            }, duration);
            current = next;
            loadSlide();
        });
    }
}

function changeCursor(e, element) {
    // If it is a single image, then show only default cursor
    if(noGallery || size < 2) {
        if( ! $('#lightbox35 .slide-frame').hasClass('cursor_default') ) $('#lightbox35 .slide-frame').addClass('cursor_default');
        return;
    }
    // Change cursor, depends on which side is the mouse of the image
    // Source: http://stackoverflow.com/questions/10052119/jquery-detect-hover-over-left-or-right-of-a-single-div
    if ((e.pageX - element.offset().left) < element.width() / 2) {
        $('#lightbox35 .slide-frame').addClass('cursor_left');
        $('#lightbox35 .slide-frame').removeClass('cursor_right');
    } else if ((e.pageX - element.offset().left) > element.width() / 2) {
        $('#lightbox35 .slide-frame').addClass('cursor_right');
        $('#lightbox35 .slide-frame').removeClass('cursor_left');
    } else {
        // If not over the image or element, then display close cursor
        $('#lightbox35 .slide-frame').removeClass('cursor_right');
        $('#lightbox35 .slide-frame').removeClass('cursor_left');
    }
}

function closeLightbox() {
    if (noGallery) {
        // If only one image, then remove lightbox
        $('#lightbox35').remove();
    } else {
        // otherweise just hide (save CPU time for next time)
        $('#lightbox35').hide();
        isVisible = false;
    }
}

/*
 * CLICK EVENTS
 */

$(selector).find(insideElement).on('click', function(e) {

    if ( ! isImage( $(this) ) ) return;

    // prevent default click event
    e.preventDefault();

    createOrShowLightbox35( this );


});

$(selector).on('click', insideElementFigcation, function(e) {

    if ( isImage( $(this).prev('img') ) ) {
        $img = $(this).prev('img');
    } else if ( isImage( $(this).parents('a').find('img') ) ) {
        $img = $(this).parents('a').find('img');
    } else {
        return;
    }

    e.preventDefault();

    createOrShowLightbox35( $img );

});

//Using .on() instead of .live(). more modern, and fixes event bubbling issues
$(document.body).on('click', '#lightbox35, #lightbox35 .close-thik', function() {
    // Click anywhere on the page or on the close button to get rid of lightbox window
    closeLightbox();
});

$('body').on('click', '#lightbox35 .slide-controls, #lightbox35 .slide-frame', function(e) {
    if ($('#lightbox35').length < 1) return;
    // Need this to prevent closing lightbox on control click like download or open in new tab or
    // tap or swipe on slideshow item (image or element)
    e.stopPropagation();
});

$('body').on('click', '#lightbox35 .nav-right, #lightbox35 .nav-left', function(e) {
    e.stopPropagation();
    if ($(this).hasClass('nav-left')) {
        changeEvent('prev');
    } else {
        changeEvent('next');
    }
});

$('body').on('click', '#lightbox35 .thumbnail', function(e) {
    if ($('#lightbox35').length < 1) return;
    // Need this to prevent closing lightbox on control click like download or open in new tab
    e.stopPropagation();
    // Get clicked thumbnail index
    var next = $('.thumbnails').find('.thumbnail').index(this);
    // If clicking on the same/current thumbnail, ignore click
    if (current == next) return;
    // Remove "current" class on every thumbnail
    $('#lightbox35 .thumbnail').removeClass('current')
    // and add it to the current one
    $(this).addClass('current');
    changeEvent(next);
});

$('body').on('click', '#lightbox35 .lightbox35-open, #lightbox35 .lightbox35-download', function(e) {
    e.stopPropagation();
    var link = '';
    if ($(this).hasClass('lightbox35-open')) {
        link = $('<a href="' + $('#lightbox35 .slide:eq(' + current + ') .slide-frame img').attr('src') + '">');
        link.attr('target', '_blank');
    } else {
        link = $('<a href="' + plugin_url + '/download_image.php?image=' + $('#lightbox35 .slide:eq(' + current + ') .slide-frame img').attr('src') + '">');
        link.attr('target', '_media');
    }
    window.open(link.attr('href'));
});

/*
 * OTHER EVENTS
 */

$(window).resize(function(){
    // If lightbox isn't visible, then ignore event
    if( ! isVisible ) return;
    loadSlide();
});

$("body").on('mousemove', '#lightbox35 .slide-frame', function(e) {
    if( ! isVisible ) return;
    // Change pointer
    changeCursor(e, $(this));
});

//enter_13  //esc_27 //shift_16 //ctrl_17 //alt;
$(document.documentElement).keyup(function (event) {
    if (event.keyCode == 27) {
        // ESC
        closeLightbox();
    }
    // Fire < and > keyup event only if slideshow visible or exist
    if ( ($('#lightbox35').length < 1) || noGallery || !isVisible ) return;

    if (event.keyCode == 37 ) {
        // <
        changeEvent('prev');
    } else if (event.keyCode == 39) {
        // >
        changeEvent('next');
    }
});

var noScroll = false;
$("body").on('mouseenter', '#lightbox35 .inner-div', function() {
    // Turn off mouse wheel on inner-div, if scrollbar is peresent
    // in that case, use mouse wheel to scroll insed of navigate
    if ( $('#lightbox35 .slide:eq(' + current + ') .inner-div').prop('scrollHeight') > $('#lightbox35 .slide:eq(' + current + ') .slide-frame').height() ) {
        noScroll = true;
    }
}).on('mouseleave','#lightbox35 .inner-div', function() {
    noScroll = false;
});

$(document.documentElement).on( 'DOMMouseScroll mousewheel', function ( event ) {
    // Fire mousewheel event only if slideshow visible or exist
    if ($('#lightbox35').length < 1 || noScroll || !isVisible) return;

    // Prevent scrolling page behind lightbox if only one image
    if ( noGallery ) return false;

    event.preventDefault();
    // Source: http://stackoverflow.com/questions/7154967/how-to-detect-scroll-direction
    if( event.originalEvent.detail > 0 || event.originalEvent.wheelDelta < 0 ) { //alternative options for wheelData: wheelDeltaX & wheelDeltaY
        //scroll down
        changeEvent('next');
    } else {
        //scroll up
        changeEvent('prev');
    }

    //prevent page fom scrolling
    return false;
});

var addSwipeTo = function(selector) {
    if( ! isVisible ) return;
    $(selector).swipe("destroy");
    $(selector).swipe({
        tap:function(event, target) {
            // React only on left mouse click
            // Source: http://stackoverflow.com/questions/1206203/how-to-distinguish-between-left-and-right-mouse-click-with-jquery
            if (event.which == 1) {
                // Detect side click for navigation back and forth
                // Source: http://stackoverflow.com/questions/9160660/which-side-of-cell-was-clicked
                var $this = $(this);
                if (event.pageX - $this.offset().left > $this.width() / 2) {
                        // Clicked on the right side.
                        changeEvent('next');
                } else {
                        // Clicked on the left side.
                        changeEvent('prev');
                }
            }
        },
        swipeLeft:function(event, direction, distance, duration, fingerCount)
        {
            changeEvent('next');
        },
        swipeRight:function(event, direction, distance, duration, fingerCount)
        {
            changeEvent('prev');
        },
        threshold:10,
        // set your swipe threshold above

        excludedElements:"button, input, select, textarea",
        // notice span isn't in the above list
    });
};
// $( 'body' ).bind('DOMNodeInserted DOMSubtreeModified DOMNodeRemoved', function(event) {
//     $('#lightbox35').remove();
// });
}); // jQuery ready function ($)



