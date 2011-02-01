$(function() {

    $( "#directory" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "###ajaxURL###",
                dataType: "json",
                data: {
                    "###pluginNamespace###[directoryStartsWith]": request.term
                },
                success: function( data ) {
                    response( $.map( data, function( item ) {
                        return {
                            label: item.value,
                            value: item.value,
                            result: item.value
                        }
                    }));
                }
            });
        },
        minLength: 0,
        select: function( event, ui ) {
           $("#directory").val(ui.item.value);
        }
    });
});