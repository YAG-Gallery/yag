plugin.tx_ptextlist.settings {

	listConfig.Theme_Default_Album {
	
		backendConfig < plugin.tx_ptextlist.prototype.backend.extbase
		backendConfig {
		
			repositoryClassName = Tx_Yag_Domain_Repository_ItemRepository
		
		}

		fields {
			title {
				table = __self__
				field = __object__
			}
		}

		columns {
			10 {
				fieldIdentifier = title
				columnIdentifier = title
				label = Titel
			}
		}
		
		pager {
			itemsPerPage = 30
		}
	}
}