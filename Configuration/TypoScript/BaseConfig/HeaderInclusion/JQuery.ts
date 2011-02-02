###################################################
# Here is a Typoscript sample that
# shows how to set up a configuration
# useful for rendering albums on a
# content page.
#
# You can copy and paste this code inside your
# page setup of TS template.
# 
# @author Michael Knoll <mimi@kaktusteam.de>
# @author Daniel Lienert <daniel@lienert.cc>
##################################################

page.includeJS {
	jquery_min =  EXT:yag/Resources/Public/Js/JQuery/jquery-1.4.4.min.js
	jqueryUi_custom  =  EXT:yag/Resources/Public/Js/JQuery/jquery-ui-1.8.7.custom.min.js
}

page.includeCSS {
	jquery_base =  EXT:yag/Resources/Public/CSS/JQuery/base.css
	jqueryUi_custom =  EXT:yag/Resources/Public/CSS/JQuery/ui-lightness/jquery-ui-1.8.7.custom.css
}