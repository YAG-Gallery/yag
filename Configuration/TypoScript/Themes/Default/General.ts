####################################################
# Extlist configuration of the album 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

page.includeCSS {
	theme = typo3conf/ext/yag/Resources/Public/CSS/theme.css
}

plugin.tx_yag.settings.themes.default {
	resolutionConfigs {
		thumb {
			width = 150
			height = 
			quality = 
		}
		
		medium {
			width = 800
		}
	}
}