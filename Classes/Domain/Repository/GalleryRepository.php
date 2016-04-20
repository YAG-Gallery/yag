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

namespace DL\Yag\Domain\Repository;

/**
 * Repository for Gallery
 *
 * @package    Domain
 * @subpackage Repository
 */
class GalleryRepository extends AbstractRepository {
    /**
     * This method keeps translated galleries in sync when properties of the original galleries (sorting / delete)
     * was changed in the gallery module.
     */
    public function syncTranslatedGalleries() {
        $this->persistenceManager->persistAll();

        $this->createQuery()->statement(
            'UPDATE tx_yag_domain_model_gallery translatedGallery
			INNER JOIN tx_yag_domain_model_gallery parentGallery ON translatedGallery.l18n_parent = parentGallery.uid
			SET translatedGallery.sorting = parentGallery.sorting, translatedGallery.deleted = parentGallery.deleted
			WHERE translatedGallery.l18n_parent != 0
			AND (translatedGallery.sorting != parentGallery.sorting OR translatedGallery.deleted != parentGallery.deleted);
		' )->execute();
    }
}
