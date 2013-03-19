// ATTENTION: There are two lines added in file tree script to enable
// submitting of selected directories to server

var serverside_url = '###ajaxBaseURL###' + '&###pluginNamespace###[action]=getSubDirs';

$(document).ready( function() {
    $('#filetree').fileTree({ 
        root: '',
        script: serverside_url,
        multiFolder: false,
        loadMessage: 'Subdirectories are loaded' 
    }, function(file) {
        alert('###errorMessageOnPickingFiles###');
    });
});