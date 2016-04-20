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

	    dataBackendClass = DL\Yag\Extlist\DataBackend\YagDataBackend
		repositoryClassName = DL\Yag\Domain\Repository\ItemRepository
		
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
					filterClassName = DL\Yag\Extlist\Filter\AlbumFilter
					filterIdentifier = albumFilter
					fieldIdentifier = album
				}
			}
		}
	}
	

	rendererChain {
		rendererConfigs {
			110 {
				rendererClassName = DL\Yag\Extlist\Renderer\ImageListRenderer
			}
		}
	}
}