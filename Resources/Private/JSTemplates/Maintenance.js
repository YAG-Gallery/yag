var rfcControllerURL = '###rfcControllerURL###';
var yagRfcCancel = false;
var yagRfcTimeStart = new Date().getTime();
var procItemsCount = 0;

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
        data: '###pluginNamespace###[item]=' + itemUid, 
        dataType: 'json',
        success: function(response) {
			procItemsCount++;    
		
			$('#yagRfcCurrentItem').attr('yagRfcCurrentItem', response.nextItemUid).html(response.nextItemUid);
			$( "#yagRfcProgressbar" ).progressbar({
				value: Math.round(procItemsCount / $('#yagRfcBuilder').attr('itemCount') * 100)
			});
			
			$('#yagRfcImageLine').prepend('<img src="../' + response.thumbPath + '">');
			
			if(response.nextItemUid == 0 || yagRfcCancel == true) {
				$( '#yagRfcBuilder' ).slideToggle('slow');
				$('#yagRfcInfo').toggle();
				
				var yagRfcTimeEnd = new Date().getTime();
				var usedTime = yagRfcTimeEnd - yagRfcTimeStart;
				
				if(yagRfcCancel == false) {
				    // ###translate###
					$('#yagRfcInfo').html('<div class="typo3-message message-ok">###LLL:tx_yag_controller_backend_MaintenanceOverview.resolutionFilesCreated### ('+usedTime/1000+' Sec)</div>');	
				} else {
				    // ###translate###
					$('#yagRfcInfo').html('<div class="typo3-message message-information">###LLL:tx_yag_controller_backend_MaintenanceOverview.resolutionFilesCreationCancled###</div>');
				}
				
				setTimeout(function(){$('#yagRfcInfo').fadeOut();}, 5000);
				
			} else {
				createItemRFC(response.nextItemUid);
			}
        }
    });	
}