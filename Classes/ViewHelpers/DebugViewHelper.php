<?php

class Tx_Yag_ViewHelpers_DebugViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * View helper for showing debug information for a given object
	 *
	 * @param object $object
	 * @return string
	 */
	public function render($object=NULL) {
        $output = print_r($object,true);
        return $output;
	}
	
}

?>