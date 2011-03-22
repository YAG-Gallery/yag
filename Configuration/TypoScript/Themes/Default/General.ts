####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.default {
	
	# Show the breadcrumb header
	showBreadcrumbs = 1
	
    resolutionConfigs {
 		thumb {
    		maxW = 150
    		maxH = 150
    	}

    	medium {
    		maxW = 800
    		maxH = 600
    	}
    }
	
	
	includeCSS {
		yag_theme_default = EXT:yag/Resources/Public/CSS/theme.css
	}
	
	includeJS {
	}
}