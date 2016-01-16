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
 * Class implements a fake viewhelper to add a CSS file to the header
 *
 * @author Daniel Lienert <typo3@lienert.cc>
 * @package ViewHelpers
 * @subpackage Javascript
 * 
 */
class Tx_Yag_ViewHelpers_TceForms_DatePickerViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\TextfieldViewHelper
{
    /**
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $doc = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Backend\\Template\\DocumentTemplate');
        $doc->backPath = $GLOBALS['BACK_PATH'];

        $pageRenderer = $doc->getPageRenderer();

        $pageRenderer->loadExtJS();
        $pageRenderer->addJsFile($this->backPath . '../t3lib/js/extjs/tceforms.js');

        $typo3Settings = array(
            'datePickerUSmode' => $GLOBALS['TYPO3_CONF_VARS']['SYS']['USdateFormat'] ? 1 : 0,
            'dateFormat'       => array('j-n-Y', 'j-n-Y'),
            'dateFormatUS'     => array('n-j-Y', 'n-j-Y'),
        );

        $pageRenderer->addInlineSettingArray('', $typo3Settings);
    }



    /**
     * @return string
     */
    protected function getDateFormat()
    {
        return $GLOBALS['TYPO3_CONF_VARS']['SYS']['USdateFormat'] == 1 ? 'n-j-Y' : 'j-n-Y';
    }



    /**
     * Renders the textfield.
     *
     * @param boolean $required If the field is required or not
     * @param string $type The field type, e.g. "text", "email", "url" etc.
     * @param string $placeholder A string used as a placeholder for the value to enter
     * @throws Exception
     * @return string
     */
    public function render($required = null, $type = 'text', $placeholder = null)
    {
        $name = $this->getName();
        $this->registerFieldNameForFormTokenGeneration($name);

        $this->tag->addAttribute('type', $type);
        $this->tag->addAttribute('name', $name);

        $value = $this->getValue();

        if ($placeholder !== null) {
            $this->tag->addAttribute('placeholder', $placeholder);
        }

        if (!$value instanceof DateTime) {
            try {
                $value = new DateTime($value);
            } catch (Exception $exception) {
                throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception('"' . $date . '" could not be parsed by DateTime constructor.', 1241722579);
            }
        }

        $dateValue = $value->format($this->getDateFormat());
        $this->tag->addAttribute('value', $dateValue);


        if ($required !== null) {
            $this->tag->addAttribute('required', 'required');
        }

        $this->setErrorClassAttribute();

        $html = $this->tag->render();
        $fieldId = $this->arguments['id'];

        $html .= '<span id="picker-'.$fieldId.'" class="t3-icon t3-icon-actions t3-icon-actions-edit t3-icon-edit-pick-date" style="cursor:pointer;">&nbsp;</span>';

        return $html;
    }
}
