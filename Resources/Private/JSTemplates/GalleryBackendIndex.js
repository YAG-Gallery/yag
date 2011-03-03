var setalbumthumb_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=setAlbumAsGalleryThumb';

$(function() {
    // Handle delete action for item
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
});