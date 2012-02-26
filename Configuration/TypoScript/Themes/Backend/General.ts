####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.backend {

    title = Backend
    description = This theme is for use in the TYPO3 backend only.

    extlist {
        # Remove gallery hidden filter, so that all galleries are displayed in BE list
        galleryList.filters.internalFilters >
    }

    albumList.itemsPerPage = 0
    galleryList.itemsPerPage = 0

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
	
	# SWFUploader
	includeJS {
		jQuery  = EXT:yag/Resources/Public/Js/JQuery/jquery-1.5.1.min.js
		jqueryUi  = EXT:yag/Resources/Public/Js/JQuery/jquery-ui-1.8.10.custom.min.js
		swfupload = EXT:yag/Resources/Public/SwfUpload/swfupload.js
		swfobjects = EXT:yag/Resources/Public/Js/swfobjects.js
		swfuploadqueue = EXT:yag/Resources/Public/Js/swfuploadqueue.js
		fileprogress = EXT:yag/Resources/Public/Js/fileprogress.js
		swfcustom = EXT:yag/Resources/Public/Js/swfcustom.js
		filetree = EXT:yag/Resources/Public/Js/JQuery/fileTree/jqueryFileTree.js
	}
	
	includeCSS {
		jqueryUi = EXT:yag/Resources/Public/CSS/JQuery/ui-lightness/jquery-ui-1.8.7.custom.css
		
		jqueryShadowbox =  EXT:yag/Resources/Public/CSS/shadowbox.css
		
		yag_theme_default = EXT:yag/Resources/Public/CSS/theme.css
		yag_theme_backend = EXT:yag/Resources/Public/CSS/Backend.css
		yag_filetree = EXT:yag/Resources/Public/CSS/JQuery/jqueryFileTree.css
	}
}