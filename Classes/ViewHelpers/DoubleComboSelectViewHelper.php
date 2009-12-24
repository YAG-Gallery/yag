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
 * Class definitionfile for double combo box viewhelper
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */



/**
 * Class implements a viewhelper showing a double combo box for selecting elements 
 *
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since 2009-12-23
 * @package Typo3
 * @subpackage yag
 */
class Tx_Yag_ViewHelpers_DoubleComboSelectViewHelper extends Tx_Fluid_ViewHelpers_Form_AbstractFormFieldViewHelper {
    
    /**
     * Initialize arguments.
     *
     * @return void
     * @author Michael Knoll <mimi@kaktusteam.de>
     */
    public function initializeArguments() {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('size', 'string', 'Size of input field');
        $this->registerTagAttribute('disabled', 'string', 'Specifies that the input element should be disabled when the page loads');
        $this->registerArgument('options', 'array', 'Associative array with internal IDs as key, and the values are displayed in the select box', TRUE);
        $this->registerArgument('optionsLabel', 'string', 'Label for the available options combo box');
        $this->registerArgument('optionValueField', 'string', 'If specified, will call the appropriate getter on each option object to determine the value.');
        $this->registerArgument('optionLabelField', 'string', 'If specified, will call the appropriate getter on each option object to determine the label.');
        $this->registerArgument('values', 'array', 'Associative array with internal IDs as key, and the values to be displayed in the selected select box');
        $this->registerArgument('valuesLabel', 'string', 'Label for the selected options combo box');
        $this->registerArgument('valueValueField', 'string', 'If specified, will call the appropriate getter on each value object to determine the value');
        $this->registerArgument('valueLabelField', 'string', 'If specified, will call the appropriate getter on each value object to determine the label');
        $this->registerArgument('errorClass', 'string', 'CSS class to set if there are errors for this view helper', FALSE, 'f3-form-error');
        $this->registerArgument('formName', 'string', 'Form name of surrounding form', TRUE);
    }
    
    
	
