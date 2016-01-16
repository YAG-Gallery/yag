<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Michael Knoll <mimi@kaktusteam.de>
*           Daniel Lienert <typo3@lienert.cc>
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
 * Repository for Tx_Yag_Domain_Model_ResolutionFileCache
 *
 * @package Domain
 * @subpackage Repository
 * @author Daniel Lienert <lienert@punkt.de>
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_Repository_ResolutionFileCacheRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * Set to false --> pidDetector is NOT respected
     * @var bool
     */
    protected $respectPidDetector = false;


    /**
     * This counter is not save for concurrent requests!
     * It supports the hashFileSystem to spread the item-ids over the hash file-system
     * @var integer
     */
    protected $internalObjectCounter = 0;


    /**
     * Persist the cache after n items. If the server process
     * gets killed while rendering a large page, the processed data
     * does not get lost.
     *
     * @var integer
     */
    protected $persistCacheAfterItems = 10;



    /**
     * Sets the respect storage page to false.
     */
    public function __construct(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager)
    {
        parent::__construct($objectManager);
        $this->defaultQuerySettings = new \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings();
        $this->defaultQuerySettings->setRespectStoragePage(false);
        $this->defaultQuerySettings->setRespectSysLanguage(false);
    }


    /**
     * TODO: Find out why this method is called also when it not exists ...
     */
    public function initializeObject()
    {
    }


        
    /**
     * Get the item file resolution object
     * 
     * @param Tx_Yag_Domain_Model_Item $item
     * @param Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration
     * @return Tx_Yag_Domain_Model_ResolutionFileCache
     */
    public function getResolutionByItem(Tx_Yag_Domain_Model_Item $item, Tx_Yag_Domain_Configuration_Image_ResolutionConfig $resolutionConfiguration)
    {
        $query = $this->createQuery();
        $constraints = array();
        
        $constraints[] = $query->equals('item', $item->getUid());
        $constraints[] = $query->equals('paramhash', $resolutionConfiguration->getParameterHash());
            
        $result = $query->matching($query->logicalAnd($constraints))->execute();

        $object = null;

        if ($result !== null && !is_array($result) && $result->current() !== false) {
            $object = $result->current();
            $session = $this->objectManager->get('TYPO3\CMS\Extbase\Persistence\Generic\Session');
            $session->registerObject($object, $object->getUid());
        }

        return $object;
    }



    /**
     * @param array<Tx_Yag_Domain_Model_Item>
     * @param array $parameterHashArray<Tx_Yag_Domain_Model_ResolutionFileCache>
     * @return array
     */
    public function getResolutionsByItems(array $itemArray, array $parameterHashArray)
    {
        if (count($itemArray) === 0 || count($parameterHashArray) === 0) {
            return array();
        }

        $query = $this->createQuery();
        $constraints = array();
        $fileCacheArray = array();

        $constraints[] = $query->in('item', array_keys($itemArray));
        $constraints[] = $query->in('paramhash', $parameterHashArray);

        $result = $query->matching($query->logicalAnd($constraints))->execute(true);

        if ($result !== null) {
            foreach ($result as $row) {
                if (is_a($itemArray[$row['item']], 'Tx_Yag_Domain_Model_Item')) {
                    $fileCacheArray[$row['uid']] = new Tx_Yag_Domain_Model_ResolutionFileCache(
                        $itemArray[$row['item']],
                        $row['path'],
                        $row['width'],
                        $row['height'],
                        $row['paramhash']
                    );
                }
            }
        }

        return $fileCacheArray;
    }

    
    
    /**
     * Removes all cached files for a given item
     *
     * @param Tx_Yag_Domain_Model_Item $item Item to remove cached files for
     */
    public function removeByItem(Tx_Yag_Domain_Model_Item $item)
    {
        $query = $this->createQuery();
        $query->matching($query->equals('item', $item->getUid()));
        $cachedFilesForItem = $query->execute();
        
        foreach ($cachedFilesForItem as $cachedFileForItem) { /* @var $cachedFileForItem Tx_Yag_Domain_Model_ResolutionFileCache */
            $this->remove($cachedFileForItem);
        }
    }
    
    
    
    /**
     * Removes resolution file cache object and file from filesystem
     *
     * @param Tx_Yag_Domain_Model_ResolutionFileCache $resolutionFileCache
     */
    public function remove($resolutionFileCache)
    {
        $cacheFilePath = Tx_Yag_Domain_FileSystem_Div::getT3BasePath() . $resolutionFileCache->getPath();
        if (file_exists($cacheFilePath)) {
            unlink(Tx_Yag_Domain_FileSystem_Div::getT3BasePath() . $resolutionFileCache->getPath());
            parent::remove($resolutionFileCache);
        }
    }



    /**
     * @param object $object
     */
    public function add($object)
    {
        $this->internalObjectCounter++;
        parent::add($object);

        if ($this->internalObjectCounter % $this->persistCacheAfterItems === 0) {
            $this->persistenceManager->persistAll();
        }
    }

    

    /**
     * Calculates the next uid that would be given to 
     * a resolutionFileCache record
     * 
     */
    public function getCurrentUid()
    {
        $itemsInDatabase = $this->countAll();
        return $itemsInDatabase + $this->internalObjectCounter;
    }
}
