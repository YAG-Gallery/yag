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
		
		albumUid {
			table = __self__
			field = album
		}

		imageUid {
			table = __self__
			field = uid
		}			
		
	}

	columns {
		10 {
			fieldIdentifier = image
			columnIdentifier = image
			label = Image
		}
	}
	
	pager {
		itemsPerPage = 4
	}
	
	filters {
		internalFilters {
			filterConfigs {
				10 {
					partialPath = noPartialNeeded
					filterClassName = Tx_Yag_Extlist_Filter_GalleryImageFilter
					filterIdentifier = albumFilter
					fieldIdentifier = albumUid, imageUid
				}
			}
		}
	}
	
	
	rendererChain {
		rendererConfigs {
			110 {
				rendererClassName = Tx_Yag_Extlist_Renderer_ImageListRenderer
				structuredColumnCount = 2
			}
		}
	}
}