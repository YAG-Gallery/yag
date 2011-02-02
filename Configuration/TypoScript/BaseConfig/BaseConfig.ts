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
                    columns {
                        lockToDomain.mapOnProperty = lockToDomain
                    }
                }
            }
            Tx_Extbase_Domain_Model_FrontendUserGroup {
                mapping {
                    tableName = fe_groups
                    columns {
                        lockToDomain.mapOnProperty = lockToDomain
                    }
                }
            }
        }
    }
}


plugin.tx_yag.settings {
    crawler {
        fileTypes = jpg,jpeg
    }

	# Set access denied controller and action
    # This is used, whenever access was not granted
    accessDenied {
        controller = Gallery
        action = list
    }

}