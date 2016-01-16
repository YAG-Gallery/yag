####################################################
# Theme configuration root 
#
# @author Daniel Lienert <typo3@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

# Include General theme configuration
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Default/General.ts">

# Include GalleryList Definitions
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Default/GalleryList.ts">

# Include GalleryList ExtList Definitions
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Default/GalleryList.Extlist.ts">

# Include AlbumList Definitions
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Default/AlbumList.ts">

# Include AlbumList ExtList Definitions
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Default/AlbumList.Extlist.ts">

# Include ImageList Definitions
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Default/ItemList.ts">

# Include ImageList ExtList Definitions
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Default/ItemList.Extlist.ts">

# Include SingleView Definitions
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Default/Item.ts">

module.tx_yag.settings.themes.default < plugin.tx_yag.settings.themes.default
