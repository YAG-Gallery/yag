<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2014 Daniel Lienert <typo3@lienert.cc>
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

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

require_once ExtensionManagementUtility::extPath('yag') . 'Classes/Utility/Flexform/AbstractFlexformUtility.php';

/**
 * Class provides dataProvider for FlexForm select lists
 *
 * TODO refactor me: The "actions" in this class should be put into AjaxController and should be called via an AjaxDispatcher
 *
 * @author Daniel Lienert <typo3@lienert.cc>
 * @package Utility
 */
class user_Tx_Yag_Utility_Flexform_RecordSelector extends Tx_Yag_Utility_Flexform_AbstractFlexformUtility
{
    /**
     * If set to true, this means, that we are in flexform mode
     *
     * TODO make this private and use static getter to prevent manipulation
     *
     * @var bool
     */
    public static $flexFormMode = false;


    /**
     * Album repository
     *
     * @var Tx_Yag_Domain_Repository_AlbumRepository
     */
    protected $albumRepository;


    /**
     * @var Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory
     */
    protected $configurationBuilder = null;


    /**
     * @var  \TYPO3\CMS\Extbase\Core\Bootstrap
     */
    protected $bootstrap;


    /**
     * Holds instance of pid detector
     *
     * @var Tx_Yag_Utility_PidDetector
     */
    protected $pidDetector;


    /**
     * Init the extbase Context and the configurationBuilder
     *
     * @throws Exception
     */
    protected function init()
    {
        // We do this so that we can check whether we are in "Flexform-Mode"
        self::$flexFormMode = true;

        $configuration['extensionName'] = self::EXTENSION_NAME;
        $configuration['pluginName'] = self::PLUGIN_NAME;

        $this->bootstrap = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Core\\Bootstrap');
        $this->bootstrap->initialize($configuration);

        $this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

        if (!$this->configurationBuilder) {
            try {
                // try to get the instance from factory cache
                $this->configurationBuilder = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance('backend', 'backend');
            } catch (Exception $e) {
                if (!$this->currentPid) {
                    throw new Exception('Need PID for initialisation - No PID given!', 1298928835);
                }

                $settings = $this->getTyposcriptSettings($this->currentPid);
                Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::injectSettings($settings);
                $this->configurationBuilder = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance('backend', 'backend');

                $this->initBackendRequirements();
            }
        }

        $yagPid = (int) GeneralUtility::_GP('yagPid');

        $this->pidDetector = $this->objectManager->get('Tx_Yag_Utility_PidDetector');
        $this->pidDetector->setPids(array($yagPid));
    }


    /**
     * Get the typoscript loaded on the current page
     *
     * @param $pid integer
     * @return array
     */
    protected function getTyposcriptSettings($pid)
    {
        $typoScript = Tx_PtExtbase_Div::returnTyposcriptSetup($pid, 'module.tx_yag.settings.');

        if (!is_array($typoScript) || empty($typoScript)) {
            $configuration = array(
                'extensionName' => self::EXTENSION_NAME,
                'pluginName' => self::PLUGIN_NAME,
                'controller' => 'Backend',
                'action' => 'settingsNotAvailable',
                'switchableControllerActions' => array(
                    'Backend' => array('settingsNotAvailable')
                ),
            );

            echo $this->bootstrap->run('', $configuration);
            die();
        }

        return GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Service\\TypoScriptService')->convertTypoScriptArrayToPlainArray($typoScript);
    }


