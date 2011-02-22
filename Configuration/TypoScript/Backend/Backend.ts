####################################################
# YAG configuration for backend
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



module.tx_yag.settings {

    # Overwrite template for album list in backend
    controller.Gallery.index.template = EXT:yag/Resources/Private/Templates/Gallery/BackendIndex.html


}