.. include:: Images.txt

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


ChangeLog
---------

For detailed change logs, visit `https://github.com/YAG-
Gallery/yag/commits/master <https://github.com/YAG-
Gallery/yag/commits/master>`_

.. t3-field-list-table::
 :header-rows: 1

 - :Version:
      Version:
   
   :Changes:
      Changes:

 - :Version:
      4.1.0

   :Changes:

       Changed the minimum compatible TYPO3 version to 7.6.0

       [BUGFIX] Fix Bug #72754 - backend image editing is broken

       [TASK] Further improve file processing to work with TYPO3 7.6

       [BUGFIX] Fix Bug #72753 - correctly check metaData array

       [FEATURE] Make YAG installable via composer

 - :Version:
      4.0.7

   :Changes:

       [TASK] Fix Backend Ajax requests

 - :Version:
      4.0.6

   :Changes:

       [TASK] Fix Backend Layout for 7.4

       [FEATURE] Synchronize sorting/deleted flag of translated enteties

       [BUGFIX] Removed usage of deprecated identityMap

       [BUGFIX] Flexform entry "selectedAlbumUid" is selectable

       [BUGFIX] Use original classes findByUid when typo3 Version is >= 7


 - :Version:
      4.0.5

   :Changes:

       [FIX] Fix backend form labels

       [TASK] Update submodule Magnific Popup

       [FIX] Fix flipping close button in the backend form overlay

       [FIX] Set only config values in context from flexForm if they are needed




 - :Version:
      4.0.4

   :Changes:

       [CHG] Moved the makeCategorizable calls from ext_tables to TCA/Overrides

       [ADD] Feature: Javascript include viewhelper can include inline JS


 - :Version:
      4.0.2

   :Changes:

       [BUGFIX] Bug #64216 get raw result in getRandomItemUIDs


 - :Version:
      4.0.0

   :Changes:

       During a big code refactoring, all calls to legacy TYPO3 classes where removed to make YAG compatible with TYPO3 7.0. Change the YAG icon to fit into the TYPO3 7.0 style.

       [FEATURE] Images, Albums and Galleries can now be categorized

       [FEATURE] A scheduler task was introduced to warm up the resolution file cache.

       [BUGFIX] Bug #59554 Gallery - jump to YAG folder throws an exception.

 - :Version:
      3.2.5

   :Changes:
       [BUGFIX] Initialize the Tx_PtExtbase_Utility_FakeFrontendFactory with the current pid to fix a problem with multi domain sites and special page structures

 - :Version:
      3.2.4

   :Changes:
       [BUGFIX] #59278 Tx_Extbase_Configuration_ConfigurationManager should be fetched using the objectManager

       [BUGFIX] injection of ConfigurationManager implementation instead of interface creates possible incompatibility with other extensions

 - :Version:
      3.2.3

   :Changes:
      [CHANGE] Album list is sorted by album date instead of record creation date

      [BUGFIX] Bug #58351 Error when adding or updating galleries / albums if the default date format was changed

      [BUGFIX] Bug #58863 Error on creating a new Gallery in TYPO3 6.2.2

      [BUGFIX] The image processor throws an exception on TYPO3 6.2 if the filePath contains spaces.

 - :Version:
      3.2.2

   :Changes:
      [TASK] Restructure and improve the manual

      [BUGFIX] Resolution files are not longer recreated at every request

 - :Version:
      3.2.1

   :Changes:
       [BUGFIX] Bug #57955 Call to undefined method stdClass::set_no_cache()

       [BUGFIX] Bug #58097 checkDirAndCreateIfMissing in Windows (XAMPP)

       [BUGFIX] #58103 FE-User login causes Uncaught TYPO3 Exception

       [BUGFIX] Bug #58198 Fatal error: Uncaught SqlErrorException

 - :Version:
         3.2.0

   :Changes:
      YAG is now Compatible to TYPO3 6.2

      [BUGFIX] Bug #56734 Broken Gallery Preview if source album is hidden. Now the first non-hidden album is used if the thumb album is hidden

      [BUGFIX] Bug #56609 Tried to create new directory " . $expectedDirectoryForOrigImage . " but could not create this directory. Create directories recursive

      [BUGFIX] Bug #56230 - Fatal Error in RealUrlHook.php after install realurl v1.12.8 (yag v3.1.2). Add Compatibility layer

      [BUGFIX] The Resolution File Cache now checks, if a processed image was moved to the expected destination and throws an Exception if it did not happen.

      [BUGFIX] The recursive creation of the yag temp directory is now handled as expected, removing the changes of a previous commit where make_deep was used.

      [BUGFIX] The cached resolution file of an image is now recreated, if the file was deleted but the database record still exists.

      [BUGFIX] Add a FlexForm dummy field to prevent parsing errors

      [BUGFIX] Use t3lib_div::mkdir_deep as yag requires deep temp folder

      [BUGFIX] #56046 Assure that we get a metaDataObject form image

      [BUGFIX] Add objectManager argument to PageRepository

      [BUGFIX] Adjust constructor function to current Repository class

      [BUGFIX] Correct INCLUDE_TYPOSCRIPT format for new parser

 - :Version:
         3.1.2

   :Changes:
      [BUGFIX] #56005 Wrong definition of dpi field in ext_tables.sql

      [BUGFIX] #55278 - change version check method to isMinTypo3Version

 - :Version:
         3.1.1

   :Changes:
      [BUGFIX] Gallery list throws fatal error #1247602160 caused by hidden renamed to hide. Thanks to Nicole / @ichHabRecht for the patch.
      
      [BUGFIX] Changed the minimum required TYPO3 version to 4.5.0


 - :Version:
         3.1.0

   :Changes:
      [FEATURE] Add Links to edit elements in list module form for gallery and album

      [FEATURE] Image viewHelper is now able to calculate a top margin for vertical alignment

      [FEATURE] Adds two new fields to itemMetaData: DPI and ColorSpace. Adds the coreDataParser which uses IM/GM to extract this data from teh uploaded image file

      !!! [CHANGE]: Hidden field is "hidden" again. Removed "hide" field. Added TCA Utility to manipulate TCA for the backend

      [BUGFIX] Fix file Size in DragNDrop Error message

      [BUGFIX] #54811 - Fixed Albumlist HTML structure

      [BUGFIX] Set plugin.tx_yag.mvc.callDefaultActionIfActionCantBeResolved = 1 which enables typoscript inserted YAG instances on pages with plugin instances

      [BUGFIX] Plugininfo does not crash when YAG plugin ins inserted via grid elements

      [BUGFIX] getItemsByUids now sorts result by given sorted uids

      [BUGFIX] Correction for pageSuccessfullyMarkedAsYAGFolder label

      [BUGFIX] Add missing parameter yagContext to partial rendering

      [BUGFIX] Sort by original filename instead of prefixed filename when filename is selected

      [BUGFIX] Setting the album as gallery thumb is now possible


 - :Version:
         3.0.0
   
   :Changes:
         [FEATURE] Add Formular to edit item details in the backend module
         
         [FEATURE] Define your custom item meta data fields, fill them within
         the backend form and display then within the frontend
         
         [FEATURE] AlbumViewHelper now also accepts the gallery as parameter
         
         [FEATURE] YAG FAL Driver - use YAG as a digital asset management for
         images
         
         [FEATURE] Inclusion of external JS APIs now supported
         
         [FEATURE] The Lightbox Theme is now fully responsive
         
         [FEATURE] The Lightbox Theme now uses the jQuery Lightbox Magnific
         Popup, which better performs on touch devices.
         
         [FEATURE] Add a RSS Feed for the images in your album
         
         ![FEATURE] The gallery and album filter now operate in two different
         modes
         
         [FEATURE] Custom Template Paths now support format override. Just
         place another template with the according file extension alongside the
         template and add the format parameter
         
         [FEATURE] Add additional fields to the GIFBUILDERs data
         
         [FEATURE] Add ItemListJsonViewHelper to render the itemList as a json
         
         [FEATURE] Add Javscript view to retrieve a javascript view of the
         current itemlist
         
         [BUGFIX] #53534 FAL-Drivers: Make getFileInfo more versatile and
         performant
         
         [BUGFIX] Bug #53351 Call to a member function addValidator() on a non-
         object
         
         [BUGFIX] Fixed Bug #48819: File names in zip uploader
         
         [BUGFIX] Bug #51174 Updating gallery date not possible
         
         [BUGFIX] #47958 - Removed all usages of $GLOBALS[SOBE]
         
         [BUGFIX] #51894 "Build resolution file cache" doesnt work.
         
         [BUGFIX] Fix BUG #48821 - last tag can now be deleted
         
         [BUGFIX] #49204 ExternalPlugins /Socials.ts included but not longer
         needed
         
         [BUGFIX] Bug #48940 - $item is checked with instanceOf in
         ImageViewHelper
         
         [TASK] Update .gitignore
         
         [TASK] Fix Comments


 - :Version:
         2.5.3
   
   :Changes:
         [BUGFIX] Image Files are now deleted from image source directory
         
         [BUGFIX] Hide the off page item divs with an additional hidden
         container.
         
         [BUGFIX] Image Files are now deleted from image source directory


 - :Version:
         2.5.2
   
   :Changes:
         [BUGFIX] Fix bug #48339: Albums lost after sorting with Dragn Drop
         
         [BUGFIX] #48160 Context identifier cannot be only numeric - prefix a
         "c" whenever the contextIdentifier is only numeric
         
         [BUGFIX] #48319 SqlErrorException after upgrade to YAG 2.5.1 fixed
         
         [BUGFIX] #48227 Original string not translated in
         Partials/Image/LightBoxThumb.html
         
         [TASK] Visible thumbs and pre / post list use the same partial now


 - :Version:
         2.5.1
   
   :Changes:
         [BUGFIX]: itemRepository:getRandomItemUIDs: pickRandomItems based on
         whitelist. Respect enableFields on album and gallery
         
         [BUGFIX] ZipPackingService adds file extension if not configured,
         checks if itemList is empty, cleans up the download filename.
         
         [BUGFIX] Fix Zip download link should only download images of current
         album. Should only appear if current list has images.
         
         [BUGFIX] Fixes random selection of images.


 - :Version:
         2.5.0
   
   :Changes:
         [FEATURE] ZipDownload for albums
         
         [FEATURE] Replaced the multifile flash uploader (swfupload) with
         uploadify.
         
         [FEATURE] Implemented import via "directory on server" for TYPO3 6.0+
         
         [BUGFIX] Fixed Album creation for 6.1 Property Manager
         
         [BUGFIX] Adjusted ResolutionFileCacheRepository for 6.1 repositories
         
         [BUGFIX] Creation of a new gallery in 6.1 was broken due to date
         conversion error
         
         [BUGFIX] Fixed warning in HeaderInclusion utility


 - :Version:
         2.4.0
   
   :Changes:
         [TASK] Refactored MetaData Factory
         
         [TASK] Huge refactoring towards object manger usage
         
         [FEATURE] YAG now includes a social share widget. OpenGraph
         infogrmation is automatically added to the page if the facebook share
         is activated
         
         [FEATURE] Disqus commenting partial
         
         [FEATURE] Image-List can be rendered as RSS.
         
         [FEATURE] GPS Data are now parsed and available in the meta data
         
         [FEATURE] IPTC title added to the meta data
         
         [FEATURE] Image / Album / Gallery descriptions are now richtext fields
         
         [FEATURE] Javascript inclusion can now be configured by typoscript to
         header / footer and inline.
         
         [FEATURE] Using a checkbox in the YAG extension configuration, you can
         now configure YAG to flush its resolution file cache with the TYPO3
         cache clear command.
         
         [FEATURE] The download link beneath single images now sends the file
         as download while protecting it from grabbing the whole database
         
         [FEATURE] Albumlist is sortable by date
         
         [FEATURE] MetaData encoding is recognized and metadata is
         automatically encoded to UTF8
         
         [FEATURE] Improved Plugin Information
         
         [BUGFIX] Deleted Pages are not longer seletced in Backend. #46702
         
         [BUGFIX] Breadcrumb not showin "All Albums" in Album List
         
         [BUGFIX] Album title is now also linked
         
         [BUGFIX] #45073 Fixed pid detector. TYPO3 caching was not able to
         handle comments in multi-line method calls (parameters spread over
         several lines with comments in each line).
         
         [BUGFIX] Fix album / gallery count in backend list
         
         [BUGFIX] Fix RealURL caching Bug
         
         … lots of other minor bugfixes ...


 - :Version:
         2.3.0
   
   :Changes:
         ADD: UncachedItemList as PluginMode

         ADD: Flexform configurable filter to pick random items from itemList (sponsored byviazenetti.de)

         ADD: Links of ImageList items can be configured via flexform to link to another page and trigger YAG actions there.

         ADD: A flag in flexform can be used to reset the context

         ADD: PagerType can be set via typoscript. Availabe are “default” and “delta”

         ADD: YAG now officially supports all image-Types supportet by TYPO3

         ADD: #44570 YAG respects meaningfulTempFilePrefix in resolution filenames
         
         CHG: Improved Flexform Structure
         
         Lots of code-refactoring and clean-up!
         
         FIX: XMP Parser

         FIX: Mimetype is now set correctly

         FIX: Bug #43846 Invalid character in TS configuration for T3 < 6.0

         FIX: Bug #44505 Cash fails with RealURL hook because of an error in the url hashing

         FIX: Bug #44517 RealURL hook won´t work when plugin is inserted into root page

         FIX: Bug #44556 Frontend uploading: images are not saved on the server


 - :Version:
         2.2.1
   
   :Changes:
         Minor Bugfixes:
         
         - Removed confusing ItemList / AlbumList
         
         - Fixed some Label Bugs
         
         - Removed Delete Link in default single image view.


 - :Version:
         2.2.0
   
   :Changes:
         YAG is now compatible to TYPO3 6.0
         
         Implemented HTML5 Drag & Drop uploading.


 - :Version:
         2.1.0
   
   :Changes:
         The Backend Directory Importer now supports file mounts.
         
         Some minor changes.
         
         Fixed Bug: #42783, #43079


 - :Version:
         2.0.0
   
   :Changes:
         Major release, now supporting PIDs to store yag records.
         
         Make sure you read update section “ `Upgrading from yag 1.x.x to yag
         2.x.x
         <#1.4.5.Upgrading%20from%20YAG%201.x.x%20to%202.x.x%20|outline>`_ ”
         
         CHG: Source selector in flexform now requires PID to be selected

         ADD: #32110 access rights for galleries and albums

         ADD: #34477 yag asks you to mark page as yag folder / select yag folder if you use module on a page that is not a yag folder yet.

         ADD: Updated documentation to match :Changes: in v2.0.0

         CHG: yag 2.0 depends on pt\_extlist 1.0.0 and pt\_extbase 1.0.0

         ADD: Frontend-Editing has been re-introduced

         CHG: All backend TypoScript is included as extension TypoScript so no inclusion of TypoScript is necessary anymore to work in backend.
         
         By version 2.0 we skipped compatibility with TYPO3 version 4.5! Make sure to update your TYPO3 version to 4.6 at least!


 - :Version:
         1.5.4
   
   :Changes:
         FIX: #41589 Fixed dependency to wrong pt\_extlist interface in 1.5.3


 - :Version:
         1.5.3
   
   :Changes:
         FIX: Fixed bug concerning deletion of albums due to missing dependency injection in domain models.


 - :Version:
         1.5.2
   
   :Changes:
         TER problems, no changes compared to 1.5.1


 - :Version:
         1.5.1
   
   :Changes:
         Fixed a lot of Bugs, thanks for your bug-reports and patches:
         
         #39211. Now missing directory is re-created if origs directory is
         deleted and file-not-found images
         
         can be created within this newly created directory.
         
         #37239 CSS does not align album/gallery description properly in
         frontend
         
         #39546 absRefPrefix not respected in Resource ViewHelper
         
         #34770: Problems with RealURL hook and defaultToHTMLsuffixOnPrev
         
         #35934: Random Single View tries to display not existent images.
         
         #39211: Better Error-Message if Original Images are moved
         
         #39540 Cyrillic letters are not properly saved in "Images Overview"
         
         #39006 Titles not editable in tab »edit images«
         
         #39466: Problem with result image creation in BE
         
         #38482 (Resolved): XMP-Parsing: Website is imported as Email


 - :Version:
         1.5.0
   
   :Changes:
         CHG: We now use jQuery fancybox as lightbox for the lightox theme,
         wich is also way more configurable compared to the old lightbox. The
         lightbox theme now uses squared thumbnails.
         
         FIX BUG: #34483, #34478, #34222, #33003, #32979


 - :Version:
         1.4.5
   
   :Changes:
         FIX: BUG #34166, #33905, # 33902, #32601. Thx to the bug reporters!


 - :Version:
         1.4.4
   
   :Changes:
         FIX: BUG #32769 (thx to Steffen Gebert), #32634, #32622 (thx to
         Steffen Gebert), #32623 (thx to Steffen Gebert)


 - :Version:
         1.4.2
   
   :Changes:
         FIX: BUG #32097, #32129, #32137


 - :Version:
         1.4.1
   
   :Changes:
         ADD: Bootstrap class to easily integrate YAG in a third party
         extension.
         
         ADD: Typoscript Settings can now be retrieved from
         configurationBuilder in a Javascript compliant format


 - :Version:
         1.4.0
   
   :Changes:
         ADD: ItemsPerPage can now be set via FlexFormADD: New widget „random
         image“ availableADD: Sorting of gallery list, album list and image
         list can now be set in FlexForm.FIX: Lightbox can now thumb through
         all images of an album not only paged items.FIX: Deletion of albums
         should now work again.RFT: Some code-refactoring.


 - :Version:
         1.3.3
   
   :Changes:
         FIX: Bug #31327, #31260, #31275 – made YAG compatible to V 4.6


 - :Version:
         1.3.2
   
   :Changes:
         FIX: Bug #30692, #30909


 - :Version:
         1.3.0/1.3.1
   
   :Changes:
         RFT: Removed unused controller actions from ext\_localconf.php

         ADD: Feature bulk edit for images and albumsADD: MetaData is now processed
         correctly

         ADD: Tags are now imported from keywords

         ADD: Gallery uid filter for filtering certain galleries in gallery list

         FIX: Call-time pass-by-reference in realUrl hook

         ADD: Russian translation, thanks to Sergey Alexandrov

         ADD: Images can now be sorted by different criteria in backend

         ADD: Resolutions can be rebuild for selected themes

         ADD: Status report now gives information about configuration and external libraries

         ADD: Newly imported images are now always added at the end of the album

         FIX: Sorting images in backend manually now works on each page individually

         FIX: Standalone template is working again

         DEL: Removed non-used import controllerADD: Filehash is now written to item on import. Prevention of duplicate import.

         FIX: Date can be set for gallery and album.

         RFT: Performance improvements in backend

         ADD: Added some styling to pager in backend
         
         FIX: Many minor and major bugfixes


 - :Version:
         1.2.4
   
   :Changes:
         FIX: It was not possible to delete images.


 - :Version:
         1.2.3
   
   :Changes:
         FIX: Fixed Bug #29187, #29393, #27964


 - :Version:
         1.2.1
   
   :Changes:
         CHG: Removed unused tabs from content element form

         FIX: Fixed Pager

         FIX: Removed warnings that showed up in different situations


 - :Version:
         1.2.0
   
   :Changes:
         RFT: Removed pt\_tools. YAG now uses pt\_extbase for external tools.

         FIX: Fixed Bug #27319, #27737, #27312, #27370 due to non existing original image file


 - :Version:
         1.1.9
   
   :Changes:
         ADD: Pager partial can now be set via TS

         CHG: Upload button in backend now looks like upload button


 - :Version:
         1.1.8
   
   :Changes:
         FIX: Removed some useless var\_dump()


 - :Version:
         1.1.7
   
   :Changes:
         ADD: Resolutions for album thumb and gallery thumb can now be set
         individually


 - :Version:
         1.1.6
   
   :Changes:
         FIX: Bug #27172 – Umlaute are now correctly displayed in Front- and
         Backend.


 - :Version:
         1.1.5
   
   :Changes:
         FIX: Bug #26740 – Insert plugin in backend crashes under some circumstances.

         FIX: Bug #26111 - Fileadmin importer is not able to import folders with blanks


 - :Version:
         1.1.4
   
   :Changes:
         DEL: Removed RBAC installation routineFIX: Added some escaping for
         title and descriptionRFT: Added some frontend stylingCHG: Added .jpeg,
         .JPG and .JPEG as possible file endings for importersRFT: Removed
         unused gallery:album mm table from SQL definition
         
         FIX: Some minor bugfixes


 - :Version:
         1.1.3
   
   :Changes:
         CHG: Improvements in performance. Tested handling of up to 50k images.
         Seems to be quite fast now :-)CHG: Directory importer comes with
         directory picker now.CHG: ZIP import now can handle zipped
         folders.FIX: BUG #25454, fixed 1st level resolution file cache.ADD:
         Added some documentation.


 - :Version:
         1.1.2
   
   :Changes:
         CHG: Changed TypoScript structure. Previously inserted plugins still
         remain functional, but if you edit the Plugin configuration, you have
         to select your gallery / album / item again.FIX: Paging in
         SpecificAlbum mode throws an exception. You have to edit your album
         and select the mode again.CHG: Plugins now displays mode / album /
         theme in the page content element overviewCHG: Album / gallery
         description is displayed in the module


 - :Version:
         1.1.1
   
   :Changes:
         CHG: Galleries and Albums are now again sortable. (a change in the
         database was necessary!)CHG: Complete Extension is now
         translatable.ADD: Added german translation (Thanks to Matthias
         Kuchem).CHG: Add all parameters to the URL instead of using the
         stateHashCHG: Removed all tables from the list module. All data should
         be administrated by the YAG module.CHG: ReolutionFileCache-Files are
         now identified by parameter hash.
         
         FIX: Many more minor bugs.


 - :Version:
         1.1.0
   
   :Changes:
         RFT: RBAC is no longer a dependency. Features will be outsourced to
         yag\_feedit extensionFIX: German translations are removed from JS
         filesFIX: Added lots of translationsRFT: Removed lots of CSS and
         JavaScript to make Backend work better (thx to Matthias!)ADD: Page
         cache is cleared, if objects changeFIX: Thumbs are now generated on
         Windows platformsFIX: Directory import now respects filetypes
         correctlyRFT: Image processing now uses T3 standard libs and has many
         configurations now


 - :Version:
         1.0.10
   
   :Changes:
         Bugfix release


 - :Version:
         1.0.9
   
   :Changes:
         Bugfix release


 - :Version:
         1.0.8
   
   :Changes:
         FIX: Fixed some bugs concerning contextIdentifier to enable tt\_news
         integration


 - :Version:
         1.0.7
   
   :Changes:
         FIX: Multiple instances of the plugin can now be positioned on the
         same page with different themesFIX: Bug #13820 – SWUploader not
         working without FE Session. Thanks to PETIT YannFIX: Bug #13822 - No
         thumbnails are created on Windows servers. Thanks to PETIT YannADD:
         Caching has been refactoredRFT: Image ViewHelper has been moved to
         another directoryADD: Implemented automatic cache cleaning, when
         objects changeCHG: Added lazy loading for domain modelsADD: Single
         image view now has Download-Link for full-res imageADD: Documentation


 - :Version:
         1.0.6
   
   :Changes:
         ADD: Implemented cachingADD: DocumentationRFT: Reduced number of SQL
         queries in Domain Model


 - :Version:
         1.0.5
   
   :Changes:
         Problems with TER upload – no changes


 - :Version:
         1.0.4
   
   :Changes:
         ADD: DocumentationFIX: Bug #13763 / display error message when static
         template is not includedADD: Breadcrumbs show "all galleries" when
         gallery list is shownADD: Implemented pageCacheManager,
         clearAllPageCacheAction to Backend ControllerFIX: #13775 Adding a new
         album to a gallery shows right gallery nowFIX: #13776 After importing
         from directory on server, the album list is shownFIX: Fixed bug in
         directory crawler


 - :Version:
         1.0.3
   
   :Changes:
         ADD: DocumentationADD: Some translationFIX: Dependencies are set
         correctly in ext\_emconf.php


 - :Version:
         1.0.0
   
   :Changes:
         First release of this extension.


.. ###### END~OF~TABLE ######

We are currently using GitHub.com for collaborative development. You
can find all commit messages and an up-to-date trunk of this extension
on:

https://github.com/yag-gallery

If you would like to join the team, send us an e-mail (info@yag-
gallery.de)


