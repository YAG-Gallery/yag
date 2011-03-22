####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.backend {

	resolutionConfigs {
		icon64 {
			width = 48c
			height = 48c
		}
		thumb > 
		thumb {
			width = 110c
			height = 110c
		}
	}
	
	controller {
		ItemList {
			list.template = EXT:yag/Resources/Private/Templates/ItemList/ItemAdminList.html
		}
		
		Gallery {
			index.template = EXT:yag/Resources/Private/Templates/Gallery/BackendIndex.html
			list.template = EXT:yag/Resources/Private/Templates/Gallery/BackendList.html
		}
	}
}
