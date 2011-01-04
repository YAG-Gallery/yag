####################################################
# Extlist configuration of the gallery 
#
# @author Daniel Lienert <daniel@lienert.cc> 
# @author Michael Knoll <mimi@kaktusteam.de.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.default.gallery.extlist {
	backendConfig < plugin.tx_ptextlist.prototype.backend.extbase
	backendConfig {
	
		repositoryClassName = Tx_Yag_Domain_Repository_AlbumRepository
	
	}

	fields {
		album {
			table = __self__
			field = __object__
		}
	}

	columns {
		10 {
			fieldIdentifier = album
			columnIdentifier = album
			label = Album
			renderTemplate = EXT:yag/Resources/Private/Partials/AlbumThumb.html
		}
	}
	
	pager {
		itemsPerPage = 6
	}
	
	#filters {
#		internalFilters {
#			filterConfigs {
#				10 {
#					filterIdentifier = filter1
#					label = LLL:EXT:pt_extlist/Configuration/TypoScript/Demolist/locallang.xml:filter_nameField
#					fieldIdentifier = name_local
#				}
#			}
#		}
#	}
}