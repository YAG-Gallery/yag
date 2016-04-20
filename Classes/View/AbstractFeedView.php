<?php
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

namespace DL\Yag\View;

use TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext;

abstract class AbstractFeedView extends \Tx_PtExtbase_View_BaseView {
    protected $feedItemType = 'unknown';


    public function initializeView() {
        $feedFormat              = $this->controllerContext->getRequest()->getFormat();
        $feedFormat              = ucfirst( strtolower( $feedFormat ) );
        $templatePathAndFileName = array_shift( $this->getTemplateRootPaths() ) . "/Feeds/$feedFormat.html";
        $this->setTemplatePathAndFilename( $templatePathAndFileName );
    }


    /**
     * @return string|void
     */
    public function render() {
        $this->assign( 'feedInfo', $this->buildFeedInfo() );
        $this->assign( 'feedItemType', $this->feedItemType );

        ob_clean();
        echo parent::render();
        exit;
    }

    /**
     * @return array
     */
    protected function buildFeedInfo() {
        return array(
            'creationDate' => new \DateTime(),
        );
    }

    /**
     * @param ControllerContext $controllerContext
     *
     * @return bool
     */
    public function canRender( ControllerContext $controllerContext ) {
        return true;
    }
}
