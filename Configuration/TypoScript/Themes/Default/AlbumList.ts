####################################################
#
# @author Daniel Lienert <daniel@lienert.cc> 
# @author Michael Knoll <mimi@kaktusteam.de.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.default.albumList {

	columnCount = 2
	showPager = 1

	## Enable feeds in Rss / Atom format
	enableFeeds = 1

	## Set partial used for rendering an album thumbnail
	albumThumbPartial = Album/AlbumThumb

	## Pager Identifier (default / delta)
    pagerIdentifier = default

	## Set partial used for rendering pager for itemList (Default / Delta)
    pagerPartial = Pager/Default

	# Albums per page
	itemsPerPage = 20
}