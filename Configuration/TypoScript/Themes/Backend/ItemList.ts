####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

module.tx_yag.settings.themes.backend.itemList {
	
	itemsPerPage = 50
	columnCount = 5
	showTitle = 1

    ## Set partial used for rendering an image thumbnail
    imageThumbPartial = Image/ImageThumb

	## Set partial used for rendering an image thumbnail with admin functionalities
    imageAdminThumbPartial = Image/ImageAdminThumb

    ## Set partial used for rendering pager for itemList
    pagerPartial = Pager
}