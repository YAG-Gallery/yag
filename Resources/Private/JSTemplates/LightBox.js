var thisHash = window.location.hash;


(function($) {
    $(function() {
        $('.yag-gallery').each(function() {
            var $self = $(this),
                settings = $self.data('yag-gallery-settings');

            // Initialize lightbox if enabled in options
            if ($.fn.magnificPopup) {
                $self.magnificPopup($.extend(true, {
                    delegate: '.yag-lightbox-link', // child items selector, by clicking on it popup will open
                    type: 'image',
                    gallery: {
                        enabled:true
                    },
                    image: {
                        verticalFit: false,
                        titleSrc: function(item) {
                            var caption = item.el.attr('title'),
                                description = '';//$(item.el).siblings('.yag-lightbox-meta').html().trim();
                            return description || caption;
                        }
                    }
                }, settings.lightbox));
            }
        })
    })
})(jQuery);


/*
$(document).ready(function() {

    var fancyBoxParam = {
            ###yagSettings###,

        'titleFormat': function(title, currentArray, currentIndex, currentOpts) {
            return '<span id="fancybox-title-over">'+ (title.length ? '' + title : '') +  '###LLL:tx_yag_general.image### '
                + (currentIndex + 1) + ' ###LLL:pager.of### ' + currentArray.length + '</span>';
        },

        'onComplete': function() {
            $("#fancybox-title").hide();
            $("#fancybox-wrap").hover(function() {
                $("#fancybox-title").fadeIn("fast");
            }, function() {
                $("#fancybox-title").fadeOut("fast");
            });
        }
    };

    if(thisHash && thisHash.substring(0, 5) == '#yag_') {
        $(thisHash).fancybox(fancyBoxParam).trigger('click');
    }

	$("a.fancybox").fancybox(fancyBoxParam);

});

*/