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

class Tx_Yag_PageCache_PageCacheManager implements Tx_PtExtbase_Lifecycle_EventInterface, t3lib_Singleton {
	
	/*
	 * @var Tx_Yag_Domain_Repository_Extern_TTContentRepository
	 */
	protected $ttContentRepository;


	/**
	 * @var Tx_Extbase_Service_CacheService
	 */
	protected $cacheService;

	
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
	 * Int internal state, used to avoid more than one call of the same state
	 */
	private $internalSessionState = Tx_PtExtbase_Lifecycle_Manager::UNDEFINED;
	
	
	
	/**
	 * @param Tx_Yag_Domain_Repository_Extern_TTContentRepository $ttContentRepository
	 */
	public function injectTTContentRepository(Tx_Yag_Domain_Repository_Extern_TTContentRepository $ttContentRepository) {
		$this->ttContentRepository = $ttContentRepository;
	}


	/**
	 * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}


	/**
	 * @param Tx_Extbase_Service_CacheService $cacheService
	 */
	public function injectCacheService(Tx_Extbase_Service_CacheService $cacheService) {
		$this->cacheService = $cacheService;
	}
	
	
	/**
	 * Clear the cache of all pages where a yag content element is included
	 */
	public function clearAll() {
		$this->clearPageCacheEntries($this->ttContentRepository->findAllYAGInstances()->toArray());
	}
	
	
	
	/**
	 * Clear the cachePageEntries of the given tt_content entries
	 * 
	 * @param array $ttContentEntries
	 * @return count of cleared pages
	 */
	protected function clearPageCacheEntries(array $ttContentEntries) {

		$pageIdsToClear = array();
		
		/* @var $ttContentEntry Tx_Yag_Domain_Model_Extern_TTContent */
		foreach($ttContentEntries as $ttContentEntry) {
			$pageIdsToClear[] = $ttContentEntry->getPid();
		}
		
		$this->cacheService->clearPageCache($pageIdsToClear);
		
		return count($pageIdsToClear);
	}
	
	
	
	/**
	 * Do cache clearing at the end of the lifecycle
	 * 
	 * @param int $state
	 */
	public function lifecycleUpdate($state) {
		
		if($state <= $this->internalSessionState) return;
		$this->internalSessionState = $state;
		
		if($state == Tx_PtExtbase_Lifecycle_Manager::END) {
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
		}
	}
	
	
	
	/**
	 * Marks an object as updated
	 * 
	 * @param Tx_Extbase_DomainObject_AbstractDomainObject $object
	 */
	public function markObjectUpdated(Tx_Extbase_DomainObject_AbstractDomainObject $object) {
		if($object->getUid()) {
			$this->updatedObjects[get_class($object)][] = $object->getUid();
		}
	}
	
}
?>