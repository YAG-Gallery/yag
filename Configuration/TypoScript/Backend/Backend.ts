####################################################
# YAG configuration for backend
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################


module.tx_yag {

	# Extbase
	# =========================
	
	view {
		layoutRootPath = EXT:yag/Resources/Private/Backend/Layouts/
	}

	settings {

		theme = backend

		# Crawler
		# =========================

		crawler {
			fileTypes = .jpg,.jpeg
		}


		# Importer
		# =========================

		importer {
			# Extract Item Meta data from JPEG files
			parseItemMeta = 1

			generateTagsFromMetaData = 1

			# Generate the resolutions for this template by default
			generateResolutions = backend

			# Write the files with this fileMask to disk
			importFileMask = 660
		}
	}
}


# Show hidden (hide = 1) albums in Backend
module.tx_yag.settings.themes.backend.extlist.albumList.filters.internalFilters.filterConfigs.10.hideHidden = 0