	/**
	 * View helper for showing debug information for a given object
	 *
	 * @return string  The rendered double combo select box
	 * @author Michael Knoll <mimi@kaktusteam.de>
	 */
	public function render() {
        $enclosingDivTag = new Tx_Fluid_Core_ViewHelper_TagBuilder('div');
        $divTagContent = '';
        
        $optionsListName = $this->getName() . '[options]';
        $valuesListName = $this->getName() . '[values]';
        $returnParamName = $this->getName();
        $surroundingFormName = $this->arguments['formName'];
        
        $enclosingTable = new Tx_Fluid_Core_ViewHelper_TagBuilder('table');
        $enclosingTable->forceClosingTag(true);
        $firstRow = new Tx_Fluid_Core_ViewHelper_TagBuilder('tr');
        $firstRow->forceClosingTag(true); 
        $secondRow = new Tx_Fluid_Core_ViewHelper_TagBuilder('tr');
        $secondRow->forceClosingTag(true);
        $cell_1_1 = new Tx_Fluid_Core_ViewHelper_TagBuilder('td');
        $cell_1_1->forceClosingTag(true);
        $cell_1_2 = new Tx_Fluid_Core_ViewHelper_TagBuilder('td');
        $cell_1_2->forceClosingTag(true);
        $cell_1_3 = new Tx_Fluid_Core_ViewHelper_TagBuilder('td');
        $cell_1_3->forceClosingTag(true);
        $cell_2_1 = new Tx_Fluid_Core_ViewHelper_TagBuilder('td');
        $cell_2_1->forceClosingTag(true);
        $cell_2_2 = new Tx_Fluid_Core_ViewHelper_TagBuilder('td');
        $cell_2_2->forceClosingTag(true);
        $cell_2_3 = new Tx_Fluid_Core_ViewHelper_TagBuilder('td');
        $cell_2_3->forceClosingTag(true);
        
        // Render options select box (values that can be selected)
        $optionsSelectBox = new Tx_Fluid_Core_ViewHelper_TagBuilder('select');
        #$optionsSelectBox->setTagName('available_options');
        $optionsSelectBox->addAttribute('name', $optionsListName);
        $optionsSelectBox->addAttribute('multiple', '1');
        $optionsSelectBox->addAttribute('size', $this->arguments['size'] > 0 ? $this->arguments['size'] : 10);
        $optionsSelectBox->forceClosingTag(true);
        $optionsSelectBoxOptions = $this->getOptions($this->arguments['options'], $this->arguments['optionValueField'], $this->arguments['optionLabelField']);
        $optionsSelectBox->setContent($this->renderOptionsContent($optionsSelectBoxOptions));
        $cell_2_1->setContent($optionsSelectBox->render());
        // Render label for options select box
        if ($this->arguments['optionsLabel'] != '') {
	        $optionsSelectBoxLabel = new Tx_Fluid_Core_ViewHelper_TagBuilder('label');
	        $optionsSelectBoxLabel->addAttribute('for', $optionsListName);
	        $optionsSelectBoxLabel->setContent($this->arguments['optionsLabel']);
	        $cell_1_1->setContent($optionsSelectBoxLabel->render());
        }
        
        // Render buttons for manipulate content
        $deleteButton = new Tx_Fluid_Core_ViewHelper_TagBuilder('input');
        $deleteButton->addAttribute('type', 'submit');
        $deleteButton->addAttribute('value', 'x');
        $deleteButton->addAttribute('onClick', "removeSelectedOptions(document.forms['$surroundingFormName']['$valuesListName']);copyOptionsToTextbox('$valuesListName', '$returnParamName');return false;");
        $moveRightButton = new Tx_Fluid_Core_ViewHelper_TagBuilder('input');
        $moveRightButton->addAttribute('type', 'submit');
        $moveRightButton->addAttribute('value', '>>');
        $moveRightButton->addAttribute('onClick', "copySelectedOptions(document.forms['$surroundingFormName']['$optionsListName'],document.forms['$surroundingFormName']['$valuesListName'],false);copyOptionsToTextbox('$valuesListName', '$returnParamName');return false;");
        $cell_2_2->setContent($moveRightButton->render() . '<br />' . $deleteButton->render());
        
        
        // Render selected options select box (values that have been selected)
        $selectedSelectBox = new Tx_Fluid_Core_ViewHelper_TagBuilder('select');  
        #$selectedSelectBox->setTagName($this->getName());
        $selectedSelectBox->addAttribute('name', $valuesListName);
        $selectedSelectBox->addAttribute('multiple', '1');
        $selectedSelectBox->addAttribute('size', $this->arguments['size'] > 0 ? $this->arguments['size'] : 10);
        $selectedSelectBox->addAttribute('id', $valuesListName);
        $selectedSelectBox->forceClosingTag(true);
        $selectedSelectBoxOptions = $this->getOptions($this->arguments['values'], $this->arguments['valueValueField'], $this->arguments['valueLabelField']);
        $selectedSelectBox->setContent($this->renderOptionsContent($selectedSelectBoxOptions));
        $cell_2_3->setContent($selectedSelectBox->render());
        // Render label for values select box
	    if ($this->arguments['valuesLabel'] != '') {
            $selectedSelectBoxLabel = new Tx_Fluid_Core_ViewHelper_TagBuilder('label');
            $selectedSelectBoxLabel->addAttribute('for', $valuesListName);
            $selectedSelectBoxLabel->setContent($this->arguments['valuesLabel']);
            $cell_1_3->setContent($selectedSelectBoxLabel->render());
        }
        
        // Render enclosing table
        $firstRow->setContent($cell_1_1->render() . $cell_1_2->render() . $cell_1_3->render());
        $secondRow->setContent($cell_2_1->render() . $cell_2_2->render() . $cell_2_3->render());
        $enclosingTable->setContent($firstRow->render() . $secondRow->render());
        
        // Render enclosing div tag
        $enclosingDivTag->setContent($enclosingTable->render());
        
        // Render hidden input field for passing values
        $hiddenInput = new Tx_Fluid_Core_ViewHelper_TagBuilder('input');
        $hiddenInput->addAttribute('type', 'input');
        $hiddenInput->addAttribute('name', $returnParamName);
        $hiddenInput->addAttribute('id', $returnParamName);
        $hiddenInput->addAttribute('value', $this->getCommaSeparatedIds($this->getOptions($this->arguments['values'], $this->arguments['valueValueField'], $this->arguments['valueLabelField'])));
            
        // Render JS-Tag
        $jsTag = new Tx_Fluid_Core_ViewHelper_TagBuilder('script');
        $jsTag->addAttribute('language', 'JavaScript');
        $jsTag->addAttribute('src', 'typo3conf/ext/yag/Resources/Public/Javascript/selectBox.js');
        $jsTag->forceClosingTag(true);
        
        // JS Config
        $jsCode = '<SCRIPT LANGUAGE="JavaScript">
                   var opt = new OptionTransfer("'.$optionsListName.'","'.$valuesListName.'");
                   opt.setAutoSort(true);
                   opt.setDelimiter(",");
                   opt.setStaticOptionRegex("");
                   opt.saveNewRightOptions("' . $this->getName() . '");
                   </SCRIPT>';
        
        
        return $jsTag->render() . $jsCode . $enclosingDivTag->render() . $hiddenInput->render();
	}
	
	
	
