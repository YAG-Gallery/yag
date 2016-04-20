####################################################
# Extlist configuration for showing all albums
# of a gallery in a list 
#
# @author Daniel Lienert <typo3@lienert.cc>
# @author Michael Knoll <mimi@kaktusteam.de.de>
# @package YAG
# @subpackage Typoscript
####################################################

module.tx_yag.settings.themes.backend.extlist.albumList {

	backendConfig < module.tx_ptextlist.prototype.backend.extbase
	backendConfig {

		respectStoragePage = 1
	
		repositoryClassName = DL\Yag\Domain\Repository\AlbumRepository
		
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
                  filterClassName = DL\Yag\Extlist\Filter\GalleryFilter
                  filterIdentifier = galleryFilter

                  ## fieldIdentifier is not used but must be set to existing field!
                  fieldIdentifier = gallery

                  hideHidden = 0
                }
            }
        }
    }
	
	
	pager {
		itemsPerPage = 16
	}
}