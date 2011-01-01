####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.default.album.extlist {
	backendConfig < plugin.tx_ptextlist.prototype.backend.extbase
	backendConfig {
	
		repositoryClassName = Tx_Yag_Domain_Repository_ItemRepository
	
	}

	fields {
		image {
			table = __self__
			field = __object__
		}
	}

	columns {
		10 {
			fieldIdentifier = image
			columnIdentifier = image
			label = Image
			renderTemplate = EXT:yag/Resources/Private/Partials/Thumb.html
		}
	}
	
	pager {
		itemsPerPage = 12
	}
}