    /**
     * Load JQuery Files
     *
     */
    public function initBackendRequirements()
    {
        $doc = $this->getDocInstance();
        $baseUrl = '../' . ExtensionManagementUtility::siteRelPath('yag');

        $pageRenderer = $doc->getPageRenderer();

        $compress = true;

        // Jquery
        $pageRenderer->addJsFile($baseUrl . 'Resources/Public/Js/JQuery/jquery-1.7.2.min.js', 'text/javascript', $compress);
        $pageRenderer->addJsFile($baseUrl . 'Resources/Public/Js/JQuery/jquery-ui-1.8.10.custom.min.js', 'text/javascript', $compress);

        $pageRenderer->addCssFile($baseUrl . 'Resources/Public/CSS/JQuery/base.css', 'stylesheet', 'all', '', $compress);
        $pageRenderer->addCssFile($baseUrl . 'Resources/Public/CSS/JQuery/ui-lightness/jquery-ui-1.8.7.custom.css', 'stylesheet', 'all', '', $compress);

        // Backend
        $pageRenderer->addCssFile($baseUrl . 'Resources/Public/CSS/Backend.css', 'stylesheet', 'all', '', $compress);
    }


    /**
     * Gets instance of template if exists or create a new one.
     * Saves instance in viewHelperVariable\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance template $doc
     *
     * return \TYPO3\CMS\Backend\Template\DocumentTemplate
     */
    public function getDocInstance()
    {
        $doc = GeneralUtility::makeInstance('TYPO3\\CMS\\Backend\\Template\\DocumentTemplate');
        $doc->backPath = $GLOBALS['BACK_PATH'];
        return $doc;
    }


    /**
     * Get Album List as JSON
     */
    public function getGallerySelectList()
    {
        $this->determineCurrentPID();
        $this->init();

        $this->pidDetector->setMode(Tx_Yag_Utility_PidDetector::MANUAL_MODE);

        $galleryRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_GalleryRepository');
        /** @var $galleryRepository Tx_Yag_Domain_Repository_GalleryRepository */

        $galleries = $galleryRepository->findAll();

        $template = GeneralUtility::getFileAbsFileName('EXT:yag/Resources/Private/Templates/Backend/FlexForm/FlexFormGalleryList.html');
        $renderer = $this->getFluidRenderer();

        $renderer->setTemplatePathAndFilename($template);
        $renderer->assign('galleries', $galleries);
        $content = $renderer->render();

        $this->extbaseShutdown();

        echo $content;
    }


    /**
     * Get Album List as JSON
     */
    public function getAlbumSelectList()
    {
        $this->determineCurrentPID();
        $this->init();

        $galleryRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_GalleryRepository');

        $galleryID = (int) GeneralUtility::_GP('galleryUid');
        $gallery = $galleryRepository->findByUid($galleryID);

        if ($gallery) {
            $albums = $gallery->getAlbums();
        }

        $template = GeneralUtility::getFileAbsFileName('EXT:yag/Resources/Private/Templates/Backend/FlexForm/FlexFormAlbumList.html');
        $renderer = $this->getFluidRenderer();

        $renderer->setTemplatePathAndFilename($template);

        $renderer->assign('albums', $albums);

        $content = $renderer->render();

        $this->extbaseShutdown();

        echo $content;
    }


    /**
     * Get Image List as JSON
     */
    public function getImageSelectList()
    {
        $this->determineCurrentPID();
        $this->init();

        $albumRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_AlbumRepository');

        $albumID = (int)GeneralUtility::_GP('albumUid');
        $album = $albumRepository->findbyUid($albumID);


        $template = GeneralUtility::getFileAbsFileName('EXT:yag/Resources/Private/Templates/Backend/FlexForm/FlexFormImageList.html');
        $renderer = $this->getFluidRenderer();

        $renderer->setTemplatePathAndFilename($template);

        if ($album) {
            $images = $album->getItems();
            $renderer->assign('images', $images);
        }

        $content = $renderer->render();

        $this->extbaseShutdown();

        echo $content;
    }


