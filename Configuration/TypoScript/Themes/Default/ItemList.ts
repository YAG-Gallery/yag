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
	showPager = 1


	zipDownload {
		active = 0

		# Available parameters are: gallery, album
		fileNameFormat = TEXT
		fileNameFormat.dataWrap = {field:album}.zip

		# chose "original" for the original resolution of the files or any other
		# resolution configuration identifier
		resolution = original
	}

    ## Set partial used for rendering an image thumbnail
    imageThumbPartial = Image/ImageThumb
    
	## Set partial used for rendering an image thumbnail with admin functionality
    imageAdminThumbPartial = Image/ImageAdminThumb

    ## Pager Identifier (default / delta)
    pagerIdentifier = default

    ## Set partial used for rendering pager for itemList (Default / Delta)
    pagerPartial = Pager/Default

	## Enable feeds in Rss / Atom format
	enableFeeds = 1

	## Link mode [show|link]
	linkMode = show

	## The page uid of the target page
	linkTargetPageUid =

	## The plugin mode on the target page
	linkTargetPluginMode = album

	## Easy filter configuration. For advanced Filters use the extList configuration directly
	filter {
		random = 0
	}
}