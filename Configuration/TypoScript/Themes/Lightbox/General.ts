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

	includeLibJS = jQuery,jQueryFancybox
	includeLibCSS = jQueryFancybox

	includeCSS {
		lightbox =  EXT:yag/Resources/Public/CSS/Lightbox.css
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
		titleShow = 1
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
