####################################################
# YAG Basic configuration 
# Configuration for yag gallery 
#
# @author Daniel Lienert <daniel@lienert.cc> 
# @author Michael Knoll <mimi@kaktusteam.de.de>
# @package YAG
# @subpackage Typoscript
####################################################


config.tx_yag {

	settings {
		# Crawler
		# =========================

		crawler {
			fileTypes = .jpg,.jpeg
		}


		# Importer
		# =========================

		importer {
			# Extract Item Meta data from JPEG files
			parseItemMeta = 1

			generateTagsFromMetaData = 1

			# Generate the resolutions for this template by default
			generateResolutions = backend

			# Write the files with this fileMask to disk
			importFileMask = 660
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