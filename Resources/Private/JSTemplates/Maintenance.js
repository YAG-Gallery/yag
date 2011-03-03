var rfcControllerURL = '###rfcControllerURL###';
var yagRfcCancel = false;

$(function() {
	
	$( "#yagRfcProgressbar" ).progressbar({
		value: 0
	});
	
	$('#yagRfcBuild').click(function() {
		$( '#yagRfcBuilder' ).toggle().animate({ height: "150px" }, 500);
		
		$('#yagRfcInfo').hide();
		yagRfcCancel = false;
		
		startItem = $('#yagRfcCurrentItem').attr('yagRfcCurrentItem');
		createItemRFC(startItem);

	});
	
	$('#yagRfcCancel').click(function() {
		yagRfcCancel = true;
	});
	
});



function createItemRFC(itemUid) {

	jQuery.ajax({
        url: rfcControllerURL,
        data: '###pluginNamespace###[itemUid]=' + itemUid, 
        dataType: 'json',
        success: function(response) {
            
			$('#yagRfcCurrentItem').attr('yagRfcCurrentItem', response.nextItemUid).html(response.nextItemUid);
			$( "#yagRfcProgressbar" ).progressbar({
				value: Math.round(response.nextItemUid / $('#yagRfcBuilder').attr('itemCount') * 100)
			});
	
			$('#yagRfcImageLine').prepend('<img src="../' + response.thumbPath + '">');
			
			if(response.nextItemUid == 0 || yagRfcCancel == true) {
				$( '#yagRfcBuilder' ).slideToggle('slow');
				$('#yagRfcInfo').toggle();
				
				if(yagRfcCancel == false) {
					$('#yagRfcInfo').html('<div class="typo3-message message-ok">All files are created!</div>');	
				} else {
					$('#yagRfcInfo').html('<div class="typo3-message message-information">Creation cancled!</div>');
				}
				
				setTimeout(function(){$('#yagRfcInfo').fadeOut();}, 5000);
				
			} else {
				createItemRFC(response.nextItemUid);
			}
        }
    });	
}