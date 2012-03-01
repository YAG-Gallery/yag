####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

module.tx_yag.settings.themes.backend.item {
	
	# Show the item title beneath the image
	showTitle = 0
	
	# Show the item description beneath the image
	showDescription = 0
	
	# Show Meta information for an item (including title and description)
	showItemMeta = 1
	
	# Show downloadlink to original item
	showOriginalDownloadLink = 1
	
	# Path to item meta partial
	itemMetaPartial = Image/ImageMeta

}