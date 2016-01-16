####################################################
# YAG Basic configuration 
# Configuration for yag gallery 
#
# @author Daniel Lienert <typo3@lienert.cc>
# @author Michael Knoll <mimi@kaktusteam.de.de>
# @package YAG
# @subpackage Typoscript
####################################################


config.tx_yag {

	settings {


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
				file_size_limit = 10
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

			# Define which file extensions are supported
			supportedFileTypes = jpg,jpeg,gif,png


			# Extract Item Meta data from JPEG files
			parseItemMeta = 1


			generateTagsFromMetaData = 1

			# While importing set the title in this format.
			# Provided Keywords:
			#
			# If uploaded or imported from disk
			# 	origFileName - the original filename of the import file
			# 	fileName - Formatted filename (suffix removed)
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
			importFileMask = 664
		}

		# Processor
        # =========================

		imageProcessor {

			# meaningfulTempFilePrefix specifies the length of the chunk of the original filename which is prefixed to the temp filename
			meaningfulTempFilePrefix = 100
		}


		# General Behavior
        # =========================

		behavior {

			# Defines the plugin modes, where filters without a value given are not deactivated
			strictFilterPluginModes {
				Gallery_list 		= 1
				Gallery_showSingle 	= 1
				Album_showSingle	= 1
			}

		}


		# Custom Meta Data
		# Example defines a field "people" to name the people visible on the picture
		# ==========================================================================
		customMetaData {
		#	people {
		#		title = People
		#		type = string
		#	}
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
