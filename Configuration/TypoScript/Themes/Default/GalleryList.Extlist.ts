####################################################
# Extlist configuration for showing galleries
# in a list
#
# @author Daniel Lienert <typo3@lienert.cc>
# @author Michael Knoll <mimi@kaktusteam.de.de>
# @package YAG
# @subpackage Typoscript
####################################################

plugin.tx_yag.settings.themes.default.extlist.galleryList {

	backendConfig < plugin.tx_ptextlist.prototype.backend.extbase
	backendConfig {

		respectStoragePage = 1

		repositoryClassName = DL\Yag\Domain\Repository\GalleryRepository

	    sorting = sorting

	}


	fields {
		gallery {
			table = __self__
			field = __object__
		}
	}


	columns {
		10 {
			fieldIdentifier = gallery
			columnIdentifier = gallery
			label = Album
		}
	}


	pager {
		itemsPerPage = 16
	}


	filters {
        internalFilters {
            filterConfigs {

                # Filter for not showing hidden galleries
                10 {
                    partialPath = noPartialNeeded
                    filterClassName = DL\Yag\Extlist\Filter\GalleryHideFilter
                    filterIdentifier = galleryHideFilter

                    ## fieldIdentifier is not used but must be set to existing field!
                    fieldIdentifier = gallery

                    hideHidden = 1
                }

                # Filter that can set up uids that should (not) be shown
                20 {
                    partialPath = noPartialNeeded
                    filterClassName = DL\Yag\Extlist\Filter\GalleryUidFilter
                    filterIdentifier = galleryUidFilter

                    ## fieldIdentifier is not used but must be set to existing field!
                    fieldIdentifier = gallery

                    # set up uids that are shown (no other galleries will be shown)
                    #onlyInUids = 1,2,3,4,5

                    # set up uids that are NOT shown (is overwritten by onlyInUids)
                    # notInUids = 1,2,3,4,5,9

                    hideHidden = 1
                }
            }
        }
    }

}