jQuery.noConflict();

jQuery(function() {
	jQuery( "#albumGallerySelector" ).selectable({
	   selected: function(event, ui) {
			var galleryUid = jQuery(ui.selected).attr('galleryUid');
			if(galleryUid > 0) {
				jQuery('#albumAlbumSelectorBox').html('');
				loadAlbumList(galleryUid);
			} 
		}
	});
});



function loadAlbumList(galleryUid) {
	
	var	ajaxRequestAlbumID = 'ajaxID=txyagM1::getAlbumList&galleryUid=' + galleryUid + '&PID=###PID###';
	jQuery.ajax({
        url: 'ajax.php',
        data: ajaxRequestAlbumID, 
        success: function(response) {
            setAlbumList(response);
        }
    });	
}



function setAlbumList(data) {
	jQuery('#albumAlbumSelectorBox').removeClass('inactiveSelectorBox').addClass("albumAlbumSelectorBox");
	jQuery('#albumAlbumSelectorBox .inactiveInfo').remove();
	
	jQuery('#albumAlbumSelectorBox').html(data);
	
	jQuery('#albumAlbumSelectorBox ol').attr('id', 'albumAlbumSelector');	
	jQuery( "#albumAlbumSelector" ).selectable({
		   selected: function(event, ui) {
				var albumUid = jQuery(ui.selected).attr('albumUid');
				if(albumUid > 0) {
					jQuery("####elementId###").val(albumUid);
				} 
			}
		});
}