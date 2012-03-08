#
# Some miscellaneous settings
#
plugin.tx_yag.settings {

	# Set access denied controller and action
    # This is used, whenever access was not granted
    accessDenied {
        controller = Gallery
        action = list
    }

	# Set default theme, can be overwritten by flexform
	theme = default
}