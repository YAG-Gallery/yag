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
		itemsPerPage = 10
	}
}