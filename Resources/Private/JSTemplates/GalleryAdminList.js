var del_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=deleteGallery';
var sorting_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=updateGallerySorting' + '&###pluginNamespace###[gallery]=###galleryUid###';

// Setting up delete dialog
$(document).ready(function() {
    var $deleteDialog = $('<div></div>')
        .dialog({
            autoOpen: false,
            modal: true,
            title: 'Really delete?'
        });

    $('a.gallery-linkbar-delete').click(function() {
        var galleryUid = $(this).attr("galleryUid");
        var gallery = $('tr#galleryUid-' + galleryUid);
        $deleteDialog.html('Really delete this gallery?');
        $deleteDialog.dialog({ buttons: {
                "Delete gallery": function() {
                    $.ajax({
			            url: del_url,
			            data: "###pluginNamespace###[gallery]="+galleryUid, 
			            success: function(feedback) {
			                if(feedback=='OK') {
			                    $deleteDialog.dialog('close');
			                    $("#messages").html("<div id='inner_msg' class='typo3-message message-ok'>Gallery wurde gel&ouml;scht!</div>");
			                    gallery.fadeOut();
			                }else{
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