####################################################
# YAG Basic configuration
# Configuration for yag gallery
#
# @author Daniel Lienert <typo3@lienert.cc>
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
			DL\Yag\Domain\Model\Extern\TTContent {
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
		TYPO3\CMS\Extbase\Persistence\Generic\BackendInterface.className = DL\Yag\Extbase\Persistence\Backend
    }
}

/*
* This configuration is needed to achieve the behaviour of extbase 1.3.0 in extbase > 1.4.1
* concerning default controller/actions configured with switchableControllerActions.
*/
plugin.tx_yag {
	mvc.callDefaultActionIfActionCantBeResolved = 1

	view {
		layoutRootPath = {$plugin.tx_yag.view.layoutRootPath}
	}
}