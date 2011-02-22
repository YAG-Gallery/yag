
var	ajaxRequestAlbumID = 'ajaxID=txyagM1::getAlbumList';

jQuery.noConflict();

jQuery(function() {
	jQuery( "#albumGallerySelector" ).selectable({
	   selected: function(event, ui) {
			var galleryUid = jQuery(ui.selected).attr('galleryUid');
			if(galleryUid > 0) {
				jQuery.ajax({
			            url: 'ajax.php',
			            data: ajaxRequestAlbumID, 
			            success: function(response) {
			                alert(response + ' XX');
			            }
			        });
			} else {
				alert(galleryUid);
			}
		}
	});
});
