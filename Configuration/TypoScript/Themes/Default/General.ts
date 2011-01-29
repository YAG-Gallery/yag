####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

page.includeCSS {
<<<<<<< HEAD
	theme = typo3conf/ext/yag/Resources/Public/CSS/theme.css
=======
	yag_theme_default = typo3conf/ext/yag/Resources/Public/CSS/theme.css
>>>>>>> 763010c0c4545c3bda2dd9b68f3df4aa15a801c0
}

plugin.tx_yag.settings.themes.default {
	resolutionConfigs {
		thumb {
<<<<<<< HEAD
			width = 150
			height = 
=======
		    ## Think about configuration that respects the image ratio and gives us 
		    ## the same height for every image but different widths
		    ## Problem: different cameras have different ratios, so let's say, we
		    ## have an album with mixed 3/2 ratio and 150/113 ratio. Then
		    ## we should be able to tell the resizing processor, that we want
		    ## our thumbs to be rendered at the same height, no matter what's the
		    ## width in this case.
		    
		    ## Another thing we should make configurable is cropping the images to a
		    ## quadratic size.
			width = 150
			height = 113
>>>>>>> 763010c0c4545c3bda2dd9b68f3df4aa15a801c0
			quality = 
		}
		
		medium {
			width = 800
<<<<<<< HEAD
=======
			height = 600
>>>>>>> 763010c0c4545c3bda2dd9b68f3df4aa15a801c0
		}
	}
}