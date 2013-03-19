###################################################
# Typoscript template for adding required
# Javascript and CSS files.
# 
# @author Michael Knoll <mimi@kaktusteam.de>
# @author Daniel Lienert <daniel@lienert.cc>
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
	
	jQueryFancybox {
		include = {$config.yag.addFancyBox}
		includeJS.jqueryFancyBox  =  EXT:yag/Resources/Public/Js/JQuery/Fancybox/jquery.fancybox-1.3.4.pack.js
		includeJS.jqueryMouseWheel  =  EXT:yag/Resources/Public/Js/JQuery/Fancybox/jquery.mousewheel-3.0.4.pack.js
		includeJS.jqueryEasing  =  EXT:yag/Resources/Public/Js/JQuery/Fancybox/jquery.easing-1.3.pack.js

		includeCSS.jqueryFancybox =  EXT:yag/Resources/Public/Js/JQuery/Fancybox/jquery.fancybox-1.3.4.css
		includeCSS.yagFancybox=  EXT:yag/Resources/Public/CSS/Fancybox.css
	}
}
