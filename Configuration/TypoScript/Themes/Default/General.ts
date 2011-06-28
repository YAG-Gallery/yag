####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.default {
	
	## Show the breadcrumb header
	showBreadcrumbs = 1
	
	
	## Define the resolutions 
    resolutionConfigs {
 		thumb {
    		maxW = 150
    		maxH = 150
    	}
    	
    	galleryThumb < plugin.tx_yag.settings.themes.default.resolutionConfigs.thumb
    	
    	albumThumb < plugin.tx_yag.settings.themes.default.resolutionConfigs.thumb

    	medium {
    		maxW = 800
    		maxH = 600
    	}
    }
	
	
	## include CSS/JS from defined libraries. SEE: BaseConfig/HeaderInclusion
	includeLibJS = 
	includeLibCSS = 
	
	## Define JS Files to include. 
	includeJS {
	}
	
	## Definde CSS Files to include.
	includeCSS {
		yag_theme_default = EXT:yag/Resources/Public/CSS/theme.css
	}
}
