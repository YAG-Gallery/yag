####################################################
# Theme configuration root 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

module.tx_yag {
	settings < plugin.tx_yag.settings
	persistence < plugin.tx_yag.persistence
	view < plugin.tx_yag.view
	view {
		layoutRootPath = EXT:yag/Resources/Private/Backend/Layouts/
	}
}

module.tx_ptextlist.settings < plugin.tx_ptextlist.settings