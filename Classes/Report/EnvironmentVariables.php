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

namespace DL\Yag\Report;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Reports\Status;
use TYPO3\CMS\Reports\StatusProviderInterface;

/**
 * Class implements a status report checking environment variables
 *
 * @author  Michael Knoll
 * @package Report
 */
class EnvironmentVariables implements StatusProviderInterface {
    protected $reports = array();

    /**
     * Returns status of filesystem
     *
     * @return    array    An array of \TYPO3\CMS\Reports\Status objects
     */
    public function getStatus() {
        $this->reports = array();
        $this->checkPostSize();

        return $this->reports;
    }


    /**
     * Checks whether post_max_size
     *
     * @return void
     */
    protected function checkPostSize() {
        if ( $this->returnBytes( ini_get( 'post_max_size' ) ) < $this->returnBytes( ini_get( 'upload_max_filesize' ) ) ) {
            $this->reports[] = GeneralUtility::makeInstance( 'TYPO3\\CMS\\Reports\\Status',
                'Environment Variables',
                GeneralUtility::formatSize( $this->returnBytes( ini_get( 'post_max_size' ) ) ),
                'Your post_max_size value (' . ini_get( 'post_max_size' ) . ')  is smaller than upload_max_filesize (' . ini_get( 'upload_max_filesize' ) . '). This might lead to problems when uploading ZIP files or big images!',
                Status::WARNING
            );
        } else {
            $this->reports[] = GeneralUtility::makeInstance( 'TYPO3\\CMS\\Reports\\Status',
                'Environment Variables',
                GeneralUtility::formatSize( $this->returnBytes( ini_get( 'post_max_size' ) ) ),
                'Your post_max_size value (' . ini_get( 'post_max_size' ) . ') is equal or bigger than upload_max_filesize (' . ini_get( 'upload_max_filesize' ) . ')',
                Status::OK
            );
        }
    }


    protected function returnBytes( $val ) {
        $val  = trim( $val );
        $last = strtolower( $val[ strlen( $val ) - 1 ] );
        switch ( $last ) {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }

        return $val;
    }
}
