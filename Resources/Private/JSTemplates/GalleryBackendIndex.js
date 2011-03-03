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
                    $("#messages").html("<div class='typo3-message message-ok'>Album ist als Thumbnail festgelegt!</div>");
                    photo.fadeOut();
                }else{
                    $("#messages").html("<div class='typo3-message message-error'>"+feedback+"</div>");
                }
            }
        });
    });
});