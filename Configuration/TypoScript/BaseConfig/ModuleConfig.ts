#
# Some miscellaneous settings
#
plugin.tx_yag.settings {

	crawler {
        fileTypes = .jpg,.jpeg
    }

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