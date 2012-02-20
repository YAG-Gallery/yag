$(document).ready(function() {

	/* Apply fancybox to multiple items */

	$("a.fancybox").fancybox({
        'transitionIn':'elastic',
        'transitionOut': 'elastic',
        'titlePosition': 'inside',
        'padding': 1,
        'titleFormat': function(title, currentArray, currentIndex, currentOpts) {
            return '<span id="fancybox-title-over">'+ (title.length ? '' + title : '') + '</span>';
        }
	});

});