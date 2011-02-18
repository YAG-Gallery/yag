jQuery.noConflict();

jQuery(function() {
	jQuery( "#gallerySelector" ).selectable({
	   selected: function(event, ui) {
			var galleryUid = jQuery(ui.selected).attr('galleryUid');
			if(galleryUid > 0) {
				jQuery("####elementId###").val(galleryUid);
			}
		}
	});
});