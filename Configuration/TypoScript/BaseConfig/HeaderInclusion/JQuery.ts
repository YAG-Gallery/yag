###################################################
# Typoscript template for adding required
# Javascript and CSS files.
# 
# @author Michael Knoll <mimi@kaktusteam.de>
# @author Daniel Lienert <daniel@lienert.cc>
##################################################

page.includeJS {
	jquery_min =  EXT:yag/Resources/Public/Js/JQuery/jquery-1.4.4.min.js
	jqueryUi_custom  =  EXT:yag/Resources/Public/Js/JQuery/jquery-ui-1.8.7.custom.min.js
	jqueryUi_shadowbox  =  EXT:yag/Resources/Public/Js/JQuery/shadowbox.js
	jqueryUi_Lightbox = EXT:yag/Resources/Public/Js/shadowbox_init.js
}

page.includeCSS {
	jquery_base =  EXT:yag/Resources/Public/CSS/JQuery/base.css
	jqueryUi_custom =  EXT:yag/Resources/Public/CSS/JQuery/ui-lightness/jquery-ui-1.8.7.custom.css
	jquery_shadowbox =  EXT:yag/Resources/Public/CSS/shadowbox.css
	jquery_base =  EXT:yag/Resources/Public/CSS/JQuery/
}