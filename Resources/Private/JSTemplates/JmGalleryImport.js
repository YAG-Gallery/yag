var load_category_and_album_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=getCategoriesAndAlbums';

$(document).ready(function() {
    // Load categories and album list from server
    $("#category-and-album-loader").click(function () {
        alert('jes');
        $.ajax({
            url: load_category_and_album_url,
            success: function(data) {
                $("#categoryAndAlbumList").html("<pre>"+data+"</pre>");
            }
        });
    });
}