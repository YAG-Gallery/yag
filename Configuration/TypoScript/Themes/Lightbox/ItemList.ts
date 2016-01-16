####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <typo3@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.lightbox.itemList {
	
	itemsPerPage = 12
	columnCount = 4
	showTitle = 0


    ## Set partial used for rendering an image thumbnail
    imageThumbPartial = EXT:yag/Resources/Private/Templates/Themes/LightBox/Partials/ImageThumb.html
}