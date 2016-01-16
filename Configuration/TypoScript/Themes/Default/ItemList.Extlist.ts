####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <typo3@lienert.cc>
# @author Michael Knoll <mimi@kaktusteam.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.default.extlist.itemList {

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

		uid {
			table = __self__
			field = uid
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
					filterClassName = Tx_Yag_Extlist_Filter_GalleryFilter
					filterIdentifier = galleryFilter
					fieldIdentifier = album
				}

				20 {
					partialPath = noPartialNeeded
					filterClassName = Tx_Yag_Extlist_Filter_AlbumFilter
					filterIdentifier = albumFilter
					fieldIdentifier = album
				}

				30 {
					partialPath = noPartialNeeded
					filterClassName = Tx_Yag_Extlist_Filter_RandomUidFilter
					filterIdentifier = randomUidFilter
					fieldIdentifier = uid
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