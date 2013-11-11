(function($) {
    $(function() {
        var thisHash = window.location.hash;

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
                              description = $(item.el).siblings('.yag-lightbox-meta').html();
                          return description || caption;
                        }
                    }
                }, settings.lightbox));
            }
        });

        if($.fn.magnificPopup && thisHash && thisHash.substring(0, 5) == '#yag_') {
          var $item = $(thisHash);
          $item.closest('.yag-gallery').magnificPopup('open', $item.index());
        }
    });
})(jQuery);
