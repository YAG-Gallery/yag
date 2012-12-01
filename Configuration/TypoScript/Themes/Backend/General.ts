####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

module.tx_yag.settings.themes.backend {

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

		medium {
			maxW = 800
			maxH = 600
		}
	}
	
	controller {
		Album {
			addItems.template = EXT:yag/Resources/Private/Templates/Themes/Backend/Album/AddItems.html
		}

		ItemList {
			list.template = EXT:yag/Resources/Private/Templates/Themes/Backend/ItemList/ItemAdminList.html
		}
		
		Gallery {
			index.template = EXT:yag/Resources/Private/Templates/Themes/Backend/Gallery/BackendIndex.html
			list.template = EXT:yag/Resources/Private/Templates/Themes/Backend/Gallery/BackendList.html
		}
	}
	

	includeJS {
		jQuery  = EXT:yag/Resources/Public/Js/JQuery/jquery-1.6.4.min.js
		jqueryUi  = EXT:yag/Resources/Public/Js/JQuery/jquery-ui-1.8.10.custom.min.js
		jQueryCookie = EXT:yag/Resources/Public/Js/JQuery/jquery.cookie.js

		# SWFUploader
		swfupload = EXT:yag/Resources/Public/SwfUpload/swfupload.js
		swfobjects = EXT:yag/Resources/Public/Js/swfobjects.js
		swfuploadqueue = EXT:yag/Resources/Public/Js/swfuploadqueue.js
		fileprogress = EXT:yag/Resources/Public/Js/fileprogress.js
		swfcustom = EXT:yag/Resources/Public/Js/swfcustom.js

		# Zip Uploader
		filetree = 	EXT:yag/Resources/Public/Js/JQuery/fileTree/jqueryFileTree.js

		# HTML 5 Uploader
		fileDrop = 	EXT:yag/Resources/Public/Js/JQuery/jquery.filedrop.js

		jqueryFancyBox  =  EXT:yag/Resources/Public/Js/JQuery/Fancybox/jquery.fancybox-1.3.4.pack.js
        jqueryMouseWheel  =  EXT:yag/Resources/Public/Js/JQuery/Fancybox/jquery.mousewheel-3.0.4.pack.js
        jqueryEasing  =  EXT:yag/Resources/Public/Js/JQuery/Fancybox/jquery.easing-1.3.pack.js

	}
	
	includeCSS {
		jqueryUi = EXT:yag/Resources/Public/CSS/JQuery/ui-lightness/jquery-ui-1.8.7.custom.css

		yag_theme_default = EXT:yag/Resources/Public/CSS/theme.css
		yag_theme_backend = EXT:yag/Resources/Public/CSS/Backend.css
		yag_filetree = EXT:yag/Resources/Public/CSS/JQuery/jqueryFileTree.css

		jqueryFancybox =  EXT:yag/Resources/Public/Js/JQuery/Fancybox/jquery.fancybox-1.3.4.css
        yagFancybox =  EXT:yag/Resources/Public/CSS/Fancybox.css
	}


	/**
	 * FancyBox settings. See http://fancybox.net/api for a detailed description
	 */
	fancybox {
		margin = 10
		padding = 0
		opacity = 0
		modal = 0
		cyclic = 1
		scrolling = auto
		hideOnOverlayClick = 1
		hideOnContentClick = 0
		overlayShow = 1
		overlayOpacity = 0.8
		overlayColor = #000
		transitionIn = elastic
		transitionOut = elastic
		titlePosition = over
		autoScale =	1
		titleShow = 0
		speedIn = 300
		speedOut = 300
		changeFade = fast
		easingIn = swing
		easingOut = swing
		showCloseButton = 1
		showNavArrows = 1
		enableEscapeButton = 1
	}
}