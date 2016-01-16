####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <typo3@lienert.cc>
# @author Michael Knoll <mimi@kaktusteam.de>
# @package YAG
# @subpackage Typoscript
####################################################

module.tx_yag.settings.themes.backend.extlist.itemList {

	backendConfig < plugin.tx_ptextlist.prototype.backend.extbase
	backendConfig {

		respectStoragePage = 1

	    dataBackendClass = Tx_Yag_Extlist_DataBackend_YagDataBackend
		repositoryClassName = Tx_Yag_Domain_Repository_ItemRepository
		
		sorting = sorting
		
	}
	
	
	fields {
		image {
			table = __self__
			field = __object__
		}
		
		album {
			table = __self__
			field = album
		}
	}

	
	columns {
		10 {
			fieldIdentifier = image
			columnIdentifier = image
			label = Image
		}
	}
	
	
	filters {
		internalFilters {
			filterConfigs {
				10 {
					partialPath = noPartialNeeded
					filterClassName = Tx_Yag_Extlist_Filter_AlbumFilter
					filterIdentifier = albumFilter
					fieldIdentifier = album
				}
			}
		}
	}
	

	rendererChain {
		rendererConfigs {
			110 {
				rendererClassName = Tx_Yag_Extlist_Renderer_ImageListRenderer	
			}
		}
	}
}