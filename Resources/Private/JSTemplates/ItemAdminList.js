var del_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=deleteItem';
var key_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=setItemAsAlbumThumb';
var update_title_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=updateItemTitle';
var update_description_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=updateItemDescription';
var sorting_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=updateItemSorting';

// Tastatureingaben
$(document.documentElement).keyup(function (event) {
    // Eingabe per ESC schlie§en
    if (event.keyCode == 27) {
        $(".photo-detail-name").slideUp('fast');
        $(".photo-detail-description").hide();
        $(".photo-detail").css("z-index","10");
        $("#change-topic-input").hide();
        $("#change-topic-text").show();
    } 
});

// Setting up delete dialog
$(document).ready(function() {
    var $deleteDialog = $('<div></div>')
        .dialog({
            autoOpen: false,
            modal: true,
            title: '###LLL:tx_yag_controller_item.realyDeleteItem###'
        });

    $('a.photo-detail-linkbar-delete').click(function() {
        var photo = $(this).parents(".photo-detail");
        $deleteDialog.html('###LLL:tx_yag_controller_item.deleteItemDescription###');
        $deleteDialog.dialog({ buttons: {
                "###LLL:tx_yag_controller_item.deleteItem###": function() {
                    $.ajax({
			            url: del_url,
			            // we use id of photo div and cut off leading "imageUid-"
			            data: "###pluginNamespace###[item]="+photo.attr("id").substring(9), 
			            success: function(feedback) {
			                if(feedback=='OK') {
			                    $deleteDialog.dialog('close');
			                    // ###translate###
			                    $("#messages").html("<div id='inner_msg' class='typo3-message message-ok'>###LLL:tx_yag_controller_item.itemDeleted###</div>");
			                    photo.fadeOut();
			                }else{
			                    $("#messages").html("<div id='inner_msg' class='typo3-message message-error'>"+feedback+"</div>");
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
    $('#change-topic').click(function() {
        $("#change-topic-text").hide();
        $("#change-topic-input").show();
        $("#focus").select();
    });
    
    // Open up a form, if title of item is clicked
    $(".photo-detail-text").click(function () {
        $(this).parents("div.photo-detail").children(".photo-detail-name").show();
    });
    
    // Handle cancel-action in item name form
    $(".photo-detail-name-cancel").click(function () {
        $(this).parents(".photo-detail-name").hide();
    });
    
    $(".photo-detail-text").mouseover(function() {
        $(this).addClass(".photo-detail-text-bg");
    });
    
    // Open up a form for setting description of item
    $("a.photo-detail-linkbar-description").click(function () {
          $(this).parents("div.photo-detail").children(".photo-detail-description").show();
          $(this).parents("div.photo-detail").css("z-index","50");
    });
    
    // Handle cancel action for item description form
    $(".photo-detail-description-cancel").click(function () {
        $(this).parents(".photo-detail-description").hide();
        $(this).parents("div.photo-detail").css("z-index","10");
    });
    
    // blend linkbar in and out on mouseover
    $(".photo-detail-photo").mouseover(function() {
        $(this).children(".photo-detail-linkbar").show();
    });
    $(".photo-detail-photo").mouseout(function() {
        $(this).children(".photo-detail-linkbar").hide();
    });

    // Sumbmit sorting of items whenever item is draged & dropped
    $("#sortable").sortable({  
        //handle: 'div.photo-overview',
        update : function () {
          var order = $('#sortable').sortable('serialize');
            $.ajax({
                  url: sorting_url,
                  type: "POST",
                  data: order,
                  // complete: function(){},
                  success: function(feedback){
                      if (feedback == 'OK' ) { 
                          // ###translate###
                          $("#messages").html("<div id='inner_msg' class='typo3-message message-ok'>###LLL:tx_yag_controller_item.sortingSaved###</div>");
                      } else {
                          // ###translate###
                          $("#messages").html("<div id='inner_msg' class='typo3-message message-error'>###LLL:tx_yag_controller_item.errorWhileSorting###: " + feedback + "</div>");
                      }
                      setTimeout(function(){$('#inner_msg').fadeOut();}, 5000);
                  }
                  // error: function(){}
            });
        }
    });
    
    // Handle 'set as key' action for item
    $("a.photo-detail-linkbar-key").click(function () {
        var photo = $(this).parents(".photo-detail");
        $.ajax({
            url: key_url,
            // we use id of photo div and cut off leading "imageUid-"
            data: "###pluginNamespace###[item]=" + photo.attr("id").substring(9), 
            success: function(feedback) {
                if(feedback=='OK') {
                    $("div.photo-detail-index-photo").removeClass('photo-detail-index-photo');
                    $("div#imageUid-"+photo.attr("id").substring(9)).addClass('photo-detail-index-photo');
                    $("#messages").html("<div id='inner_msg' class='typo3-message message-ok'>###LLL:tx_yag_controller_item.itemSetAsAlbumThumb###</div>");
                }else{
                    $("#messages").html("<div id='inner_msg' class='typo3-message message-error'>"+feedback+"</div>");
                }
                setTimeout(function(){$('#inner_msg').fadeOut();}, 5000);
            }
        });
    });
    
    // Handle 'update item title' action
    $(".photo-detail-name-submit").click(function() {
        var photo = $(this).parents(".photo-detail");
        var itemUid = photo.attr("id").substring(9);
        var itemTitle = $(this).siblings("#PhotoName").val();
        $.ajax({
            url: update_title_url,
            data: "###pluginNamespace###[itemTitle]=" + escape(itemTitle) + "&###pluginNamespace###[item]=" + itemUid,
            success: function(feedback) {
                if (feedback=='OK') {
                    // ###translate###
                    $("#messages").html("<div id='inner_msg' class='typo3-message message-ok'>###LLL:tx_yag_controller_item.itemTitleUpdated###</div>");
                    $("#imageUid-" + itemUid).children(".photo-detail-text").html(itemTitle);
                    $("#imageUid-" + itemUid).children("#PhotoName").val(itemTitle);
                    $("#item-title-textbox-" + itemUid).val(itemTitle);
                } else {
                    $("#messages").html("<div id='inner_msg' class='typo3-message message-error'>"+feedback+"</div>");
                }
                setTimeout(function(){$('#inner_msg').fadeOut();}, 5000);
            }
        });
        // We cannot do this inside ajax call, as 'this' is not defined there!
        $(this).parents(".photo-detail-name").hide();
    });
    
    // Handle 'update item description' action
    $(".photo-detail-description-submit").click(function() {
        var photo = $(this).parents(".photo-detail");
        var itemUid = photo.attr("id").substring(9);
        var itemDescription = $(this).siblings("#PhotoDescription").val();
        $.ajax({
            url: update_description_url,
            data: "###pluginNamespace###[itemDescription]=" + escape(itemDescription) + "&###pluginNamespace###[item]=" + itemUid,
            success: function(feedback) {
                if (feedback=='OK') {
                    // ###translate###
                    $("#messages").html("<div id='inner_msg' class='typo3-message message-ok'>###LLL:tx_yag_controller_item.itemDescriptionUpdated###</div>");
                    $("#imageUid-" + itemUid).children("#PhotoDescription").html(itemDescription);
                    $("#item-decription-textarea-" + itemUid).html(itemDescription);
                } else {
                    $("#messages").html("<div id='inner_msg' class='typo3-message message-error'>"+feedback+"</div>");
                }
                setTimeout(function(){$('#inner_msg').fadeOut();}, 5000);
            }
        });
        // We cannot do this inside ajax call, as 'this' is not defined there!
        $(this).parents(".photo-detail-description").hide();
    });
    
});  

// Initialize Shadowbox
Shadowbox.init({flashVars: {
    autostart: true
}});