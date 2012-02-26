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

    controller.ItemList.list.template = EXT:yag/Resources/Private/Templates/ItemList/LightboxList.html

	resolutionConfigs {
		thumb >
		thumb {
			width = 150c
			height = 150c
		}

		galleryThumb < plugin.tx_yag.settings.themes.default.resolutionConfigs.thumb
		albumThumb < plugin.tx_yag.settings.themes.default.resolutionConfigs.thumb

		medium {
			maxW = 1200
			maxH = 1200
		}
	}



	includeLibJS = jQuery,jQueryFancybox
	includeLibCSS = jQueryFancybox
}
