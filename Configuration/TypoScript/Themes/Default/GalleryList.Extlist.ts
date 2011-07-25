####################################################
# Extlist configuration for showing galleries
# in a list
#
# @author Daniel Lienert <daniel@lienert.cc> 
# @author Michael Knoll <mimi@kaktusteam.de.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.default.extlist.galleryList {
	backendConfig < plugin.tx_ptextlist.prototype.backend.extbase
	backendConfig {
	
		repositoryClassName = Tx_Yag_Domain_Repository_GalleryRepository
	   
	    sorting = sorting
	
	}

	
	fields {
		gallery {
			table = __self__
			field = __object__
		}
	}

	
	columns {
		10 {
			fieldIdentifier = gallery
			columnIdentifier = gallery
			label = Album
		}
	}
	
	
	pager {
		itemsPerPage = 16
	}
	
	
	filters {
        internalFilters {
            filterConfigs {
                10 {
                    partialPath = noPartialNeeded
                    filterClassName = Tx_Yag_Extlist_Filter_GalleryHideFilter
                    filterIdentifier = galleryHideFilter
                    
                    ## fieldIdentifier is not used but must be set to existing field!
                    fieldIdentifier = gallery
                    
                    hideHidden = 1
                }
            }
        }
    }
	
}