	/**
	 * Returns all keys of an array as comma separated list
	 *
	 * @param array $options   Array of key=>value pairs
	 * @return string   Comma separated list of array keys
	 */
	protected function getCommaSeparatedIds($options) {
		return implode(',', array_values($options));
	}
	
	
	
	/**
	 * Renders a set of option tags for given options
	 *
	 * @param unknown_type $options
	 * @return unknown
	 */
	protected function renderOptionsContent($options) {
		$optionsContent = '';
		foreach ($options as $label => $value) {
			$optionsContent .= $this->renderOptionTag($value, $label, $this->isSelected($value));
		}
		return $optionsContent;
	}
	
	
	
	/**
	 * Returns true if a given value is among the selected values
	 *
	 * @param mixed $value   Value to be checked whether it is selected
	 * @return boolean True, if given value is among selected values
	 */
	protected function isSelected($value) {
		return false;
	}
	
	
	
    /**
     * Render the option tags.
     *
     * @param  array $optionsObject  Object of options (most likely Tx_Extbase_Persistence_ObjectStorage)
     * @param  string $optionsValueField Name of value property on option to call the right getter for value
     * @param  string $optionsLabelField Name of label property on option to call the right getter for label
     * @return array an associative array of options, key will be the value of the option tag
     * @author Bastian Waidelich <bastian@typo3.org>
     * @author Karsten Dambekalns <karsten@typo3.org>
     */
    protected function getOptions($optionsObject, $optionsValueField = NULL, $optionsLabelField = NULL) {
        $options = array();
        foreach ($optionsObject as $key => $value) {
            if (is_object($value)) {

                if ($optionsLabelField) {
                    $key = Tx_Extbase_Reflection_ObjectAccess::getProperty($value, $optionsLabelField);
                    if (is_object($key)) {
                        if (method_exists($key, '__toString')) {
                            $key = (string)$key;
                        } else {
                            throw new Tx_Fluid_Core_ViewHelper_Exception('Identifying value for object of class "' . get_class($value) . '" was an object.' , 1247827428);
                        }
                    }
                } elseif ($this->persistenceManager->getBackend()->getIdentifierByObject($value) !== NULL) {
                    $key = $this->persistenceManager->getBackend()->getIdentifierByObject($value);
                } elseif (method_exists($value, '__toString')) {
                    $key = (string)$value;
                } else {
                    throw new Tx_Fluid_Core_ViewHelper_Exception('No identifying value for object of class "' . get_class($value) . '" found.' , 1247826696);
                }

                if ($optionsValueField) {
                    $value = Tx_Extbase_Reflection_ObjectAccess::getProperty($value, $optionsValueField);
                    if (is_object($value)) {
                        if (method_exists($value, '__toString')) {
                            $value = (string)$value;
                        } else {
                            throw new Tx_Fluid_Core_ViewHelper_Exception('Label value for object of class "' . get_class($value) . '" was an object without a __toString() method.' , 1247827553);
                        }
                    }
                } elseif (method_exists($value, '__toString')) {
                    $value = (string)$value;
                } elseif ($this->persistenceManager->getBackend()->getIdentifierByObject($value) !== NULL) {
                    $value = $this->persistenceManager->getBackend()->getIdentifierByObject($value);
                }
            }
            $options[$key] = $value;
        }
        return $options;
    }
	
	
    /**
     * Render one option tag
     *
     * @param string $value value attribute of the option tag (will be escaped)
     * @param string $label content of the option tag (will be escaped)
     * @param boolean $isSelected specifies wheter or not to add selected attribute
     * @return string the rendered option tag
     * @author Bastian Waidelich <bastian@typo3.org>
     */
    protected function renderOptionTag($value, $label, $isSelected) {
        $output = '<option value="' . htmlspecialchars($value) . '"';
        if ($isSelected) {
            $output.= ' selected="selected"';
        }
        $output.= '>' . htmlspecialchars($label) . '</option>';

        return $output;
    }
	
}

?>