// ATTENTION: There are two lines added in file tree script to enable
// submitting of selected directories to server

var serverside_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=getSubDirs';

// TODO remove this to own javascript template for jm_gallery import
var load_category_and_album_url = '###importBaseUrl###' + '&###pluginNamespace###[action]=getCategoriesAndAlbums';
var import_categories_url = '###importBaseUrl###' + '&###pluginNamespace###[action]=importCategories';
var import_album_url = '###importBaseUrl###' + '&###pluginNamespace###[action]=importAlbum';
var jmGalleryData; // we need this var global, as it's later referenced by the ajax calls.

$(document).ready( function() {
    $('#filetree').fileTree({ 
        root: 'fileadmin/',
        script: serverside_url,
        multiFolder: false,
        loadMessage: 'Subdirectories are loaded' 
    }, function(file) {
        alert('###errorMessageOnPickingFiles###');
    });
    
    // We don't want to have the import button active until we have downloaded gallery data
    //$("#import_jm_gallery_button").hide();
    
    // TODO remove this to own javascript template for jm_gallery import
    $("#category-and-album-loader").click(function () {
        $("#categoryAndAlbumList").html('jm_gallery data is being loaded!');
        $.ajax({
            url: load_category_and_album_url,
            success: function(data) {
                jmGalleryData = eval(data);
                var galleryDataList = '<ul style="list-style: disc; padding: 10px">';
                jmGalleryData.forEach(function(category) {
                    galleryDataList += '<li id="jm_category_uid-' + category['categoryUid'] + '"><b>' + category['categoryUid'] + ' - ' + category['categoryName'] + '</b> (' + category['albumCount'] + ' albums)' + '<ul style="list-style: disc; padding: 10px">';
                    category['albums'].forEach(function(album) {
                        galleryDataList += '<li style="color: black" id="jm_album_uid-' + album['albumUid'] + '">' + album['albumUid'] + ' - ' + album['albumName'] + ' (' + album['imageCount'] + ' images)' + '</li>';
                    });
                    galleryDataList += '</ul></li>';
                });
                galleryDataList += '</ul>';
                $("#categoryAndAlbumList").html(galleryDataList);
                
                // Now we can have import button active again
                //$("#import_jm_gallery_button").show();
            }
        });
    });
    
    $("#import_jm_gallery_button").click(function () {
        $.ajax({
            url: import_categories_url,
            success: function(feedback){
                if (feedback == 'OK' ) {
	                jmGalleryData.forEach(function(category) {
	                    // We set colors of category li's to green --> imported
	                    $("#jm_category_uid-" + category['categoryUid']).css('color', 'green');
	                    
	                    // We import each album individually triggered by an ajax call
	                    category['albums'].forEach(function(album) {
		                    
		                    $.ajax({
		                        url: import_album_url,
		                        data: "###pluginNamespace###[jmAlbumUid]=" + album['albumUid'],
		                        success: function(feedback) {
		                            if (feedback == 'OK') {
		                                $("#jm_album_uid-" + album['albumUid']).css('color', 'green');  
		                            } else {
		                                alert('An error occured when trying to import album ' + album['albumUid']);
		                            }
		                        }
		                    });
	                    });
	                });
	            } else {
	                // ###translate###
                    $("#messages").html("<div id='inner_msg' class='typo3-message message-error'>Error while importing categories: " + feedback + "</div>");
	            }
            },
            error : function() {
                alert('Error while trying to import jm_gallery categories!');
            }
        });
    });
    
});