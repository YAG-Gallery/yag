####################################################
# Theme configuration root 
#
# @author Daniel Lienert <daniel@lienert.cc> Michael Knoll <knoll@punkt.de>
# @package YAG
# @subpackage Typoscript
####################################################

# Include General theme configuration
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Backend/General.ts">

# Include Gallery Definitions
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Backend/Gallery.ts">

# Include Album Definitions
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Backend/Album.ts">

# Include Gallery ExtList Definitions
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Backend/Gallery.Extlist.ts">

# Include Album ExtList Definitions
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Backend/Album.Extlist.ts">

# Include ImageList Definitions
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Backend/ItemList.ts">

# Include ImageList ExtList Definitions
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Backend/ItemList.Extlist.ts">

# Include SingleView Definitions
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:yag/Configuration/TypoScript/Themes/Backend/SingleView.ts">

<INCLUDE_TYPOSCRIPT: source="FILE:EXT:pt_extlist/Configuration/TypoScript/Themes/Default/plugin.tx_ptextlist._CSS_DEFAULT_STYLE.ts">