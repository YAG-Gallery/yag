####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <typo3@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.lightbox {

	title = Lightbox
	description = Shows the images in a lightbox.

	controller.ItemList.list.template = EXT:yag/Resources/Private/Templates/Themes/LightBox/ItemList/List.html

	resolutionConfigs >
	resolutionConfigs {
		thumb {
			width = 200c
			height = 200c
		}

		galleryThumb < .thumb
		albumThumb < .thumb

		medium {
			maxW = 1200
			maxH = 1200
		}
	}

	galleryList.columnCount >
	albumList.columnCount >

	includeLibJS = jQuery,lightBox
	includeLibCSS = lightBox

	includeJS {
		lightbox = EXT:yag/Resources/Public/Js/LightBox.js
	}

	## Define CSS Files to include.
	includeCSS >
	includeCSS {
		yag_theme_default = EXT:yag/Resources/Public/CSS/Lightbox.css
	}

	# Javascript file include position
	# Options are header / footer / inline
	jsPosition = footer

	javaScriptSettings {
		lightBox {
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
