<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <knoll@punkt.de>
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
 * Class provides dataProvider for FlexForm select lists
 * 
 * @author Daniel Lienert <daniel@lienert.cc>
 * @package Utility
 */

class user_Tx_Yag_Utility_Flexform_FlexformRenderFunctions {
	
	/**
	 * Get a list of albums
	 * 
	 * @param array $config
	 * @return array $config
	 */
	public function renderAlbumFields(&$PA, &$fobj) {
		
		
		$GLOBALS['trace'] = 1;	trace($fobj ,0,'Quick Trace in file ' . basename( __FILE__) . ' : ' . __CLASS__ . '->' . __FUNCTION__ . ' @ Line : ' . __LINE__ . ' @ Date : '   . date('H:i:s'));	$GLOBALS['trace'] = 0; // RY25 TODO Remove me
		$GLOBALS['trace'] = 1;	trace($PA ,0,'Quick Trace in file ' . basename( __FILE__) . ' : ' . __CLASS__ . '->' . __FUNCTION__ . ' @ Line : ' . __LINE__ . ' @ Date : '   . date('H:i:s'));	$GLOBALS['trace'] = 0; // RY25 TODO Remove me
		
		/*$dispatcher = t3lib_div::makeInstance('Tx_Extbase_Dispatcher');

		$albumList = array();
		if(!is_array($config['items'])) $config['items'] = array();
		
		$this->albumRepository = t3lib_div::makeInstance('Tx_Yag_Domain_Repository_AlbumRepository');
		
		$query = $this->albumRepository->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		$albumCollection = $query->execute();
		
		foreach($albumCollection as $album) {
			$albumList[] = array($album->getName(),$album->getUid());
		}
		
		$config['items'] = array_merge($config['items'], $albumList); 
		
		return $config;
		*/
	}
}
?>