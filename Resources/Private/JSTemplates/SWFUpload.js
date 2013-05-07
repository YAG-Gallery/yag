$(function() {
    $('#file_upload').uploadify({
        'formData'     : {
            "###pluginNamespace###[album]" : ###albumUid###,
            "skipSessionUpdate" : 0,
            "vC" : "###veriCode###",
        },
        'buttonText'   : '###LLL:tx_yag_general.uploadFile###',
        'swf'      :  "###swfURL###",
        'uploader' :  "###uploadURL###",
        'fileSizeLimit' : '###file_size_limit###',
    });
});
