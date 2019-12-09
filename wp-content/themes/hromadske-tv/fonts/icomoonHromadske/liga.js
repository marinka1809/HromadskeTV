/* A polyfill for browsers that don't support ligatures. */
/* The script tag referring to this file must be placed before the ending body tag. */

/* To provide support for elements dynamically added, this script adds
   method 'icomoonLiga' to the window object. You can pass element references to this method.
*/
(function () {
    'use strict';
    function supportsProperty(p) {
        var prefixes = ['Webkit', 'Moz', 'O', 'ms'],
            i,
            div = document.createElement('div'),
            ret = p in div.style;
        if (!ret) {
            p = p.charAt(0).toUpperCase() + p.substr(1);
            for (i = 0; i < prefixes.length; i += 1) {
                ret = prefixes[i] + p in div.style;
                if (ret) {
                    break;
                }
            }
        }
        return ret;
    }
    var icons;
    if (!supportsProperty('fontFeatureSettings')) {
        icons = {
            'image': '&#xe910;',
            'picture': '&#xe910;',
            'images': '&#xe911;',
            'pictures': '&#xe911;',
            'camera': '&#xe912;',
            'photo': '&#xe912;',
            'headphones': '&#xe913;',
            'headset': '&#xe913;',
            'music': '&#xe915;',
            'song': '&#xe915;',
            'play': '&#xe916;',
            'video': '&#xe916;',
            'film': '&#xe917;',
            'video2': '&#xe917;',
            'video-camera': '&#xe914;',
            'video3': '&#xe914;',
            'phone': '&#xe942;',
            'telephone': '&#xe942;',
            'phone-hang-up': '&#xe943;',
            'telephone2': '&#xe943;',
            'envelop': '&#xe945;',
            'mail': '&#xe945;',
            'location2': '&#xe948;',
            'map-marker2': '&#xe948;',
            'mobile': '&#xe958;',
            'cell-phone': '&#xe958;',
            'mobile2': '&#xe959;',
            'cell-phone2': '&#xe959;',
            'circle-right': '&#xea42;',
            'right5': '&#xea42;',
            'circle-left': '&#xea44;',
            'left5': '&#xea44;',
            'mail5': '&#xea86;',
            'contact5': '&#xea86;',
            'google-plus': '&#xea8b;',
            'brand5': '&#xea8b;',
            'instagram': '&#xea92;',
            'brand12': '&#xea92;',
            'twitter': '&#xea96;',
            'brand16': '&#xea96;',
            'feed2': '&#xea9b;',
            'rss': '&#xea9b;',
            'youtube': '&#xea9d;',
            'brand21': '&#xea9d;',
            'youtube2': '&#xea9e;',
            'brand22': '&#xea9e;',
            'vimeo': '&#xeaa0;',
            'brand24': '&#xeaa0;',
            'flickr2': '&#xeaa4;',
            'brand28': '&#xeaa4;',
            'dribbble': '&#xeaa7;',
            'brand31': '&#xeaa7;',
            'behance': '&#xeaa8;',
            'brand32': '&#xeaa8;',
            'steam': '&#xeaac;',
            'brand36': '&#xeaac;',
            'github': '&#xeab0;',
            'brand40': '&#xeab0;',
            'blogger': '&#xeab7;',
            'brand47': '&#xeab7;',
            'tumblr': '&#xeab9;',
            'brand49': '&#xeab9;',
            'yahoo': '&#xeabb;',
            'brand51': '&#xeabb;',
            'skype': '&#xeac5;',
            'brand60': '&#xeac5;',
            'linkedin2': '&#xeaca;',
            'brand65': '&#xeaca;',
            'stumbleupon': '&#xeace;',
            'brand69': '&#xeace;',
            'pinterest': '&#xead1;',
            'brand72': '&#xead1;',
          '0': 0
        };
        delete icons['0'];
        window.icomoonLiga = function (els) {
            var classes,
                el,
                i,
                innerHTML,
                key;
            els = els || document.getElementsByTagName('*');
            if (!els.length) {
                els = [els];
            }
            for (i = 0; ; i += 1) {
                el = els[i];
                if (!el) {
                    break;
                }
                classes = el.className;
                if (/icon-/.test(classes)) {
                    innerHTML = el.innerHTML;
                    if (innerHTML && innerHTML.length > 1) {
                        for (key in icons) {
                            if (icons.hasOwnProperty(key)) {
                                innerHTML = innerHTML.replace(new RegExp(key, 'g'), icons[key]);
                            }
                        }
                        el.innerHTML = innerHTML;
                    }
                }
            }
        };
        window.icomoonLiga();
    }
}());
