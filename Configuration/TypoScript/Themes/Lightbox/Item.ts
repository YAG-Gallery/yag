####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <typo3@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.lightbox.item {
	
	# Show the item title beneath the image
	showTitle = 0
	
	# Show the item description beneath the image
	showDescription = 0

	# Show a perma link to the lightbox image
	showPermaLink = 1

	# Show downloadlink to original item
	showOriginalDownloadLink = 0

	# Path to item meta partial
	itemMetaPartial = Image/ImageMeta

	## Set partial used for rendering the lightBox meta data
	lightBoxMetaPartial = EXT:yag/Resources/Private/Templates/Themes/LightBox/Partials/LightBoxMeta.html

	lightbox {
		# Show the item title beneath the image
		showTitle = 1

		# Show the item description beneath the image
		showDescription = 1

		# Show a perma link to the lightbox image
		showPermaLink = 1

		# Show downloadlink to original item
		showOriginalDownloadLink = 0

		# Show the copyright info
		showCopyright = 0
	}
}
