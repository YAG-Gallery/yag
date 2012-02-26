$(document).ready(function() {

	$("a.fancybox").fancybox({
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'titlePosition': 'over',
        'autoScale':	'true',
        'padding': 0,
        'overlayColor':'#000',
        'overlayOpacity':0.8,

        'titleFormat': function(title, currentArray, currentIndex, currentOpts) {
            return '<span id="fancybox-title-over">'+ (title.length ? '' + title : '') +  'Image ' + (currentIndex + 1) + ' of ' + currentArray.length + '</span>';
        },

        'onComplete': function() {
            $("#fancybox-title").hide();
            $("#fancybox-wrap").hover(function() {
                $("#fancybox-title").fadeIn("fast");
            }, function() {
                $("#fancybox-title").fadeOut("fast");
            });
        }
	});

});