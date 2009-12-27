<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Michael Knoll <mimi@kaktusteam.de>, MKLV GbR
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

/**
 * Class definition file of a class that converts images
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */


/**
 * Class for handling the convertion of images
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since  2009-12-25
 * @package Typo3
 * @subpackage yag
 */
class Tx_Yag_Lib_ConvertImagesHandler {

	/**
	 * Holds the path configuration for album
	 * @var Tx_Yag_Lib_AlbumPathConfiguration
	 */
	protected $albumPathConfiguration;
	
	
	
	/**
	 * Holds album to add images to
	 * @var Tx_Yag_Domain_Model
	 */
	protected $album;
	
	
	
	/**
	 * Returns a new instance of this class
	 *
	 * @param Tx_Yag_Domain_Model_Album $album     Album to add images to
	 * @param Tx_Yag_Lib_AlbumPathConfiguration $albumPathConfiguration Path configuration of album
	 * @return Tx_Yag_Lib_ConvertImagesHandler  New instance of this class
	 */
	public static function getInstanceByAlbumAndPathConfiguration(
	       Tx_Yag_Domain_Model_Album $album,
	       Tx_Yag_Lib_AlbumPathConfiguration $albumPathConfiguration) {
	   return new Tx_Yag_Lib_AddImagesToAlbumHandler($album, $albumPathConfiguration);
	}
	
	
	
	/**
	 * Constructor for this class (protected) use getInstance() methods instead!
	 *
	 * @param Tx_Yag_Domain_Model_Album $album     Album to add images to
	 * @param Tx_Yag_Lib_AlbumPathConfiguration $albumPathConfiguration   Path configuration of album
	 */
	protected function __construct(Tx_Yag_Domain_Model_Album $album, Tx_Yag_Lib_AlbumPathConfiguration $albumPathConfiguration) {
		$this->album = $album;
		$this->albumPathConfiguration = $albumPathConfiguration;
	}
	
	
	
	/**
	 * Resizes an image by a given resizing object
	 *
	 * @param Tx_Yag_Lib_ResizingParameter $parameter
	 * @return void
	 */
	public static function resizeImage(Tx_Yag_Lib_ResizingParameter $parameter) {
		Tx_Yag_Div_YagDiv::resizeImage(
		    $parameter->getWidth(),
		    $parameter->getHeight(),
		    $parameter->getQuality(),
		    $parameter->getSource(),
		    $parameter->getTarget()
		);
	}
	
	
	
	/**
	 * Resizes images described by an array of resizing objects
	 *
	 * @param array $resizingObjects    Array of resizing objects
	 */
	public static function resizeImages($resizingObjects) {
		foreach($resizingObjects as $resizingObject) {
			self::resizeImage($resizingObject);
		}
	}
	
}

?>
