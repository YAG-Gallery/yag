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
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class implements a status report checking external libraries used in YAG.
 *
 * @author Michael Knoll
 * @package Report
 */
class Tx_Yag_Report_ExternalLibraries implements \TYPO3\CMS\Reports\StatusProviderInterface
{
    protected $reports = array();

    /**
     * Returns status of external libraries used within YAG
     *
     * @return    array    An array of \TYPO3\CMS\Reports\Status objects
     */
    public function getStatus()
    {
        $this->reports = array();
        $this->checkExifReadData();

        return $this->reports;
    }


    /**
     * Checks whether exif_read_data() is available on current system
     *
     * @return void
     */
    protected function checkExifReadData()
    {
        if (function_exists('exif_read_data')) {
            $status = GeneralUtility::makeInstance('TYPO3\\CMS\\Reports\\Status',
                'External Libraries',
                'exif_read_data() available',
                'Function exif_read_data() is available on your system!',
                \TYPO3\CMS\Reports\Status::OK
            );
        } else {
            $status = GeneralUtility::makeInstance('TYPO3\\CMS\\Reports\\Status',
                'External Libraries',
                'exif_read_data() not available',
                'Function exif_read_data() is NOT available on your system!',
                \TYPO3\CMS\Reports\Status::WARNING
            );
        }
        $this->reports[] = $status;
    }
}
