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

	}
}


# Show hidden (hide = 1) albums in Backend
module.tx_yag.settings.themes.backend.extlist.albumList.filters.internalFilters.filterConfigs.10.hideHidden = 0