# YAG Basic configuration
# Configuration for yag gallery
#
# @author Daniel Lienert <daniel@lienert.cc>
# @author Michael Knoll <mimi@kaktusteam.de.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_ptextbase.settings.rbac {

 	## We should be able to set up rbac privileges for
 	## multiple extensions, hence we need namespace for each extension here
 	extensions {

 		yag {

 			## We define objects and corresponding actions since we later
 			## want to define rules like
 			## "role A is granted all privileges on object B" via B.*
 			## which we can only do by defining objects and actions first,
 			## what might seem to be redundant on first sight.
 			objects {

 				album {
 					actions {
 						10 = create
 						20 = delete
 						30 = edit
 					}
 				}


 				gallery {
 					actions {
 						10 = create
 						20 = delete
 						30 = edit
 					}
 				}


 				item {
 					actions {
 						10 = create
 						20 = delete
 						30 = edit
 					}
 				}
 			}



 			## Roles can combine privileges on arbitrary objects with arbitrary actions.
 			## Use "*" as wildcard for all actions which are defined on an object.
 			roles {

 				admin {
 					privileges {
 						10 = album.*
 						20 = gallery.*
 						30 = item.*
 					}
 				}


 				editor {
 					privileges {
 						10 = album.create
 						11 = album.edit

 						20 = gallery.create
 						21 = gallery.edit

 						30 = item.create
 						31 = item.edit
 					}
 				}


 				albumManager {
 					privileges {
 						10 = album.*
 					}
 				}


 				galleryManager {
 					privileges {
 						10 = gallery.*
 					}
 				}


 				itemManager {
 					privileges {
 						10 = item.*
 					}
 				}

 			}



 			## RBAC service can be used in frontend and in backend environment,
 			## but we have different UIDs for user groups so we need to define
 			## privileges for frontend and backend separately
 			feGroups {

				# Do the group <=> role asignement here
				# <groupUid> {
				#  10 = <ROLENAME>
				#  20 = <AnotherRoleName>
				# }

 				#1 {
 				#	10 = admin
 				#}

 			}



 			beGroups {

 				## Use this, if backend users should be able to do everything
 				__grantAllPrivileges = 1

 			}

 		}

 	}

}