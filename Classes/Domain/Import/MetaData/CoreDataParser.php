<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2013 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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

namespace DL\Yag\Domain\Import\MetaData;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\CommandUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class for parsing the images core data
 *
 * @package    Domain
 * @subpackage Import\MetaData
 * @author     Daniel Lienert <typo3@lienert.cc>
 */
class CoreDataParser extends AbstractParser implements SingletonInterface {
    /**
     * @param $filePath
     *
     * @return array
     */
    public function parseCoreData( $filePath ) {
        $imageMagicCommand = GeneralUtility::imageMagickCommand( 'identify', '-verbose' );
        $imageMagicCommand .= ' ' . $filePath;
        CommandUtility::exec( $imageMagicCommand, $result );

        $data = array();
        foreach ( $result as $resultLine ) {
            $chunks                     = explode( ':', $resultLine );
            $data[ trim( $chunks[0] ) ] = trim( $chunks[1] );
        }

        return array(
            'colorSpace' => $this->parseColorSpace( $data ),
            'dpi'        => $this->parseDPI( $data ),
        );
    }


    /**
     * @param $data
     *
     * @return mixed
     */
    protected function parseColorSpace( $data ) {
        if ( array_key_exists( 'JPEG-Colorspace-Name', $data ) ) {
            return $data['JPEG-Colorspace-Name'];
        }
        if ( array_key_exists( 'Colorspace', $data ) ) {
            return $data['Colorspace'];
        }
    }


    /**
     * @param $data
     *
     * @return int
     */
    protected function parseDPI( $data ) {
        if ( array_key_exists( 'X Resolution', $data ) ) {
            if ( stristr( $data['X Resolution'], '/' ) ) {
                $resEquationParts = explode( '/', $data['X Resolution'] );

                return (int) $resEquationParts[0] / (int) $resEquationParts[1];
            } else {
                return (int) $data['X Resolution'];
            }
        }

        if ( array_key_exists( 'Resolution', $data ) ) {
            return (int) $data['Resolution'];
        }
    }
}
