####################################################
# Theme configuration root 
#
# @author Daniel Lienert <typo3@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.lightbox < plugin.tx_yag.settings.themes.default

# Include General theme configuration
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Lightbox/General.ts">

# Include Gallery Definitions
#<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Backend/Gallery.ts">

# Include Album Definitions
#<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Default/Album.ts">

# Include Gallery ExtList Definitions
#<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Default/Gallery.Extlist.ts">

# Include Album ExtList Definitions
#<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Default/Album.Extlist.ts">

# Include ImageList Definitions
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Lightbox/ItemList.ts">

# Include ImageList ExtList Definitions
#<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Default/ItemList.Extlist.ts">

# Include SingleView Definitions
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Lightbox/Item.ts">

module.tx_yag.settings.themes.lightbox < plugin.tx_yag.settings.themes.lightbox