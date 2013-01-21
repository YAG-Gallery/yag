####################################################
# YAG Basic configuration
# Configuration for yag gallery
#
# @author Daniel Lienert <daniel@lienert.cc>
# @author Michael Knoll <mimi@kaktusteam.de.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings {

	# Set default theme, can be overwritten by flexform
	theme = default


	# Link Rendering
	typoLink {

	}


	#
	# This settings can be used to overwrite the flexform configuration,
	#
	overwriteFlexForm {
		contextIdentifier =
		contextReset =

		theme =
		context {
			selectedPid =
			selectedGalleryUid =
			selectedAlbumUid =
			selectedItemUid =

			galleryList {
				itemsPerPage =
				sorting {
					field =
					direction =
				}
			}

			albumList {
				itemsPerPage =
				sorting {
					field =
					direction =
				}
			}

			itemList {
				itemsPerPage =
				sorting {
					field =
					direction =
				}

				linkMode =
				linkTargetPageUid =
				linkTargetPluginMode =

				filter {
					random =
				}
			}
		}
	}
}