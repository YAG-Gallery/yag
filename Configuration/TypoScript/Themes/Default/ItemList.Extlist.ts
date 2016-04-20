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

	    dataBackendClass = DL\Yag\Extlist\DataBackend\YagDataBackend
		repositoryClassName = DL\Yag\Domain\Repository\ItemRepository
		
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
					filterClassName = DL\Yag\Extlist\Filter\GalleryFilter
					filterIdentifier = galleryFilter
					fieldIdentifier = album
				}

				20 {
					partialPath = noPartialNeeded
					filterClassName = DL\Yag\Extlist\Filter\AlbumFilter
					filterIdentifier = albumFilter
					fieldIdentifier = album
				}

				30 {
					partialPath = noPartialNeeded
					filterClassName = DL\Yag\Extlist\Filter\RandomUidFilter
					filterIdentifier = randomUidFilter
					fieldIdentifier = uid
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