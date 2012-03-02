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
###################################################


plugin.tx_yag.settings {
    ## This overwrites template for controller ItemList and lis Action used to render albums
    controller.ItemList.list.template = EXT:yag/Resources/Private/Templates/Album/ShowWithLightbox.html
    itemList {
        itemsPerPage = 0
        columnCount = 2
    
		## Set partial used for rendering an image thumbnail inside itemList
		imageThumbPartial = LightboxImageThumb

    }
}

## Include lightbox javascript
## (Make sure to have the corresponding files in your fileadmin/jquery folder)
page.includeJS = COA
page.includeJS {
    file0 = fileadmin/jquery/js/jquery-1.5.1.min.js
        file1 = fileadmin/jquery/js/shadowbox.js
        file2 = typo3conf/ext/yag/Resources/Public/Js/shadowbox_init.js
} 

## Include lightbox CSS
page.includeCSS = COA
page.includeCSS { 
    file1 = typo3conf/ext/yag/Resources/Public/CSS/shadowbox.css
    file1.media = all
}