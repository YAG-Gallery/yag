<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2011 Daniel Lienert <daniel@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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
 * Class for XMP meta data parsing
 *
 * @package Domain
 * @subpackage Import\MetaData
 * @author Michael Knoll <mimi@kaktusteam.de>
 */
class Tx_Yag_Domain_Import_MetaData_XmpParser extends Tx_Yag_Domain_Import_MetaData_AbstractParser {
	
	/**
	 * Parses given file for xmp data
	 * 
	 * TODO not working yet!
	 *
	 * @param string $filename
	 * @return array XMP data array
	 */
	public static function parseXmpData($filename) {
		$content = file_get_contents($filename);
		$xmp_data_start = strpos($content, '<x:xmpmeta');
		$xmp_data_end   = strpos($content, '</x:xmpmeta>');
		$xmp_length     = $xmp_data_end - $xmp_data_start;
		$xmp_data       = substr($content, $xmp_data_start, $xmp_length + 12);
		$xmp_data       = '<?xml version="1.0" encoding="UTF-8"?>' . $xmp_data;
		$xmp            = simplexml_load_string($xmp_data);
		
		
		#$xmpArray = self::objectsIntoArray($xmp);
		
		$xmpArray = self::simpleXMLToArray($xmp);
		
		#return $xmpArray;
		return $xmp_data;
	}
	
	

    /**
     * Converts a simpleXML element into an array. Preserves attributes and everything.
     * You can choose to get your elements either flattened, or stored in a custom index that
     * you define.
     * For example, for a given element
     * <field name="someName" type="someType"/>
     * if you choose to flatten attributes, you would get:
     * $array['field']['name'] = 'someName';
     * $array['field']['type'] = 'someType';
     * If you choose not to flatten, you get:
     * $array['field']['@attributes']['name'] = 'someName';
     * _____________________________________
     * Repeating fields are stored in indexed arrays. so for a markup such as:
     * <parent>
     * <child>a</child>
     * <child>b</child>
     * <child>c</child>
     * </parent>
     * you array would be:
     * $array['parent']['child'][0] = 'a';
     * $array['parent']['child'][1] = 'b';
     * ...And so on.
     * _____________________________________
     * @param simpleXMLElement $xml the XML to convert
     * @param boolean $flattenValues    Choose wether to flatten values
     *                                    or to set them under a particular index.
     *                                    defaults to true;
     * @param boolean $flattenAttributes Choose wether to flatten attributes
     *                                    or to set them under a particular index.
     *                                    Defaults to true;
     * @param boolean $flattenChildren    Choose wether to flatten children
     *                                    or to set them under a particular index.
     *                                    Defaults to true;
     * @param string $valueKey            index for values, in case $flattenValues was set to
            *                            false. Defaults to "@value"
     * @param string $attributesKey        index for attributes, in case $flattenAttributes was set to
            *                            false. Defaults to "@attributes"
     * @param string $childrenKey        index for children, in case $flattenChildren was set to
            *                            false. Defaults to "@children"
     * @return array the resulting array.
     */
    protected static function simpleXMLToArray($xml,
                    $flattenValues=TRUE,
                    $flattenAttributes = TRUE,
                    $flattenChildren=TRUE,
                    $valueKey='@value',
                    $attributesKey='@attributes',
                    $childrenKey='@children'){

        $return = array();
        
        if (!($xml instanceof SimpleXMLElement)) {
            return $return;
        }
        
        $name = $xml->getName();
        $_value = trim((string)$xml);
        
        if (strlen($_value)==0) {
            $_value = null;
        }

        if ($_value!==null) {
            if(!$flattenValues){
                $return[$valueKey] = $_value;
            } else{
                $return = $_value;
            }
        }

        $children = array();
        $first = TRUE;
        foreach($xml->children() as $elementName => $child){
            $value = self::simpleXMLToArray($child, $flattenValues, $flattenAttributes, $flattenChildren, $valueKey, $attributesKey, $childrenKey);
            if (isset($children[$elementName])) {
                if ($first) {
                    $temp = $children[$elementName];
                    unset($children[$elementName]);
                    $children[$elementName][] = $temp;
                    $first=false;
                }
                $children[$elementName][] = $value;
            } else {
                $children[$elementName] = $value;
            }
        }
        if (count($children)>0) {
            if (!$flattenChildren) {
                $return[$childrenKey] = $children;
            } else {
                $return = array_merge($return,$children);
            }
        }

        $attributes = array();
        foreach($xml->attributes() as $name=>$value) {
            $attributes[$name] = trim($value);
        }
        if (count($attributes)>0) {
            if (!$flattenAttributes) {
                $return[$attributesKey] = $attributes;
            } else {
                $return = array_merge($return, $attributes);
            }
        }
       
        return $return;
    }
	
	
	protected static function objectsIntoArray($arrObjData, $arrSkipIndices = array()) {
	    $arrData = array();
	   
	    // if input is object, convert into array
	    if (is_object($arrObjData)) {
	        $arrObjData = get_object_vars($arrObjData);
	    }
	   
	    if (is_array($arrObjData)) {
	        foreach ($arrObjData as $index => $value) {
	            if (is_object($value) || is_array($value)) {
	                $value = objectsIntoArray($value, $arrSkipIndices); // recursive call
	            }
	            if (in_array($index, $arrSkipIndices)) {
	                continue;
	            }
	            $arrData[$index] = $value;
	        }
	    }
	    return $arrData;
	}
	
	
	/**
	 * Helper method for converting xmp xml object into an array
	 *
	 * @param SimpleXMLElement $obj
	 * @param array $subject_array
	 */
	protected static function recursive_obj2array($obj, &$subject_array=array()) {
	    foreach ((array) $obj as $key => $var) {
	        if (is_object($var)) {
	            if(count((array) $var) == 0) {
	                $subject_array[$key] = 'NULL';
	            }
	            else {
	                recursive_obj2array($var, $subject_array[$key]);
	            }
	        }
	        else {
	            $subject_array[$key] = $var;
	        }
	    }
    }
	
}
 
?>