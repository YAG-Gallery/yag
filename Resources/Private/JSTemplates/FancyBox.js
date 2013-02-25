var thisHash = window.location.hash;

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


