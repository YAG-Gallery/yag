####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.default.randomItemList < plugin.tx_yag.settings.themes.default.itemList
plugin.tx_yag.settings.themes.default.randomItemList {
	
	itemsPerPage = 3
	columnCount = 3
	showTitle = 1
	showPager = 1
	
    ## Set partial used for rendering an image thumbnail
    imageThumbPartial = Image/ImageThumb

	## Link mode
    linkMode = yagPage
    linkTargetPid = 86
    linkTargetYAGMode = Album
}