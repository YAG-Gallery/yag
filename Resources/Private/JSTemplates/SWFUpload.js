var swfu;

SWFUpload.onload = function () {
    
    swfu = new SWFUpload({
        flash_url : "###swfURL###",
        upload_url: "###uploadURL###",
        post_params: {
            "###pluginNamespace###[album]" : ###albumUid###,
            "fe_typo_user" : readCookie('fe_typo_user'),
            "be_typo_user" : readCookie('be_typo_user'),
            "skipSessionUpdate" : 0,
            "vC" : "###veriCode###"
        },
        file_size_limit : "###file_size_limit###",
        file_types : "###file_types###",
        file_types_description : "JPG Images",
        file_upload_limit : ###file_upload_limit###,
        file_queue_limit : 0,
        custom_settings : {
            progressTarget : "fsUploadProgress",
            cancelButtonId : "btnCancel"
        },
        debug: false,

        // Button Settings
        button_image_url : "###button_image_url###",
        button_placeholder_id : "spanButtonPlaceholder",
        //button_text : '<span class="yag-fakeButton">###LLL:tx_yag_general.uploadFile###</span>',
        button_width: 100,
        button_height: 22,

        // The event handler functions are defined in handlers.js
        swfupload_loaded_handler : swfUploadLoaded,
        file_queued_handler : fileQueued,
        file_queue_error_handler : fileQueueError,
        file_dialog_complete_handler : fileDialogComplete,
        upload_start_handler : uploadStart,
        upload_progress_handler : uploadProgress,
        upload_error_handler : uploadError,
        upload_success_handler : uploadSuccess,
        upload_complete_handler : uploadComplete,
        queue_complete_handler : queueComplete, // Queue plugin event
        
        // SWFObject settings
        minimum_flash_version : "9.0.28",
        swfupload_pre_load_handler : swfUploadPreLoad,
        swfupload_load_failed_handler : swfUploadLoadFailed
    }); 
    
    
    // Reads a cookie value from document's cookie
    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }
    
};



$(function() {
        $('#album_uid').change(function() {
            swfu.setPostParams({"###pluginNamespace###[album]" : $('#album_uid').val()})
        });
});