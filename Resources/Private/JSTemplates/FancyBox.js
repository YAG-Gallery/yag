$(document).ready(function() {

	/* Apply fancybox to multiple items */

	$("a.fancybox").fancybox({
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'titlePosition': 'over',
        'autoScale':	'true',
        'padding': 0,
        'overlayColor':'#000',
        'overlayOpacity':0.8,
        'titleFormat': function(title, currentArray, currentIndex, currentOpts) {
            return '<span id="fancybox-title-over">'+ (title.length ? '' + title : '') + '</span>';
        }
	});

});