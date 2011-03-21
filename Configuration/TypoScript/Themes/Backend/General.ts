####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.backend {

	resolutionConfigs {
		icon64 {
			width = 48c
			height = 48c
		}
		
		thumb > 
		thumb {
			width = 110c
			height = 110c
		}
	}
	
	controller {
		ItemList {
			list.template = EXT:yag/Resources/Private/Templates/ItemList/ItemAdminList.html
		}
		
		Gallery {
			index.template = EXT:yag/Resources/Private/Templates/Gallery/BackendIndex.html
			list.template = EXT:yag/Resources/Private/Templates/Gallery/BackendList.html
		}
	}
	
	# jQuery / jQueryUi / shadownBoc
	includeLibJS = jQuery,jQueryUi,jQueryShadowBox
	includeLibCSS = jQuery,jQueryUi,jQueryShadowBox
	
	# SWFUploader
	includeJS {
		swfupload = EXT:yag/Resources/Public/SwfUpload/swfupload.js
		swfobjects = EXT:yag/Resources/Public/Js/swfobjects.js
		swfuploadqueue = EXT:yag/Resources/Public/Js/swfuploadqueue.js
		fileprogress = EXT:yag/Resources/Public/Js/fileprogress.js
		swfcustom = EXT:yag/Resources/Public/Js/swfcustom.js
	}
	
	includeCSS {
		yag_theme_default = EXT:yag/Resources/Public/CSS/theme.css
		yag_theme_backend = EXT:yag/Resources/Public/CSS/Backend.css
	}
}
