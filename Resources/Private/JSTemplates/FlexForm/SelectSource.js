jQuery.noConflict();

jQuery(document).ready(function($) {
	startUp();
});


function startUp() {
	var galleryUid = jQuery("#selectedGalleryUid").val();
	selectGallery(galleryUid);
	addRemoveSelectionEntry('Gallery');
}


function addRemoveSelectionEntry(type) {
	jQuery("#image"+type+"Selector").prepend('<li class="ui-state-default ui-selectee" style="margin-bottom:2px;" galleryuid="0" id="'+type+'Unselector"></li>');
	//jQuery("#"+type+"Unselector").html('<div class="ui-selectee" style="float: left; padding-right: 5px;">');
	jQuery("#"+type+"Unselector").html('<div class="ui-selectee" style="height:20px;><a title="Remove selection"><span class="t3-icon t3-icon-actions t3-icon-actions-edit t3-icon-edit-delete">&nbsp;</span></a><span>Test</span></div>');
	
}

jQuery(function() {
	jQuery( "#imageGallerySelector" ).selectable({
	   selected: function(event, ui) {
			var galleryUid = jQuery(ui.selected).attr('galleryUid');
			
			jQuery("#selectedAlbumUid").val(0);
			jQuery("#selectedItemUid").val(0);
			selectGallery(galleryUid);
		}
	});
});



function selectGallery(galleryUid) {
	
	jQuery('#imageAlbumSelectorBox').addClass("selectorBoxBusy").html('');
	jQuery('#imageImageSelectorBox').addClass("inactiveSelectorBox").html('');
	
	if(galleryUid > 0) {
		jQuery('li[galleryuid="'+galleryUid+'"]').addClass("ui-selected");
		
		jQuery("#selectedGalleryUid").val(galleryUid);
		
		loadAlbumList(galleryUid);
	}
}


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
	jQuery('#imageAlbumSelectorBox').removeClass('inactiveSelectorBox').removeClass("selectorBoxBusy").addClass("itemSelectorBox");
	jQuery('#imageAlbumSelectorBox .inactiveInfo').remove();
	
	jQuery('#imageAlbumSelectorBox').html(data);
	
	jQuery('#imageAlbumSelectorBox ol').attr('id', 'imageAlbumSelector');	
	jQuery( "#imageAlbumSelector" ).selectable({
	   selected: function(event, ui) {
			jQuery("#selectedItemUid").val(0);
			var albumUid = jQuery(ui.selected).attr('albumUid');
			selectAlbum(albumUid);
		}
	});
	
	var albumUid = jQuery("#selectedAlbumUid").val();
	selectAlbum(albumUid);
}


function selectAlbum(albumUid) {
	if(albumUid > 0) {
		jQuery('#imageImageSelectorBox').addClass("selectorBoxBusy").html('');
		jQuery("#selectedAlbumUid").val(albumUid);
		jQuery('li[albumuid="'+albumUid+'"]').addClass("ui-selected");
		loadImageList(albumUid);
	}
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
			selectImage(imageUid)
		}
	});
	
	var imageUid = jQuery("#selectedItemUid").val();
	selectImage(imageUid);
}


function selectImage(imageUid) {
	if(imageUid > 0) {
		jQuery("#selectedItemUid").val(imageUid);
		jQuery('li[imageuid="'+imageUid+'"]').addClass("ui-selected");
	}
}