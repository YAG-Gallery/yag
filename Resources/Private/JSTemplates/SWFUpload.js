var swfu;

SWFUpload.onload = function () {
    
    swfu = new SWFUpload({
        flash_url : "typo3conf/ext/yag/Resources/Public/SwfUpload/Flash/swfupload.swf",
        upload_url: ###uploadURL###,
        post_params: {
            "tx_yag_pi1[album]" : ###albumUid###
        },
        file_size_limit : "100 MB",
        file_types : "*.jpg",
        file_types_description : "JPG Images",
        file_upload_limit : 100,
        file_queue_limit : 0,
        custom_settings : {
            progressTarget : "fsUploadProgress",
            cancelButtonId : "btnCancel"
        },
        debug: false,

        // Button Settings
        button_image_url : "typo3conf/ext/yag/Resources/Public/Icons/XPButtonUploadText_61x22.png",
        button_placeholder_id : "spanButtonPlaceholder",
        button_width: 61,
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
};



$(function() {
        $('#album_uid').change(function() {
            swfu.setPostParams({"tx_yag_pi1[album]" : $('#album_uid').val()})
        });
});