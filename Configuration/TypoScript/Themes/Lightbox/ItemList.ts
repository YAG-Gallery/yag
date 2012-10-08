####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.lightbox.itemList {
	
	itemsPerPage = 12
	columnCount = 4
	showTitle = 0


    ## Set partial used for rendering an image thumbnail
    imageThumbPartial = Image/LightboxImageThumb
}