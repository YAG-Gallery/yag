<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2014 Daniel Lienert <typo3@lienert.cc>
*  All rights reserved
*
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Class implements a viewhelper for rendering a link to a gallery
 *
 * @package ViewHelpers
 * @author Daniel Lienert <typo3@lienert.cc>
 */
class Tx_Yag_ViewHelpers_Link_GalleryViewHelper extends Tx_PtExtlist_ViewHelpers_Link_ActionViewHelper
{
    /**
     * Renders link for an album
     *
     * @param int $galleryUid UID of album to render link for
     * @param Tx_Yag_Domain_Model_Gallery $gallery Album object to render link for
     * @param int $pageUid (Optional) ID of page to render link for. If null, current page is used
     * @param int $pageType
     * @param bool $noCache
     * @param bool $noCacheHash
     * @param string $section
     * @param string $format
     * @throws Exception
     * @return string Rendered link for gallery
     *
     */
    public function render($galleryUid = null, Tx_Yag_Domain_Model_Gallery $gallery = null, $pageUid = null, $pageType = 0, $noCache = false, $noCacheHash = false, $section = '', $format = '')
    {
        if ($galleryUid === null && $gallery === null) {
            throw new Exception('You have to set "galleryUid" or "gallery" as parameter. Both parameters can not be empty when using galleryLinkViewHelper', 1295575455);
        }
        if ($galleryUid === null) {
            $galleryUid = $gallery->getUid();
        }

        $namespace = Tx_Yag_Domain_Context_YagContextFactory::getInstance()->getObjectNamespace() . '.galleryUid';
        $arguments = Tx_PtExtbase_Utility_NameSpace::saveDataInNamespaceTree($namespace, array(), $galleryUid);

        return parent::render('index', $arguments, 'Gallery', null, null, $pageUid, $pageType, $noCache, $noCacheHash, $section, $format);
    }
}
