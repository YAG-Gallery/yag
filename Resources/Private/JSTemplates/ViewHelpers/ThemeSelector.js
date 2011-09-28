$(function() {
    $('input[name=\'yagRFCThemeSelection\']').change(function() {

        var selectedThemes = new Object();

        $('input[name=\'yagRFCThemeSelection\']').each(function() {
            if($(this).val()) {
                selectedThemes[$(this).val()] = $(this).attr('checked');
            }
        });

        $.ajax({
            url: "###themeSelectionControllerURL###",
            data: {selectedThemes: selectedThemes}
        });
    });
});