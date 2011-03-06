var setalbumthumb_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=setAlbumAsGalleryThumb';
var hidealbum_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=hideAlbum';
var unhidealbum_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=unhideAlbum';

$(function() {
    // Handle set album as gallery thumb action
    $("a.set-as-gallery-thumb").click(function () {
        var albumUid = $(this).attr("albumUid");
        $.ajax({
            url: setalbumthumb_url,
            data: "###pluginNamespace###[album]="+albumUid, 
            success: function(feedback) {
                if(feedback=='OK') {
                    $("#messages").html("<div id='inner_msg' class='typo3-message message-ok'>Album ist als Thumbnail festgelegt!</div>");
                }else{
                    $("#messages").html("<div id='inner_msg' class='typo3-message message-error'>"+feedback+"</div>");
                }
                setTimeout(function(){$('#inner_msg').fadeOut();}, 5000);
            }
        });
    });
    
    /* We need to do this the 'complicated' way, as 
     * handler for either 'hide' or 'unhide' link does not
     * work, if 'the other' link is shown.
     */
    handleHideAlbumAction();
    handleUnhideAlbumAction();

    // Handle hide album action
    function handleHideAlbumAction() {    
	    $("a.hide-album").click(function () {
	        var albumUid = $(this).attr("albumUid");
	        var hideLink = $("a#hide-album-" + albumUid); // change icon
	        var transparencyDiv = $("div#album-"+albumUid+"-transparency");  // make thumb half-transparent
	        $.ajax({
	            url: hidealbum_url,
	            data: "###pluginNamespace###[album]="+albumUid, 
	            success: function(feedback) {
	                if(feedback=='OK') {
	                    $("#messages").html("<div id='inner_msg' class='typo3-message message-ok'>Ihr Album wurde auf 'unsichtbar' gesetzt!</div>");
	                    hideLink.replaceWith('<a id="unhide-album-'+albumUid+'" class="unhide-album" albumUid="'+albumUid+'"><span class="t3-icon t3-icon-actions t3-icon-actions-edit t3-icon-edit-unhide">&nbsp;</span></a>');
	                    transparencyDiv.css('filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5;');
	                    handleUnhideAlbumAction(); // call handler for element just created
	                }else{
	                    $("#messages").html("<div id='inner_msg' class='typo3-message message-error'>"+feedback+"</div>");
	                }
	                setTimeout(function(){$('#inner_msg').fadeOut();}, 5000);
	            }
	        });
	    });
	}
	
    // Handle unhide album action
    function handleUnhideAlbumAction() {    
	    $("a.unhide-album").click(function () {
	        var albumUid = $(this).attr("albumUid");
	        var unhideLink = $("a#unhide-album-" + albumUid); // change icon
	        var transparencyDiv = $("div#album-"+albumUid+"-transparency"); // make thumb half-transparent
	        $.ajax({
	            url: unhidealbum_url,
	            data: "###pluginNamespace###[album]="+albumUid, 
	            success: function(feedback) {
	                if(feedback=='OK') {
	                    $("#messages").html("<div id='inner_msg' class='typo3-message message-ok'>Ihr Album wurde auf 'sichtbar' gesetzt!</div>");
	                    unhideLink.replaceWith('<a id="hide-album-'+albumUid+'" class="hide-album" albumUid="'+albumUid+'"><span class="t3-icon t3-icon-actions t3-icon-actions-edit t3-icon-edit-hide">&nbsp;</span></a>');
	                    transparencyDiv.css('');
	                    handleHideAlbumAction(); // call handler for element just created
	                }else{
	                    $("#messages").html("<div id='inner_msg' class='typo3-message message-error'>"+feedback+"</div>");
	                }
	                setTimeout(function(){$('#inner_msg').fadeOut();}, 5000);
	            }
	        });
	    });
    }
});