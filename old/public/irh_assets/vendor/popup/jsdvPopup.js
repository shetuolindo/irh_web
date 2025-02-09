(function ($) {
    var popupHtml = '<div class="popup"><img src=""><span></span><div class="close"></div></div>';

    $.jsdvPopup = function (options) {

        //default params
        options = $.extend({
            icon: 'images/icons/skype-64.png',
            text: "Hello!This is my first popup notification! Hope you'l like it!",
            timeout: 5000
        }, options);
        //create and show message
        var $elem = $(popupHtml);
        $elem.find('img').attr("src", options.icon);
        $elem.find('span').text(options.text);
        $elem.appendTo($('body'));

        show($elem);

        //click handler
        $elem.find('.close').on('click', function () {
            hide.call($(this).parent());
        });

        //setup timer
        setTimeout(function () {
            hide.call($elem);
        }, options.timeout);

        function show(elem) {
            elem.css({'bottom': -1 * elem.outerHeight(), "display": 'block'});
            elem.animate({'bottom': 10}, "fast");
        }

        function hide() {
            this.animate({'bottom': -1 * this.outerHeight()}, 'fast', 'swing', function () {
                $(this).remove();
            });
        }
    };
})(jQuery);