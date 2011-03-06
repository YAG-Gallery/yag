####################################################
# YAG configuration for backend
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

module.tx_yag {

	settings < plugin.tx_yag.settings
	settings {
		theme = backend
	}
	
	persistence < plugin.tx_yag.persistence
	view < plugin.tx_yag.view
	view {
		layoutRootPath = EXT:yag/Resources/Private/Backend/Layouts/
	}
}




module.tx_ptextlist.settings < plugin.tx_ptextlist.settings


# Show hidden (hide = 1) albums in Backend
module.tx_yag.settings.themes.backend.extlist.albumList.filters.internalFilters.filterConfigs.10.hideHidden = 0