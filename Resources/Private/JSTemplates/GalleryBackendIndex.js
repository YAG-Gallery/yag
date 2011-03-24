var setalbumthumb_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=setAlbumAsGalleryThumb';
var hidealbum_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=hideAlbum';
var unhidealbum_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=unhideAlbum';
var del_album_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=deleteAlbum';
var sorting_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=updateAlbumSorting' + '&###pluginNamespace###[gallery]=###galleryUid###';

// Setting up delete dialog
$(document).ready(function() {
    var $deleteDialog = $('<div></div>')
        .dialog({
            autoOpen: false,
            modal: true,
            title: 'Really delete?'
        });

    $('a.album-linkbar-delete').click(function() {
        var albumUid = $(this).attr("albumUid");
        var album = $('tr#albumUid-' + albumUid);
        $deleteDialog.html('Really delete this album?');
        $deleteDialog.dialog({ buttons: {
                "Delete album": function() {
                    $.ajax({
                        url: del_album_url,
                        data: "###pluginNamespace###[album]="+albumUid, 
                        success: function(feedback) {
                            if(feedback=='OK') {
                                $deleteDialog.dialog('close');
                                // ###translate###
                                $("#messages").html("<div id='inner_msg' class='typo3-message message-ok'>Album has been deleted!</div>");
                                album.fadeOut();
                            }else{
                                // ###translate###
                                $("#messages").html("<div id='inner_msg' class='typo3-message message-error'>"+feedback+"</div>");
                                $( this ).dialog( "close" );
                            }
                            setTimeout(function(){$('#inner_msg').fadeOut();}, 5000);
                        }
                    });
                },
                'Cancel': function() {
                    $( this ).dialog( "close" );
                }
            }});
        $deleteDialog.dialog('open');
        // prevent the default action, e.g., following a link
        return false;
    });
});

$(function() {

    /*
    For more information, see the post: http://devblog.foliotek.com/2009/07/23/make-table-rows-sortable-using-jquery-ui-sortable/
    */
    // Helper methods for preserving width of tr if row is dragged&dropped
    var fixHelper = function(e, ui) {
        ui.children().each(function() {
           $(this).width($(this).width());
        });
        return ui;
    };
    
    // Add sortable property to album rows
    $("#sortable tbody").sortable({
        helper: fixHelper,
        update : function () {
            var order = $('#sortable tbody').sortable('serialize');
            $.ajax({
                  url: sorting_url,
                  type: "POST",
                  data: order,
                  success: function(feedback){
                      if (feedback == 'OK' ) { 
                          // ###translate###
                          $("#messages").html("<div id='inner_msg' class='typo3-message message-ok'>Sorting of albums has been saved!</div>");
                      } else {
                          // ###translate###
                          $("#messages").html("<div id='inner_msg' class='typo3-message message-error'>Error while trying to save sorting of albums: " + feedback + "</div>");
                      }
                      setTimeout(function(){$('#inner_msg').fadeOut();}, 5000);
                  }
            });
        }
    }).disableSelection();

    // Handle set album as gallery thumb action
    $("a.set-as-gallery-thumb").click(function () {
        var albumUid = $(this).attr("albumUid");
        $.ajax({
            url: setalbumthumb_url,
            data: "###pluginNamespace###[album]="+albumUid, 
            success: function(feedback) {
                if(feedback=='OK') {
                    // Mark album as thumb album
                    $("tr.tx-yag-album-index-album").removeClass('tx-yag-album-index-album');
                    $("tr#albumUid-"+albumUid).addClass('tx-yag-album-index-album');
                    // ###translate###
                    $("#messages").html("<div id='inner_msg' class='typo3-message message-ok'>Album has been set as gallery thumb!</div>");
                }else{
                    // ###translate###
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
	                    // ###translate###
	                    $("#messages").html("<div id='inner_msg' class='typo3-message message-ok'>Album is set 'hidden' now!</div>");
	                    hideLink.replaceWith('<a id="unhide-album-'+albumUid+'" class="unhide-album" albumUid="'+albumUid+'"><span class="t3-icon t3-icon-actions t3-icon-actions-edit t3-icon-edit-unhide">&nbsp;</span></a>');
	                    transparencyDiv.addClass('tx-yag-transparency-half');
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
	                    // ###translate###
	                    $("#messages").html("<div id='inner_msg' class='typo3-message message-ok'>Album is set 'visible' now!</div>");
	                    unhideLink.replaceWith('<a id="hide-album-'+albumUid+'" class="hide-album" albumUid="'+albumUid+'"><span class="t3-icon t3-icon-actions t3-icon-actions-edit t3-icon-edit-hide">&nbsp;</span></a>');
	                    transparencyDiv.removeClass('tx-yag-transparency-half');
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