    /**
     * Render the selector for an album
     *
     * @param array $PA
     * @param t3lib_TCEforms $fobj
     *
     * @return string
     */
    public function renderAlbumSelector(&$PA, &$fobj)
    {
        $this->determineCurrentPID($PA['row']['pid']);
        $this->init();

        $PA['elementID'] = 'field_' . md5($PA['itemFormElID']);
        $selectedAlbumUid = (int)$PA['itemFormElValue'];

        /* @var $galleryRepository Tx_Yag_Domain_Repository_GalleryRepository */
        $galleryRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_GalleryRepository');
        $galleries = $galleryRepository->findAll();

        if ($selectedAlbumUid) {
            $albumRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_AlbumRepository');
            $selectedAlbum = $albumRepository->findByUid($selectedAlbumUid);
            if ($selectedAlbum) {
                /* @var $selectedAlbum Tx_Yag_Domain_Model_Album */
                $selectedGallery = $selectedAlbum->getGallery();

                if ($selectedGallery) {
                    $albums = $selectedGallery->getAlbums();
                }
            }
        }


        $template = GeneralUtility::getFileAbsFileName('EXT:yag/Resources/Private/Templates/Backend/FlexForm/FlexFormAlbum.html');
        $renderer = $this->getFluidRenderer();

        $renderer->setTemplatePathAndFilename($template);

        $renderer->assign('galleries', $galleries);
        $renderer->assign('albums', $albums);
        $renderer->assign('hrefTarget', $this->getHrefTargets());
        $renderer->assign('selectedAlbumUid', $selectedAlbumUid);
        $renderer->assign('selectedAlbum', $selectedAlbum);
        $renderer->assign('selectedGallery', $selectedGallery);
        $renderer->assign('PA', $PA);

        $content = $renderer->render();

        return $content;
    }


    /**
     * Render gallery selector
     *
     * @param array $PA
     * @param t3lib_TCEforms $fobj
     *
     * @return string
     */
    public function renderGallerySelector(&$PA, &$fobj)
    {
        $this->determineCurrentPID($PA['row']['pid']);
        $this->init();

        $PA['elementID'] = 'field_' . md5($PA['itemFormElID']);

        /* @var $galleryRepository Tx_Yag_Domain_Repository_GalleryRepository */
        $galleryRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_GalleryRepository');

        $galleries = $galleryRepository->findAll();

        $template = GeneralUtility::getFileAbsFileName('EXT:yag/Resources/Private/Templates/Backend/FlexForm/FlexFormGallery.html');
        $renderer = $this->getFluidRenderer();

        $renderer->setTemplatePathAndFilename($template);

        $renderer->assign('galleries', $galleries);
        $renderer->assign('PA', $PA);

        $content = $renderer->render();

        return $content;
    }


    /**
     * Render the image Selector
     *
     * @param array $PA
     * @param t3lib_TCEforms $fobj
     *
     * @return string
     */
    public function renderImageSelector(&$PA, &$fobj)
    {
        $this->determineCurrentPID($PA['row']['pid']);
        $this->init();

        $PA['elementID'] = 'field_' . md5($PA['itemFormElID']);
        $selectedImageUid = (int)$PA['itemFormElValue'];

        $template = GeneralUtility::getFileAbsFileName('EXT:yag/Resources/Private/Templates/Backend/FlexForm/FlexFormImage.html');
        $renderer = $this->getFluidRenderer();

        $renderer->setTemplatePathAndFilename($template);


        /* @var $galleryRepository Tx_Yag_Domain_Repository_GalleryRepository */
        $galleryRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_GalleryRepository');
        $galleries = $galleryRepository->findAll();

        if ($selectedImageUid) {
            $itemRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_ItemRepository');
            $selectedImage = $itemRepository->findByUid($selectedImageUid);

            if ($selectedImage) {
                /* @var $selectedImage Tx_Yag_Domain_Model_Item */

                $selectedAlbum = $selectedImage->getAlbum();

                $selectedGallery = $selectedAlbum->getGallery();

                $renderer->assign('selectedImage', $selectedImage);
                $renderer->assign('selectedAlbum', $selectedAlbum);
                $renderer->assign('selectedGallery', $selectedGallery);

                $renderer->assign('albums', $selectedGallery->getAlbums());
                $renderer->assign('hrefTarget', $this->getHrefTargets());
                $renderer->assign('images', $selectedAlbum->getItems());
            }
        }

        $renderer->assign('galleries', $galleries);
        $renderer->assign('PA', $PA);

        $content = $renderer->render();

        $this->extbaseShutdown();

        return $content;
    }


