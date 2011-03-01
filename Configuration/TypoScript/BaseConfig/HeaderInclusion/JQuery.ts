###################################################
# Typoscript template for adding required
# Javascript and CSS files.
# 
# @author Michael Knoll <mimi@kaktusteam.de>
# @author Daniel Lienert <daniel@lienert.cc>
##################################################


[globalVar = LIT:1 = {$config.yag.addjQuery}]
	page {
		includeJS.jquery_min =  EXT:yag/Resources/Public/Js/JQuery/jquery-1.5.1.min.js
		
		includeCSS.jquery_base =  EXT:yag/Resources/Public/CSS/JQuery/base.css
	}
[global]

[globalVar = LIT:1 = {$config.yag.addjQueryUi}]
	
		includeJS.jqueryUi_custom  =  EXT:yag/Resources/Public/Js/JQuery/jquery-ui-1.8.10.custom.min.js

		includeCSS.jqueryUi_custom =  EXT:yag/Resources/Public/CSS/JQuery/ui-lightness/jquery-ui-1.8.7.custom.css
	}
[global]

[globalVar = LIT:1 = {$config.yag.addShaddowBox}]
	page {
		includeJS.jqueryUi_shadowbox  =  EXT:yag/Resources/Public/Js/JQuery/shadowbox.js
		includeJS.jqueryUi_Lightbox = EXT:yag/Resources/Public/Js/shadowbox_init.js
		
		includeCSS.jquery_shadowbox =  EXT:yag/Resources/Public/CSS/shadowbox.css
	]
[global]
