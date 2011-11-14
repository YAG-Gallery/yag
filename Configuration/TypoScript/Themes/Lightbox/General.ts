####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.lightbox {

    controller.ItemList.list.template = EXT:yag/Resources/Private/Templates/ItemList/LightboxList.html

    title = Lightbox
    description = Shows the images in a lightbox.

	includeLibJS = jQuery,jQueryShadowBox
	includeLibCSS = jQueryShadowBox
}
