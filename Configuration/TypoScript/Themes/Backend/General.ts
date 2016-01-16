####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <typo3@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

module.tx_yag.settings.themes.backend {

    title = Backend
    description = This theme is for use in the backend module only.

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
	
	jsPosition = header
	includeJS {
		10-jQuery  = EXT:yag/Resources/Public/Js/JQuery/jquery-1.7.2.min.js
		20-jqueryUi  = EXT:yag/Resources/Public/Js/JQuery/jquery-ui-1.8.10.custom.min.js
		30-jQueryCookie = EXT:yag/Resources/Public/Js/JQuery/jquery.cookie.js

		# Lightbox
		40-lightbox = EXT:yag/Resources/Public/Js/MagnificPopup/dist/jquery.magnific-popup.min.js

		# Uploadify
		50-uploadify = EXT:yag/Resources/Public/Uploadify/jquery.uploadify.min.js

		# Zip Uploader
		60-filetree = 	EXT:yag/Resources/Public/Js/JQuery/fileTree/jqueryFileTree.js

		# HTML 5 Uploader
		70-fileDrop = 	EXT:yag/Resources/Public/Js/JQuery/jquery.filedrop.js

	}
	
	includeCSS {
		jqueryUi = EXT:yag/Resources/Public/CSS/JQuery/ui-lightness/jquery-ui-1.8.7.custom.css

		yag_theme_default = EXT:yag/Resources/Public/CSS/theme.css
		yag_theme_backend = EXT:yag/Resources/Public/CSS/Backend.css
		yag_filetree = EXT:yag/Resources/Public/CSS/JQuery/jqueryFileTree.css
		lightbox = EXT:yag/Resources/Public/Js/MagnificPopup/dist/magnific-popup.css

        uploadify = EXT:yag/Resources/Public/Uploadify/uploadify.css
	}


	javaScriptSettings {
		lightbox {
    		enabled = 1
    		mainClass = mfp-with-zoom mfp-fade
    		zoom {
    		  enabled = true
    		  duration = 200
    		  easing = ease-in-out
    		}
    	}
	}
}