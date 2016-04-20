<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Daniel Lienert
 *
 *
 *  All rights reserved
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

namespace DL\Yag\ViewHelpers\CSS;

use DL\Yag\Utility\HeaderInclusion;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class implements a fake viewhelper to add a CSS file to the header
 *
 * @author     Daniel Lienert <typo3@lienert.cc>
 * @package    ViewHelpers
 * @subpackage Javascript
 *
 */
class IncludeViewHelper extends AbstractViewHelper {
    /**
     * @param string $library
     * @param string $file
     */
    public function render( $library = '', $file = '' ) {
        $headerInclusion = $this->objectManager->get( 'DL\\Yag\\Utility\\HeaderInclusion' );
        /* @var $headerInclusion  HeaderInclusion */

        if ( $library ) {
            $headerInclusion->addDefinedLibCSS( $library );
        }

        if ( $file ) {
            $headerInclusion->addCSSFile( $file );
        }
    }
}
