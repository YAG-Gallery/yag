###################################################
# Typoscript template for adding required
# Javascript and CSS files.
# 
# @author Michael Knoll <mimi@kaktusteam.de>
# @author Daniel Lienert <daniel@lienert.cc>
##################################################

plugin.tx_yag.settings.frontendLib {
	
	jQuery {
		include = {$config.yag.addjQuery}
		includeJS.jQuery  = EXT:yag/Resources/Public/Js/JQuery/jquery-1.5.1.min.js
		includeCSS.jQuery = EXT:yag/Resources/Public/CSS/JQuery/base.css
	}
	
	jQueryUi {
		include = {$config.yag.addjQueryUi}
		includeJS.jqueryUi  = EXT:yag/Resources/Public/Js/JQuery/jquery-ui-1.8.10.custom.min.js
		includeCSS.jqueryUi = EXT:yag/Resources/Public/CSS/JQuery/ui-lightness/jquery-ui-1.8.7.custom.css
	}
	
	jQueryShadowBox {
		include = {$config.yag.addShaddowBox}
		includeJS.jqueryUiShadowbox  =  EXT:yag/Resources/Public/Js/JQuery/shadowbox.js
		includeJS.jqueryUiLightbox = EXT:yag/Resources/Public/Js/shadowbox_init.js
		includeCSS.jqueryShadowbox =  EXT:yag/Resources/Public/CSS/shadowbox.css
	}
}
