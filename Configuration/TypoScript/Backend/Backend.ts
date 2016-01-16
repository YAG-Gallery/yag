####################################################
# YAG configuration for backend
#
# @author Daniel Lienert <typo3@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################


module.tx_yag {

	view {
		layoutRootPaths.0 = EXT:yag/Resources/Private/Layouts/Backend/
	}

	settings {

		theme = backend

	}

}


# Show hidden (hide = 1) albums in Backend
module.tx_yag.settings.themes.backend.extlist.albumList.filters.internalFilters.filterConfigs.10.hideHidden = 0