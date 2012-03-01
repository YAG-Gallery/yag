####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

config.tx_yag.settings.themes.default {

	title = Default
	description = The YAG Gallery default theme.

	## Show the breadcrumb header
	showBreadcrumbs = 1
	
	
	## Define the resolutions 
    resolutionConfigs {
 		thumb {
    		maxW = 150
    		maxH = 150
    	}
    	
    	# Per default, gallery thumbs have the same size as item list thumbs.
    	# Feel free to override this, if you want to have a different resolution for gallery thumbs
    	galleryThumb < plugin.tx_yag.settings.themes.default.resolutionConfigs.thumb
    	
        # Per default, album thumbs have the same size as item list thumbs.
        # Feel free to override this, if you want to have a different resolution for album thumbs
    	albumThumb < plugin.tx_yag.settings.themes.default.resolutionConfigs.thumb

    	medium {
    		maxW = 800
    		maxH = 600
    	}


        ## Comment out this line, if you want to have random single images the same size as medium format
    	#randomSingle < plugin.tx_yag.settings.themes.default.resolutionConfigs.medium

    	# We crop images width a side-length of 200px for single random view. Mind the "width" and "height" instead of
    	# "maxW" and "maxH" for cropping!
    	randomSingle {
    	    width = 200c
    	    height = 200c
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
