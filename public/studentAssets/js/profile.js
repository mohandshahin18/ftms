
"use strict";

/**
 * @class KApp
 */

var KTApp = function() {
    // /** @type {object} colors State colors **/
    // var colors = {};



}();




// plugin setup
var KTAvatar = function(elementId, options) {
    // Main object
    var the = this;
    var init = false;

    // Get element object
    var element = KTUtil.get(elementId);
    var body = KTUtil.get('body');

    if (!element) {
        return;
    }

    // Default options
    var defaultOptions = {};

    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////

    var Plugin = {
        /**
         * Construct
         */

        construct: function(options) {
            if (KTUtil.data(element).has('avatar')) {
                the = KTUtil.data(element).get('avatar');
            } else {
                // reset menu
                Plugin.init(options);

                // build menu
                Plugin.build();

                // KTUtil.data(element).set('avatar', the);
            }

            return the;
        },

        /**
         * Init avatar
         */
        init: function(options) {
            the.element = element;
            the.events = [];

            the.input = KTUtil.find(element, 'input[type="file"]');
            the.holder = KTUtil.find(element, '.kt-avatar__holder');
            the.cancel = KTUtil.find(element, '.kt-avatar__cancel');
            the.src = KTUtil.css(the.holder, 'backgroundImage');

            // merge default and user defined options
            the.options = KTUtil.deepExtend({}, defaultOptions, options);
        },

        /**
         * Build Form Wizard
         */
        build: function() {
            // Handle avatar change
            KTUtil.addEvent(the.input, 'change', function(e) {
                e.preventDefault();

                if (the.input && the.input.files && the.input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        KTUtil.css(the.holder, 'background-image', 'url(' + e.target
                            .result + ')');
                    }
                    reader.readAsDataURL(the.input.files[0]);

                    // KTUtil.addClass(the.element, 'kt-avatar--changed');
                }
            });


        },


    };




    // Construct plugin
    Plugin.construct.apply(the, [options]);

};





var KTUtil = function() {
    var resizeHandlers = [];





    return {




        // Deep extend:  $.extend(true, {}, objA, objB);
        deepExtend: function(out) {
            out = out || {};

            for (var i = 1; i < arguments.length; i++) {
                var obj = arguments[i];

                if (!obj)
                    continue;

                for (var key in obj) {
                    if (obj.hasOwnProperty(key)) {
                        if (typeof obj[key] === 'object')
                            out[key] = KTUtil.deepExtend(out[key], obj[key]);
                        else
                            out[key] = obj[key];
                    }
                }
            }

            return out;
        },


        get: function(query) {
            var el;

            if (query === document) {
                return document;
            }

            if (!!(query && query.nodeType === 1)) {
                return query;
            }

            if (el = document.getElementById(query)) {
                return el;
            } else if (el = document.getElementsByTagName(query), el.length > 0) {
                return el[0];
            } else if (el = document.getElementsByClassName(query), el.length > 0) {
                return el[0];
            } else {
                return null;
            }
        },
        find: function(parent, query) {
            parent = KTUtil.get(parent);
            if (parent) {
                return parent.querySelector(query);
            }
        },


        data: function(element) {

            return {



                has: function(name) {




                },


            };
        },




        css: function(el, styleProp, value) {


            if (value !== undefined) {
                el.style[styleProp] = value;
            } else {
                var defaultView = (el.ownerDocument || document).defaultView;

            }
        },


        addEvent: function(el, type, handler, one) {
            el = KTUtil.get(el);

            if (typeof el !== 'undefined' && el !== null) {
                el.addEventListener(type, handler);
            }
        },




        ready: function(callback) {
            if (document.attachEvent ? document.readyState === "complete" : document.readyState !==
                "loading") {
                callback();
            } else {
                document.addEventListener('DOMContentLoaded', callback);
            }
        },


    }
}();



// Class definition
var KTAvatarDemo = function() {
    // Private functions
    var initDemos = function() {
        var avatar1 = new KTAvatar('kt_user_avatar_1');
        var avatar2 = new KTAvatar('kt_user_avatar_2');
        var avatar3 = new KTAvatar('kt_user_avatar_3');
        var avatar4 = new KTAvatar('kt_user_avatar_4');
    }

    return {
        // public functions
        init: function() {
            initDemos();
        }
    };
}();

KTUtil.ready(function() {
    KTAvatarDemo.init();
});
