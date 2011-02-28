####################################################
# YAG configuration for backend
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

# Include Backend Theme
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Backend/Theme.ts">

module.tx_yag {

	settings < plugin.tx_yag.settings
	settings {
		
		general < plugin.tx_yag.settings.themes.backend.general
		itemList < plugin.tx_yag.settings.themes.backend.itemList
		
		# Overwrite template for album list in backend
		controller.Gallery.index.template = EXT:yag/Resources/Private/Templates/Gallery/BackendIndex.html
		controller.Gallery.list.template = EXT:yag/Resources/Private/Templates/Gallery/BackendList.html
	}
	
	
	persistence < plugin.tx_yag.persistence
	view < plugin.tx_yag.view
	view {
		layoutRootPath = EXT:yag/Resources/Private/Backend/Layouts/
	}
}




module.tx_ptextlist.settings < plugin.tx_ptextlist.settings