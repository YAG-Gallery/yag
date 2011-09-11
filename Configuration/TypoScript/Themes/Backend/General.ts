####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.backend {

    extlist {
        # Remove gallery hidden filter, so that all galleries are displayed in BE list
        galleryList.filters.internalFilters >

        # Turn off pagers for albums and galleries as sorting does not work otherwise
        albumList.itemsPerPage = 0
        galleryList.itemsPerPage = 0
    }

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
	
	# jQuery / jQueryUi / shadowBox
	# includeLibJS = jQuery,jQueryUi,jQueryShadowBox
	# includeLibCSS = jQuery,jQueryUi,jQueryShadowBox
	
	# SWFUploader
	includeJS {
		jQuery  = EXT:yag/Resources/Public/Js/JQuery/jquery-1.5.1.min.js
		jqueryUi  = EXT:yag/Resources/Public/Js/JQuery/jquery-ui-1.8.10.custom.min.js
		
		jqueryUiShadowbox  =  EXT:yag/Resources/Public/Js/JQuery/shadowbox.js
		jqueryUiLightbox = EXT:yag/Resources/Public/Js/shadowbox_init.js
		
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