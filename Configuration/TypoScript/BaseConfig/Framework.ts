####################################################
# YAG Basic configuration
# Configuration for yag gallery
#
# @author Daniel Lienert <daniel@lienert.cc>
# @author Michael Knoll <mimi@kaktusteam.de.de>
# @package YAG
# @subpackage Typoscript
####################################################

# Configure fe user and fe group for extbase (no longer part of extbase configuration)
# TODO: Use storage pid!
config.tx_extbase {
    persistence{
        storagePid = 0
        enableAutomaticCacheClearing = 1
        updateReferenceIndex = 0
        classes {
            Tx_Extbase_Domain_Model_FrontendUser {
                mapping {
                    tableName = fe_users
                    recordType >
                    columns {
                        lockToDomain.mapOnProperty = lockToDomain
                    }
                }
            }
            Tx_Extbase_Domain_Model_FrontendUserGroup {
                mapping {
                    tableName = fe_groups
                    recordType >
                    columns {
                        lockToDomain.mapOnProperty = lockToDomain
                    }
                }
            }
			Tx_Yag_Domain_Model_Extern_TTContent {
                mapping {
                    tableName = tt_content
                    recordType >
                    columns {
                        lockToDomain.mapOnProperty = lockToDomain
                    }
                }
            }
			Tx_PtExtbase_Domain_Model_Page {
				mapping {
					tableName = pages
					columns {
						lockToDomain.mapOnProperty = lockToDomain
					}
				}
			}
        }
    }

    # Object manager configuration for Dependency Injection
    objects {
    	Tx_Extbase_Persistence_BackendInterface.className = Tx_Yag_Extbase_Persistence_Backend
    	Tx_PtExtbase_Rbac_RbacServiceInterface.className = Tx_PtExtbase_Rbac_TypoScriptRbacService
    }
}