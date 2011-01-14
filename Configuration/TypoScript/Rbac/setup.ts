####################################################
# RBAC (Role-Based Access Controll) 
# Configuration for yag gallery 
#
# @author Daniel Lienert <daniel@lienert.cc> 
# @author Michael Knoll <mimi@kaktusteam.de.de>
# @package YAG
# @subpackage Typoscript
####################################################


plugin.tx_rbac.settings.extSettings.yag {
	
	
	####################################################
	# Set up roles that can be assigned to fe_users
	####################################################
	roles {
	
		administrator {
			description = Role for all administrators having full access to all functions on all objects
			privileges {
				10 {
					privilege = all_actions
					domain = tx_yag_all_objects	
					isAllowed = 1
					importance = 100
				}
			}


		}	
		
		loggedInUser {
			description = Role for all logged in users
			privileges {
				10 {
					privilege = create
					domain = tx_yag_comments
					isAllowed = 1
					importance = 10
				}
			}
		}
		
		guest {
			description = Role for all guests visiting gallery
			privileges {
				view_action {
					domain = tx_yag_all_objects	
					isAllowed = 1
					importance = 0
				}
			}
		}
		
	}
	
	
	
	####################################################
	# Set up privileges that can be assigned to roles
	# for a certain domain
	####################################################
	privileges {
		
		all_actions {
			actions = view, create, update, delete, sort
			isSingular = 0
		}
	
		create {
			actions = create	
			isSingular = 1
		}
		
	}
	
	
	
	####################################################
	# Set up actions that can be combined to privileges
	####################################################
	actions {
		
		view {
			description = View action	
		}
		
		create {
			description = Create action	
		}
		
		update {
			description = Update action	
		}
		
		delete {
			description = Delete action	
		}
		
		sort {
			description = Sort action
		}
		
	}
	
	
	
	####################################################
	# Set up domains that roles can be defined upon
	####################################################	
	domain {
		
		tx_yag_all_objects {
			isSingular = false
			objects = Album, Gallery, Item, ItemMeta
		}
		
		tx_yag_album {
			isSingular = true
			objects = Album
		}
		
		tx_yag_gallery {
			isSingular = true
			objects = Gallery 
		}
		
		tx_yag_item {
			isSingular = true
			objects = Item
		}
		
		tx_yag_itemMeta {
			isSingular = true
			objects = ItemMeta
		}
		
		tx_yag_comment {
			isSingular = true
			objects = Comment	
		}
		
	}
	
	/** 
	 * Idee hier: Statt "Objects" nennen wir das hier "Classes", damit ist klar, dass
	 * Rechte für eine Schablone, also eine Klasse vergeben werden. Für Rechte auf
	 * Instanzen dieser Schablone - also den konkreten Objekten benutzen wir statt dessen
	 * einen neuen Namensraum "objects", der per UID und Klasse auf eine konkrete 
	 * Ausprägung einer solchen Schablone verweist. 
	 * 
	 * Damit wäre es möglich auch auf Instanzebene entsprechende Rechte zu vergeben.
	 */
	####################################################
	# Set up objects that can be combined to domains
	####################################################	
	objects {
		
		Album {
			description = Album class in yag	
		}
		
		Gallery {
			description = Gallery class in yag
		}
		
		Item {
			description = Item class in yag
		}
		
		ItemMeta {
			description = ItemMeta class in yag
		}
		
		Comment {
			description = Comment class in yag
		}
		
	}	
	
}	