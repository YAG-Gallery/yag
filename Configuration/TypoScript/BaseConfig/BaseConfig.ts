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


		# Upload Settings
		# =========================

		upload {
			multiFile {
				available = 1
				file_size_limit = 1000 MB
				file_upload_limit = 1000
				file_types = *.jpg;*.jpeg;*.JPG;*.JPEG;*.gif;*.png
				button_image_url = Icons/XPButtonUploadText_61x22.png
			}

			dragNDrop {
				available = 1
				file_upload_limit = 100
				file_size_limit = 5
			}

			zipUpload {
				available = 1
			}

			directory {
				available = 1
			}
		}


		# Importer
		# =========================

		importer {

			# Extract Item Meta data from JPEG files
			parseItemMeta = 1

			generateTagsFromMetaData = 1

			# While importing set the title in this format.
			# Provided Keywords:
			#
			# If uploaded or imported from disk
			# 	origFileName - the original filename of the import file
			# 	fileName - Formated filename (suffix removed)
			#
			# If parseItemMeta is activated
			#	author, copyright, artistMail, artistWebsite, description, tags, ...
			titleFormat = TEXT
			titleFormat.dataWrap = {field:fileName}


			# Set the description automatically from meta data
			descriptionFormat = TEXT
			descriptionFormat.dataWrap = {field:description}


			# Generate the resolutions for this template by default
			generateResolutions = backend

			# Write the files with this fileMask to disk
			importFileMask = 660
		}

		# Processor
        # =========================

		imageProcessor {

			# meaningfulTempFilePrefix specifies the length of the chunk of the original filename which is prefixed to the temp filename
			#meaningfulTempFilePrefix < config.meaningfulTempFilePrefix
			meaningfulTempFilePrefix = 100
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