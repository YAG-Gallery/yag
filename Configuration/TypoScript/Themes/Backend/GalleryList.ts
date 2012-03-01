####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

config.tx_yag.settings.themes.backend.galleryList {

	columnCount = 2
	
	showPager = 1
	
	## Set partial used for rendering an gallery thumbnail
	galleryThumbPartial = Gallery/GalleryThumb
	
	# Galleries per page
	itemsPerPage = 20
}