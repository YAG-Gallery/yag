jQuery.noConflict();

jQuery(function() {
	jQuery( ".albumSelector" ).selectable({
	   selected: function(event, ui) {
			var albumUid = jQuery(ui.selected).attr('albumUid');
			if(albumUid > 0) {
				jQuery("####elementId###").val(albumUid);
			}
		}
	});
});


jQuery(function() {
	jQuery( "#albumAccordion" ).accordion({
		autoHeight: false,
		navigation: true
	});
});
