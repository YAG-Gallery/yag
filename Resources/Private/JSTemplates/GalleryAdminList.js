var del_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=deleteGallery';
var sorting_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=updateGallerySorting';

// Setting up delete dialog
$(document).ready(function() {
    var $deleteDialog = $('<div></div>')
        .dialog({
            autoOpen: false,
            modal: true,
            title: '###LLL:tx_yag_controller_gallery.realyDeleteGallery###'
        });

    $('a.gallery-linkbar-delete').click(function() {
        var galleryUid = $(this).attr("galleryUid");
        var gallery = $('tr#galleryUid-' + galleryUid);
        $deleteDialog.html('Really delete this gallery?');
        $deleteDialog.dialog({ buttons: {
                // ###translate###
                "###LLL:tx_yag_controller_gallery.deleteGallery###": function() {
                    $.ajax({
			            url: del_url,
			            data: "###pluginNamespace###[gallery]="+galleryUid, 
			            success: function(feedback) {
			                if(feedback=='OK') {
			                    $deleteDialog.dialog('close');
			                    $("#messages").html("<div id='inner_msg' class='typo3-message message-ok'>###LLL:tx_yag_controller_gallery.galleryDeleted###</div>");
			                    gallery.fadeOut();
			                }else{
			                    $("#messages").html("<div id='inner_msg' class='typo3-message message-error'>###LLL:tx_yag_controller_gallery.errorWhileDeleteGallery### "+feedback+"</div>");
			                    $( this ).dialog( "close" );
			                }
			                setTimeout(function(){$('#inner_msg').fadeOut();}, 5000);
			            }
			        });
                },
                '###LLL:tx_yag_general.cancel###': function() {
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
                          $("#messages").html("<div id='inner_msg' class='typo3-message message-ok'>###LLL:tx_yag_controller_gallery.sortingSaved###</div>");
                      } else {
                          // ###translate###
                          $("#messages").html("<div id='inner_msg' class='typo3-message message-error'>###LLL:tx_yag_controller_gallery.errorWhileSorting###" + feedback + "</div>");
                      }
                      setTimeout(function(){$('#inner_msg').fadeOut();}, 5000);
                  }
            });
        }
    }).disableSelection();
    
});