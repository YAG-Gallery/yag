####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.lightbox {

    title = Lightbox
    description = Shows the images in a lightbox.

    controller.ItemList.list.template = EXT:yag/Resources/Private/Templates/Themes/LightBox/ItemList/List.html

	resolutionConfigs {
		thumb >
		thumb {
			width = 140c
			height = 140c
		}

		galleryThumb < .thumb
		albumThumb < .thumb

		medium {
			maxW = 1200
			maxH = 1200
		}
	}

	includeLibJS = jQuery,lightBox
	includeLibCSS = lightBox

	# Javascript file include position
	# Options are header / footer / inline
	jsPosition = footer


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
