###################################################
# Typoscript template for adding required
# Javascript and CSS files.
# 
# @author Michael Knoll <mimi@kaktusteam.de>
# @author Daniel Lienert <typo3@lienert.cc>
##################################################

config.tx_yag.settings.frontendLib {
	
	jQuery {
		include = {$config.yag.addjQuery}
		includeJS.jQuery  = EXT:yag/Resources/Public/Js/JQuery/jquery-1.8.3.min.js
		# includeCSS.jQuery = EXT:yag/Resources/Public/CSS/JQuery/base.css
	}
	
	jQueryUi {
		include = {$config.yag.addjQueryUi}
		includeJS.jqueryUi  = EXT:yag/Resources/Public/Js/JQuery/jquery-ui-1.8.10.custom.min.js
		includeCSS.jqueryUi = EXT:yag/Resources/Public/CSS/JQuery/ui-lightness/jquery-ui-1.8.7.custom.css
	}
	
	lightBox {
		include = {$config.yag.addLightBox}

		includeJS.magnificLightBox = EXT:yag/Resources/Public/Js/MagnificPopup/dist/jquery.magnific-popup.min.js

		includeCSS.magnificLightBox = EXT:yag/Resources/Public/Js/MagnificPopup/dist/magnific-popup.css
        includeCSS.yagLightBox = EXT:yag/Resources/Public/CSS/Lightbox.css
	}
}
