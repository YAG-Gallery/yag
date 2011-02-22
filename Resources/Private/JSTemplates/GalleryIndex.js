var sorting_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=updateGallerySorting' + '&###pluginNamespace###[gallery]=###galleryUid###';


// Handling ajax events
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
                          $("#messages").html("<div class='message_ok'>Sortierung der Alben wurde gespeichert!</div>");
                      } else {
                          $("#messages").html("<div class='message_error'>Fehler beim Sortieren der Alben" + feedback + "</div>");
                      }
                  }
            });
        }
    }).disableSelection();
    
});  
