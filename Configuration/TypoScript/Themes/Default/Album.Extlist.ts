####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> 
# @author Michael Knoll <mimi@kaktusteam.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.default.extlist.albumList {
	backendConfig < plugin.tx_ptextlist.prototype.backend.extbase
	backendConfig {
	
		repositoryClassName = Tx_Yag_Domain_Repository_ItemRepository
	
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
			renderTemplate = EXT:yag/Resources/Private/Partials/ImageThumb.html
		}
	}
	
	pager {
		itemsPerPage = 12
	}
	
	filters {
		internalFilters {
			filterConfigs {
				10 {
					partialPath = noPartialNeeded
					filterClassName = Tx_Yag_Domain_Model_Filter_AlbumImageFilter
					filterIdentifier = albumFilter
					fieldIdentifier = album
				}
			}
		}
	}
}