####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.default.itemList {
	
	itemsPerPage = 20
	columnCount = 4
	showTitle = 1
	
    ## Set partial used for rendering an image thumbnail
    imageThumbPartial = Image/ImageThumb
    
	## Set partial used for rendering an image thumbnail with admin functionalities
    imageAdminThumbPartial = Image/ImageAdminThumb
}