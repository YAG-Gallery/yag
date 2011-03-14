<?php
/***************************************************************
* Copyright notice
*
*   2010 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
* All rights reserved
*
*
* This script is part of the TYPO3 project. The TYPO3 project is
* free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
* Class implements PageCache mangement methods
*
* @package PageCache
* @author Daniel Lienert <daniel@lienert.cc>
*/

class Tx_Yag_PageCache_PageCacheManager implements Tx_PtExtlist_Domain_Lifecycle_LifecycleEventInterface {
	
	/*
	 * @var Tx_Yag_Domain_Repository_Extern_TTContentRepository
	 */
	protected $ttContentRepository;
	
	
	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	protected $objectManager;
	
	
	/**
	 * 2-d array of array[objectClass][] -> objectUid
	 * @var array
	 */
	protected $updatedObjects = array();
	
	
	
	/**
	 * @param Tx_Yag_Domain_Repository_Extern_TTContentRepository $ttContentRepository
	 */
	public function injectTTContentRepository(Tx_Yag_Domain_Repository_Extern_TTContentRepository $ttContentRepository) {
		$this->ttContentRepository = $ttContentRepository;
	}
	
	
	
	/**
	 * @param Tx_Yag_Domain_Repository_Extern_TTContentRepository $ttContentRepository
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}
	
	
	
	/**
	 * Clear the cache of all pages where a yag content element is included
	 */
	public function clearAll() {
		$this->clearPageCacheEntrys($this->ttContentRepository->findAllYAGInstances()->toArray());
	}
	
	
	
	/**
	 * Clear the cachePageEntrys of the given tt_content entrys 
	 * 
	 * @param array $ttContetEntrys
	 * @return count of cleared pages
	 */
	protected function clearPageCacheEntrys(array $ttContetEntrys) {
		
		/* @var $cacheUtility Tx_Extbase_Utility_Cache */
		$cacheUtility = $this->objectManager->get('Tx_Extbase_Utility_Cache');
		$pageIdsToClear = array();
		
		/* @var $ttContetEntry Tx_Yag_Domain_Model_Extern_TTContent */
		foreach($ttContetEntrys as $ttContetEntry) {
			$pageIdsToClear[] = $ttContetEntry->getPid();
		}
		
		$cacheUtility->clearPageCache($pageIdsToClear);
		
		return count($pageIdsToClear);
	}
	
	
	
	/**
	 * Do cache clearing at the end of the lifecycle
	 * 
	 * @param int $state
	 */
	public function lifecycleUpdate($state) {
		
		if($state = Tx_PtExtlist_Domain_Lifecycle_LifecycleManager::START) {
			$this->doAutomaticCacheClearing();
		}
	}
	
	
	
	/**
	 * Clear pages that contain updated objects
	 * 
	 */
	public function doAutomaticCacheClearing() {
		// TODO: Clear only pages that contain the updated objects
		if(count($this->updatedObjects)) {
			$this->clearAll();
			error_log('Done automatic cache clearing.');
		}
	}
	
	
	
	/**
	 * Marks an object as updated
	 * 
	 * @param Tx_Extbase_DomainObject_AbstractDomainObject $object
	 */
	public function markObjectUpdated(Tx_Extbase_DomainObject_AbstractDomainObject $object) {
		$this->updatedObjects[get_class($object)][] = $object->getUid();
	}
	
}
?>