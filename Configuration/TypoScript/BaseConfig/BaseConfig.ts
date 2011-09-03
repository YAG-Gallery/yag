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
			Tx_Yag_Domain_Model_Extern_TTContent {
                mapping {
                    tableName = tt_content
                    columns {
                        lockToDomain.mapOnProperty = lockToDomain
                    }
                }
            }
        }
    }
}


#
# Basic ajax pagetype
#
YAGJSON = PAGE
YAGJSON {
	# typeNum = "YAG" in ASCII
	typeNum = 896571
	config {
		disableAllHeaderCode = 1
		xhtml_cleaning = 0
		admPanel = 0
	    debug = 0
	    no_cache = 1
		additionalHeaders = Content-type:application/json
	}
}



#
# Basic XML pagetype
#
YAGXML = PAGE
YAGXML {
	typeNum = 896572
	config {
		disableAllHeaderCode = 1
		additionalHeaders = Content-type:text/xml
		xhtml_cleaning = 0
		admPanel = 0
	    debug = 0
	    no_cache = 1
	}
}



# XML Image List Export
YAGXML_ItemList < YAGXML
YAGXML_ItemList {
	typeNum = 89657201
	10 < tt_content.list.20.yag_xmllist
}



#
# Some miscellaneous settings
#
plugin.tx_yag.settings {
    
	crawler {
        fileTypes = .jpg,.jpeg
    }
	
	importer {
		parseItemMeta = 0
		generateTagsFromMetaData = 0
		importFileMask = 660
	}

	# Set access denied controller and action
    # This is used, whenever access was not granted
    accessDenied {
        controller = Gallery
        action = list
    }
	
	# Set default theme, can be overwritten by flexform
	theme = default
}