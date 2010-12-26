plugin.tx_ptextlist.settings {

	listConfig.Theme_Default_Album {
	
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
				//renderTemplate = EXT:yag/Resources/Private/Partials/Image.html
			}
		}
		
		pager {
			itemsPerPage = 30
		}
	}
}