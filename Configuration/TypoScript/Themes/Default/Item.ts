####################################################
# Configuration for single item display
#
# @author Daniel Lienert <typo3@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.default.item {
	
	# Show the item title beneath the image
	showTitle = 1
	
	# Show the item description beneath the image
	showDescription = 1

	# Show the back / forward pager
	showPager = 1

	# Show Meta information for an item (including title and description)
	showItemMeta = 1
	
	# Show download link to original item
	showOriginalDownloadLink = 1

	# Path to pager partial
	pagerPartial = Pager/SingleItem

	# Path to item meta partial
	itemMetaPartial = Image/ImageMeta

	## Partial contains the image data and image meta data form fields
    itemFormFieldsPartial = Image/FormFields


	interaction < plugin.tx_yag.settings.themes.default.interaction
}