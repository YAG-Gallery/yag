var rfcControllerURL = '###rfcControllerURL###';
var yagRfcCancel = false;
var yagRfcTimeStart = new Date().getTime();

$(function() {
	
	$( "#yagRfcProgressbar" ).progressbar({
		value: 0
	});
	
	$('#yagRfcBuild').click(function() {
		yagRfcTimeStart = new Date().getTime();
		
		$( '#yagRfcBuilder' ).toggle().animate({ height: "165px" }, 500);
		
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
				
			var topMargin = Math.round((64 - response.thumbHeight) / 2);
			
			$('#yagRfcImageLine').prepend('<img src="../' + response.thumbPath + '" style="margin-top:'+topMargin+'px;">');
			
			if(response.nextItemUid == 0 || yagRfcCancel == true) {
				$( '#yagRfcBuilder' ).slideToggle('slow');
				$('#yagRfcInfo').toggle();
				
				var yagRfcTimeEnd = new Date().getTime();
				var usedTime = yagRfcTimeEnd - yagRfcTimeStart;
				
				if(yagRfcCancel == false) {
					$('#yagRfcInfo').html('<div class="typo3-message message-ok">All files are created! (Time: '+usedTime/1000+' Seconds)</div>');	
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