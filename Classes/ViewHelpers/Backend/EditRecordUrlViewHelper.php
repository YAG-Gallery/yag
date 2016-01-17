<?php
namespace DL\Yag\ViewHelpers\Backend;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Daniel Lienert
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

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class EditRecordUrlViewHelper extends AbstractViewHelper
{

    /**
     * Returns a URL to record rditor
     *
     * @param AbstractEntity $entity to link to
     * @param string $returnUrl
     * @return string link to record editor
     */
    public function render(AbstractEntity $entity, $returnUrl)
    {
        return static::renderStatic(['parameters' => $this->buildParameters($entity), 'returnUrl' => $returnUrl],
            $this->buildRenderChildrenClosure(),
            $this->renderingContext
        );
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $parameters = GeneralUtility::explodeUrl2Array($arguments['parameters']);
        $parameters['returnUrl'] = $arguments['returnUrl'];

        return BackendUtility::getModuleUrl('record_edit', $parameters);
    }



    protected function buildParameters(AbstractEntity $entity)
    {

        $className = get_class($entity);

        $classToTableMap = [
            'Tx_Yag_Domain_Model_Gallery' => 'tx_yag_domain_model_gallery',
            'Tx_Yag_Domain_Model_Album' => 'tx_yag_domain_model_album',
            'Tx_Yag_Domain_Model_Item' => 'tx_yag_domain_model_item',
        ];

        $tableName = $classToTableMap[$className];

        $parameters = sprintf('edit[%s][%s]=edit', $tableName, $entity->getUid());

        return $parameters;
    }
}