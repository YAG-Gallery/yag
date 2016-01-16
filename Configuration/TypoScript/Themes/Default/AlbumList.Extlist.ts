####################################################
# Extlist configuration for showing all albums
# of a gallery in a list 
#
# @author Daniel Lienert <typo3@lienert.cc>
# @author Michael Knoll <mimi@kaktusteam.de.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.default.extlist.albumList {

	backendConfig < plugin.tx_ptextlist.prototype.backend.extbase
	backendConfig {

		respectStoragePage = 1
	
		repositoryClassName = Tx_Yag_Domain_Repository_AlbumRepository
		
		sorting = sorting
	}

	
	fields {

		album {
			table = __self__
			field = __object__
		}

		gallery {
		    table = __self__
		    field = gallery
		}
		
	}
	

	columns {
		10 {
			fieldIdentifier = album
			columnIdentifier = album
			label = Album
		}
		
	}

    
    filters {
        internalFilters {
            filterConfigs {
                10 {
                    partialPath = noPartialNeeded
                    filterClassName = Tx_Yag_Extlist_Filter_GalleryFilter
                    filterIdentifier = galleryFilter
                    
					     ## fieldIdentifier is not used but must be set to existing field!
                    fieldIdentifier = gallery
                }
            }
        }
    }
	
	
	pager {
		itemsPerPage = 16
	}
}