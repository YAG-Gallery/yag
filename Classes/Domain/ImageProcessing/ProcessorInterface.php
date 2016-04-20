<?php
/***************************************************************
 * Copyright notice
 *
 *   2010 Daniel Lienert <typo3@lienert.cc>, Michael Knoll <mimi@kaktusteam.de>
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

namespace DL\Yag\Domain\ImageProcessing;

use DL\Yag\Domain\Configuration\Image\ResolutionConfig;
use DL\Yag\Domain\Model\Item;

/**
 * Interface for an image processor
 *
 * @package    Domain
 * @subpackage ImageProcessing
 * @author     Daniel Lienert <typo3@lienert.cc>
 */
interface ProcessorInterface {
    /**
     * Generate a resolution of the given original file, described in the given resolution configuration
     *
     * @param Item             $origFile
     * @param ResolutionConfig $resolutionConfiguration
     */
    public function generateResolution( Item $origFile, ResolutionConfig $resolutionConfiguration );
}
