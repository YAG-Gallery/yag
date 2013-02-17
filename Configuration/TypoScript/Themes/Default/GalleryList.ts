####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.default.galleryList {

	columnCount = 2
	
	showPager = 1

	## Pager Identifier (default / delta)
	pagerIdentifier = default

	## Set partial used for rendering pager for itemList
	pagerPartial = Pager/Default

	## Set partial used for rendering an gallery thumbnail
	galleryThumbPartial = Gallery/GalleryThumb

	# Galleries per page
	itemsPerPage = 20

	## Enable feeds in Rss / Atom format
    enableFeeds = 1
}