<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2013 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktsuteam.de>
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
 * Configuration for image processor
 *
 * @package Domain
 * @subpackage Configuration\ImageProcessing
 * @author Daniel Lienert <daniel@lienert.cc>
 * @author Michael Knoll <mimi@kaktsuteam.de>
 */
class Tx_Yag_Domain_Configuration_ImageProcessing_ImageProcessorConfiguration extends Tx_PtExtbase_Configuration_AbstractConfiguration {
	
	/**
	 * Holds path for temporary storing image files
	 *
	 * @var string
	 */
	protected $tempPath;


	/**
	 * @var integer
	 */
	protected $meaningfulTempFilePrefix = 0;

	
	/**
	 * Initializes properties
	 */
	protected function init() {
		$this->setValueIfExists('meaningfulTempFilePrefix');
		// $this->setRequiredValue('tempPath', 'Temp path is not set in image processor settings (imageProcessor.tempPath) 1287592937');
	}
	
	
	
	/**
	 * Returns temp path for image processing
	 *
	 * @return string
	 */
	public function getTempPath() {
		return $this->tempPath;
	}


	/**
	 * @return int
	 */
	public function getMeaningfulTempFilePrefix() {
		return (int) $this->meaningfulTempFilePrefix;
	}
}

?>