    /**
     * Render a source selector to select gallery / album / item at once
     *
     * @param array $PA
     * @param t3lib_TCEforms $fobj
     *
     * @return string
     */
    public function renderSourceSelector(&$PA, &$fobj)
    {
        $this->determineCurrentPID($PA['row']['pid']);
        $this->init();

        $PA['elementID'] = 'field_' . md5($PA['itemFormElID']);

        $template = GeneralUtility::getFileAbsFileName('EXT:yag/Resources/Private/Templates/Backend/FlexForm/FlexFormSource.html');
        $renderer = $this->getFluidRenderer();

        $renderer->setTemplatePathAndFilename($template);

        /* @var $galleryRepository Tx_Yag_Domain_Repository_GalleryRepository */
        $galleryRepository = $this->objectManager->get('Tx_Yag_Domain_Repository_GalleryRepository');
        $galleries = $galleryRepository->findAll();

        $pages = $this->pidDetector->getPageRecords();

        $renderer->assign('galleries', $galleries);
        $renderer->assign('PA', $PA);
        $renderer->assign('pages', $pages);

        $content = $renderer->render();

        $this->extbaseShutdown();

        return $content;
    }


    /**
     * Render the field for the selected gallery
     *
     * @param array $PA
     * @param t3lib_TCEforms $fobj
     * @return string
     */
    public function renderSelectedPid(&$PA, &$fobj)
    {
        return $this->renderSelectedEntity($PA, 'selectedPid');
    }


    /**
     * Render the field for the selected gallery
     *
     * @param array $PA
     * @param t3lib_TCEforms $fobj
     * @return string
     */
    public function renderSelectedGallery(&$PA, &$fobj)
    {
        return $this->renderSelectedEntity($PA, 'selectedGalleryUid');
    }


    /**
     * Render the field for the selected album
     *
     * @param array $PA
     * @param t3lib_TCEforms $fobj
     * @return string
     */
    public function renderSelectedAlbum(&$PA, &$fobj)
    {
        return $this->renderSelectedEntity($PA, 'selectedAlbumUid');
    }


    /**
     * Render the field for the selected item
     *
     * @param array $PA
     * @param t3lib_TCEforms $fobj
     * @return string
     */
    public function renderSelectedItem(&$PA, &$fobj)
    {
        return $this->renderSelectedEntity($PA, 'selectedItemUid');
    }

    /**
     * prepare href targets for select box
     *
     * @return array
     */
    public function getHrefTargets() {
        $targets = array();
        $entries = array('', '_blank', '_self');

        foreach ($entries as $entry) {
            $target = new stdClass();
            $target->key = $entry;
            $target->value = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_yag_domain_model_item.href.target.' . $entry, 'yag');
            $targets[] = $target;
        }

        return $targets;
    }


    protected function renderSelectedEntity(&$PA, $elementId)
    {
        $this->determineCurrentPID($PA['row']['pid']);
        $this->init();

        $template = GeneralUtility::getFileAbsFileName('EXT:yag/Resources/Private/Templates/Backend/FlexForm/FlexFormSelectedEntity.html');
        $renderer = $this->getFluidRenderer();

        $renderer->setTemplatePathAndFilename($template);

        $renderer->assign('PA', $PA);
        $renderer->assign('elementID', $elementId);

        $content = $renderer->render();

        $this->extbaseShutdown();
        return $content;
    }


    /**
     *\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstancen shutdown extbase
     *
     */
    protected function extbaseShutdown()
    {
        $persistenceManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager'); /* @var $persistenceManager \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager */
        $persistenceManager->persistAll();

        $reflectionService = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Reflection\\ReflectionService');
        $reflectionService->shutdown();
    }
}
