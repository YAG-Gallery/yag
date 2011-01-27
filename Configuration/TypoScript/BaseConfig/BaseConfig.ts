####################################################
# YAG Basic configuration 
# Configuration for yag gallery 
#
# @author Daniel Lienert <daniel@lienert.cc> 
# @author Michael Knoll <mimi@kaktusteam.de.de>
# @package YAG
# @subpackage Typoscript
####################################################


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