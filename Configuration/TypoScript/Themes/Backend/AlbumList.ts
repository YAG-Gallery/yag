####################################################
#
# @author Daniel Lienert <daniel@lienert.cc> 
# @author Michael Knoll <mimi@kaktusteam.de.de>
# @package YAG
# @subpackage Typoscript
####################################################

module.tx_yag.settings.themes.default.albumList {

	columnCount = 2
	showPager = 1

	## Set partial used for rendering an album thumbnail
	albumThumbPartial = Album/AlbumThumb
	
	# Albums per page
	itemsPerPage = 20
}