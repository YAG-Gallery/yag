jQuery.noConflict();

jQuery(function() {
	jQuery( "#imageGallerySelector" ).selectable({
	   selected: function(event, ui) {
			var galleryUid = jQuery(ui.selected).attr('galleryUid');
			if(galleryUid > 0) {
				jQuery('#imageAlbumSelectorBox').addClass("selectorBoxBusy").html('');
				
				loadImageAlbumList(galleryUid);
			} 
		}
	});
	
	jQuery( "#imageAlbumSelector" ).selectable({
		   selected: function(event, ui) {
				var albumUid = jQuery(ui.selected).attr('albumUid');
				if(albumUid > 0) {
					
					jQuery('#imageImageSelectorBox').addClass("selectorBoxBusy").html('');
					
					loadImageList(albumUid);
				} 
			}
		});
	
	jQuery( "#imageImageSelector" ).selectable({
		   selected: function(event, ui) {
				var imageUid = jQuery(ui.selected).attr('imageUid');
				if(imageUid > 0) {
					jQuery("####elementId###").val(imageUid);
				} 
			}
		});
});



function loadImageAlbumList(galleryUid) {
	
	var	ajaxRequestAlbumID = 'ajaxID=txyagM1::getAlbumList&galleryUid=' + galleryUid + '&PID=###PID###';
	
	jQuery.ajax({
        url: 'ajax.php',
        data: ajaxRequestAlbumID, 
        success: function(response) {
            setImageAlbumList(response);
        }
    });	
}



function setImageAlbumList(data) {
	jQuery('#imageAlbumSelectorBox').removeClass('inactiveSelectorBox').removeClass("selectorBoxBusy").addClass("itemSelectorBox");
	jQuery('#imageAlbumSelectorBox .inactiveInfo').remove();
	
	jQuery('#imageAlbumSelectorBox').html(data);
	
	jQuery('#imageAlbumSelectorBox ol').attr('id', 'imageAlbumSelector');	
	jQuery( "#imageAlbumSelector" ).selectable({
		   selected: function(event, ui) {
				var albumUid = jQuery(ui.selected).attr('albumUid');
				if(albumUid > 0) {
					jQuery('#imageImageSelectorBox').addClass("selectorBoxBusy").html('');
					loadImageList(albumUid)
				} 
			}
		});
}



function loadImageList(albumUid) {
	
	var	ajaxRequestAlbumID = 'ajaxID=txyagM1::getImageList&albumUid=' + albumUid + '&PID=###PID###';
	
	jQuery.ajax({
        url: 'ajax.php',
        data: ajaxRequestAlbumID, 
        success: function(response) {
            setImageList(response);
        }
    });	
}



function setImageList(data) {
	jQuery('#imageImageSelectorBox').removeClass('inactiveSelectorBox').removeClass("selectorBoxBusy").addClass("itemSelectorBox");
	jQuery('#imageImageSelectorBox .inactiveInfo').remove();
	
	jQuery('#imageImageSelectorBox').html(data);
	
	jQuery('#imageImageSelectorBox ol').attr('id', 'imageImageSelector');	
	jQuery( "#imageImageSelector" ).selectable({
		   selected: function(event, ui) {
				var imageUid = jQuery(ui.selected).attr('imageUid');
				if(imageUid > 0) {
					jQuery("####elementId###").val(imageUid);
				} 
			}
		});
}
