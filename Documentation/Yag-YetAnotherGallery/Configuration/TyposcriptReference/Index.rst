

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


TypoScript Reference
^^^^^^^^^^^^^^^^^^^^


plugin.tx\_yag.settings
"""""""""""""""""""""""

This is the main section of our extension. All non-framework-specific
configuration goes here.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:
   
   Default
         Default:


.. container:: table-row

   Property
         crawler
   
   Data type
         array
   
   Description
         Settings for the YAG file crawler used for directory import.
   
   Default


.. container:: table-row

   Property
         accessDenied
   
   Data type
         array
   
   Description
         Holds a controller / action pair, that defines which controller and
         action is called whenever access is denied for an action.
         
         Example:
         
         ::
         
            accessDenied {
                controller = Gallery
                action = list
            }
         
         This will show list action of Gallery controller, whenever access is
         denied.
   
   Default


.. container:: table-row

   Property
         sysImages
   
   Data type
         array
   
   Description
         Holds an array of paths for different images used throughout the
         extension.
   
   Default


.. container:: table-row

   Property
         themes
   
   Data type
         array
   
   Description
         Holds an array of themes.
   
   Default


.. container:: table-row

   Property
         extlist
   
   Data type
         array
   
   Description
         Holds settings for pt\_extlist extension. Take a look at the
         pt\_extlist documentation for further information.
   
   Default


.. container:: table-row

   Property
         importer
   
   Data type
         array
   
   Description
         Holds settings for import.
   
   Default


.. container:: table-row

   Property
         overwriteFlexForm
   
   Data type
         array
   
   Description
         Use this to overwrite settings made in flexform For example to force
         the same theme in alle instances of the plugin.
         
         ::
         
            overwriteFlexForm {
                         contextIdentifier =
                         contextReset =
            
                         theme =
                         context {
                                 selectedPid =
                                 selectedGalleryUid =
                                 selectedAlbumUid =
                                 selectedItemUid =
            
                                 galleryList {
                                         itemsPerPage =
                                         sorting {
                                                 field =
                                                 direction =
                                         }
                                 }
            
                                 albumList {
                                         itemsPerPage =
                                         sorting {
                                                 field =
                                                 direction =
                                         }
                                 }
            
                                 itemList {
                                         itemsPerPage =
                                         sorting {
                                                 field =
                                                 direction =
                                         }
            
                                         linkMode =
                                         linkTargetPageUid =
                                         linkTargetPluginMode =
            
                                         filter {
                                                 random =
                                         }
                                 }
                         }
                 }
   
   Default


.. ###### END~OF~TABLE ######


config.tx\_yag.settings.upload.multifile
""""""""""""""""""""""""""""""""""""""""

Configuration for the multifile uploader

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:
   
   Default
         Default:


.. container:: table-row

   Property
         file\_size\_limit
   
   Data type
         string
   
   Description
         Size limit in Mb
   
   Default
         1000


.. container:: table-row

   Property
         file\_upload\_limit
   
   Data type
         int
   
   Description
   
   
   Default
         1000


.. container:: table-row

   Property
         file\_types
   
   Data type
         string
   
   Description
   
   
   Default
         \*.jpg;\*.jpeg;\*.JPG;\*.JPEG


.. container:: table-row

   Property
         button\_image\_url
   
   Data type
         string
   
   Description
   
   
   Default
         EXT:yag/Resources/Public/Icons/XPButtonUploadText\_61x22.png


.. container:: table-row

   Property
         available
   
   Data type
         Int
   
   Description
   
   
   Default
         1


.. ###### END~OF~TABLE ######


config.tx\_yag.settings.upload.dragNDrop
""""""""""""""""""""""""""""""""""""""""

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:
   
   Default
         Default:


.. container:: table-row

   Property
         maxFiles
   
   Data type
         Int
   
   Description
         Size Limit in Mb
   
   Default
         1000


.. container:: table-row

   Property
         maxFileSize
   
   Data type
         int
   
   Description
   
   
   Default
         1000


.. container:: table-row

   Property
         available
   
   Data type
         Int
   
   Description
   
   
   Default
         1


.. ###### END~OF~TABLE ######


config.tx\_yag.settings.importer
""""""""""""""""""""""""""""""""

Configuration for importers

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:
   
   Default
         Default:


.. container:: table-row

   Property
         parseMetaData
   
   Data type
         bool
   
   Description
         If set to 1, meta data of imported images is parsed and written to
         itemMeta table.
   
   Default
         1


.. container:: table-row

   Property
         supportedFileTypes
   
   Data type
         String
   
   Description
         Define the supported file types.
   
   Default
         jpg,jpeg,gif,png


.. container:: table-row

   Property
         generateTagsFromMetaData
   
   Data type
         bool
   
   Description
         If set to 1, keywords from meta data are imported as tags in
         corresponding table.
   
   Default
         1


.. container:: table-row

   Property
         generateResolutions
   
   Data type
         csv
   
   Description
         Comma-separated list of themes for which resoluotions are created,
         when image is imported.
   
   Default
         backend


.. container:: table-row

   Property
         importFileMask
   
   Data type
         string
   
   Description
         File mask (UNIX file mask like 666) which is used on UNIX systems for
         imported files.
   
   Default
         660


.. container:: table-row

   Property
         titleFormat
   
   Data type
         array
   
   Description
         Set the title of the uploaded image autmatically from the images
         filename or its meta data.
         
         Example:
         
         titleFormat = TEXT
         
         titleFormat.dataWrap = {field:fileName} by {field:author} /
         {field:artistWebsite}
         
         Available fields are:
         
         \- origFileName - the original filename of the import file
         
         \- fileName - Formated filename (suffix removed)
         
         And the fields of the imported meta data:
         
         \- author
         
         \- copyright
         
         \- artistMail
         
         \- artistWebsite
         
         \- description
         
         -cameraModel
         
         \- lens
         
         \- focalLength
         
         \- shutterSpeed
         
         \- aperture
         
         \- flash
         
         \- keywords
         
         \- description
         
         \- tags
   
   Default
         titleFormat = TEXT
         
         titleFormat.dataWrap = {field:fileName}


.. container:: table-row

   Property
         descriptionFromat
   
   Data type
         array
   
   Description
         Example:
         
         descriptionFormat = TEXT
         
         descriptionFormat.dataWrap = {field:description}
         
         Fields are the same as in titleFormat
   
   Default
         descriptionFormat = TEXT
         
         descriptionFormat.dataWrap = {field:description}


.. ###### END~OF~TABLE ######


plugin.tx\_yag.settings.imageProcessor
""""""""""""""""""""""""""""""""""""""

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:
   
   Default
         Default:


.. container:: table-row

   Property
         meaningfulTempFilePrefix
   
   Data type
         integer
   
   Description
         MeaningfulTempFilePrefix specifies the length of the chunk of the
         original filename which is prefixed to the temp filename
   
   Default
         config.meaningfulTempFilePrefix


.. ###### END~OF~TABLE ######


config.tx\_yag.settings.customMetaData
""""""""""""""""""""""""""""""""""""""

Custom meta data fields can be defined individually per TYPO3
instance. They can be edit via the backend form and displayed within
your frontend theme.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:
   
   Default
         Default:


.. container:: table-row

   Property
         customMetaData
   
   Data type
         array
   
   Description
         Define multiple meta data fields for your own purpose.
         
         ::
         
            customMetaData {
                    people {
                            title = People
                            type = string
                    }
            }
   
   Default


.. ###### END~OF~TABLE ######


plugin.tx\_yag.settings.sysImages
"""""""""""""""""""""""""""""""""

Configuration for all kinds os images used for skinning.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:
   
   Default
         Default:


.. container:: table-row

   Property
         imageNotFound
   
   Data type
         Item file description
   
   Description
         Configures a path, title and description for an item.
         
         Example:
         
         ::
         
            sysImages {
                 imageNotFound {
                         sourceUri = typo3conf/ext/yag/Resources/Public/Icons/imageNotFound.jpg
                         title = No image found.
                         description = No image found.
                 }
            }
         
         Mind that the sourceUri of the image must be relative to TYPO3 root.
   
   Default


.. ###### END~OF~TABLE ######


plugin.tx\_yag.settings.themes
""""""""""""""""""""""""""""""

Most of the configuration for YAG can be found in themes. We have a
default theme, where you can find all the settings available in YAG.
See section 'Themes and Templates' in the Developers' chapter for
further information on how to extend themes and write your own themes.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:
   
   Default
         Default:


.. container:: table-row

   Property
         [your\_theme\_name]
   
   Data type
         array
   
   Description
         You can define your own themes here. YAG ships with a default theme
         and a backend theme.
   
   Default


.. ###### END~OF~TABLE ######


plugin.tx\_yag.settings.themes.default
""""""""""""""""""""""""""""""""""""""

In this section, you can find the settings for the default theme which
acts as basis for all other themes. Best practice for developin your
own themes is to extend this theme with your own theme like that:

::

   plugin.tx_yag.themes.[your_theme_name] < plugin.tx_yag.themes.default
   plugin.tx_yag.themes.[your_theme_name] {
      # … your theme specific settings
   }

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:
   
   Default
         Default:


.. container:: table-row

   Property
         showBreadcrumbs
   
   Data type
         bool
   
   Description
         If set to 1, breadcrumbs are shown as navigation.
   
   Default
         1


.. container:: table-row

   Property
         resolutionConfigs
   
   Data type
         array
   
   Description
         Configuration for image resolutions. You can define the resolutions of
         thumbnails, single images etc. here.
         
         ::
         
            resolutionConfigs {
                 thumb {
                         width = 150c
                         height = 150c
                 }
                 
                 medium {
                         maxW = 800
                         maxH = 600
                 }
            }
         
         In the default theme, thumb for thumbnails and medium for medium sized
         images in single view are defined and used. For your own template, you
         can define any kind of resolutions with the name of your choice.
         
         A resolution configuration can consist of any parameter that the TYPO3
         IMAGE type provides, including image manipulation via GIFBUILDER.
   
   Default


.. container:: table-row

   Property
         gallery
   
   Data type
         array
   
   Description
         Gallery specific settings of your theme. See section below
   
   Default


.. container:: table-row

   Property
         album
   
   Data type
         array
   
   Description
         Album specific settings of your gallery. See section below
   
   Default


.. container:: table-row

   Property
         extlist
   
   Data type
         array
   
   Description
         This section configures pt\_extlist specific settings for YAG. See
         pt\_extlist documentaiton for further information.
   
   Default


.. container:: table-row

   Property
         itemList
   
   Data type
         array
   
   Description
         This section configures the list of images shown, when you click on an
         album. See section below for further information.
   
   Default


.. container:: table-row

   Property
         item
   
   Data type
         array
   
   Description
         This section configures single view of an item. See section below for
         further information.
   
   Default


.. container:: table-row

   Property
         includeLibJS
   
   Data type
         CSV
   
   Description
         Comma-separated list of defined librarys from wich you want to include
         javascript files.
         
         Defined libraries are jQuery, jQueryUi, jQueryShadowBox
   
   Default


.. container:: table-row

   Property
         includeLibCSS
   
   Data type
         CSV
   
   Description
         Comma-separated list of defined librarys from wich you want to include
         CSS files.
         
         Defined libraries are jQuery, jQueryUi, jQueryShadowBox
   
   Default


.. container:: table-row

   Property
         includeJS
   
   Data type
         arary
   
   Description
         Define JS files which should be included in the page header. Same
         schema as in page.
   
   Default


.. container:: table-row

   Property
         includeJS
   
   Data type
         array
   
   Description
         Define CSS files which should be included in the page header. Same
         schema as in page.
   
   Default


.. ###### END~OF~TABLE ######


plugin.tx\_yag.settings.themes.default.feed
"""""""""""""""""""""""""""""""""""""""""""

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:
   
   Default
         Default:


.. container:: table-row

   Property
         Active
   
   Data type
         bool
   
   Description
         Activate the feed
   
   Default
         0


.. container:: table-row

   Property
         title
   
   Data type
         String
   
   Description
         The feeds title
   
   Default
         YAG Gallery Feed


.. container:: table-row

   Property
         description
   
   Data type
         String
   
   Description
         The feeds description
   
   Default
         ::
         
            Description


.. container:: table-row

   Property
         Author
   
   Data type
         String
   
   Description
         The feeds author
   
   Default
         The Photographer


.. container:: table-row

   Property
         Language
   
   Data type
         String
   
   Description
         The feed language
   
   Default
         ::
         
            de_de


.. ###### END~OF~TABLE ######


plugin.tx\_yag.settings.themes.default.galleryList
""""""""""""""""""""""""""""""""""""""""""""""""""

Gallery specific settings of your theme.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:
   
   Default
         Default:


.. container:: table-row

   Property
         columnCount
   
   Data type
         int
   
   Description
         Number of columns used for rendering gallery overview.
   
   Default
         2


.. container:: table-row

   Property
         GalleryThumbPartial
   
   Data type
         String
   
   Description
         Pathand filename of the gallery thumb partial.
   
   Default
         Gallery/GalleryThumb.html


.. container:: table-row

   Property
         pagerIdentifier
   
   Data type
         String
   
   Description
         Pager Identifier
         
         default / delta
   
   Default
         ::
         
            Default


.. container:: table-row

   Property
         pagerPartial
   
   Data type
         String
   
   Description
         Path to Pagerpartial
         
         - Pager/Default
         
         - Pager/Delta
   
   Default
         ::
         
            Pager/Default


.. ###### END~OF~TABLE ######


plugin.tx\_yag.settings.themes.default.albumList
""""""""""""""""""""""""""""""""""""""""""""""""

Album specific settings of your theme.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:
   
   Default
         Default:


.. container:: table-row

   Property
         itemsPerPage
   
   Data type
         int
   
   Description
         Number of albums shown on album list
   
   Default
         12


.. container:: table-row

   Property
         showBreadcrumbs
   
   Data type
         bool
   
   Description
         If set to 1, breadcrumbs are shown on album page.
   
   Default
         1


.. container:: table-row

   Property
         columnCount
   
   Data type
         int
   
   Description
         Number of columns used for rendering album list.
   
   Default
         2


.. container:: table-row

   Property
         AlbumThumbPartial
   
   Data type
         String
   
   Description
         Pathand filename of the album thumb partial.
   
   Default
         Album/AlbumThumb.html


.. container:: table-row

   Property
         pagerIdentifier
   
   Data type
         String
   
   Description
         Pager Identifier
         
         default / delta
   
   Default
         ::
         
            Default


.. container:: table-row

   Property
         pagerPartial
   
   Data type
         String
   
   Description
         Path to Pagerpartial
         
         - Pager/Default
         
         - Pager/Delta
   
   Default
         ::
         
            Pager/Default


.. ###### END~OF~TABLE ######


plugin.tx\_yag.settings.themes.default.extlist
""""""""""""""""""""""""""""""""""""""""""""""

pt\_extlist specific settings of your theme. See pt\_extlist
documentation for further information.


plugin.tx\_yag.settings.themes.default.itemList
"""""""""""""""""""""""""""""""""""""""""""""""

Configuration of image list of your theme.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:
   
   Default
         Default:


.. container:: table-row

   Property
         itemsPerPage
   
   Data type
         int
   
   Description
         Number of images shown on a single page.
   
   Default
         12


.. container:: table-row

   Property
         columnCount
   
   Data type
         int
   
   Description
         Number of columns used to render images on image list.
   
   Default
         4


.. container:: table-row

   Property
         showTitle
   
   Data type
         bool
   
   Description
         If set to 1, album title is shown on overview page.
   
   Default
         1


.. container:: table-row

   Property
         imageThumbPartial
   
   Data type
         path
   
   Description
         Path to partial used to render an image in image list. This can be
         Extbase path (relative to EXT:yag/Resources/Private/Partials):
         
         ::
         
            Image/ImageThumb
         
         or common TS resource path to set offer paths:
         
         ::
         
            EXT:yag/Resources/Private/Partials/Image/ImageThumb.html
   
   Default
         ::
         
            Image/ImageThumb


.. container:: table-row

   Property
         imageAdminThumbPartial
   
   Data type
         path
   
   Description
         Not used at the moment.
   
   Default


.. container:: table-row

   Property
         pagerPartial
   
   Data type
         path
   
   Description
         Path to partial used to render a pager in image list. This can be
         Extbase path (relative to EXT:yag/Resources/Private/Partials):
         
         ::
         
            Pager
         
         or common TS resource path to set offer paths:
         
         ::
         
            EXT:yag/Resources/Private/Partials/Pager.html
         
         This is especially useful, if you want to add additional parameters to
         the links generated by the pager, as in the following example:
         
         ::
         
            <extlist:link.action addQueryString="true" controller="{controller}" action="{action}" arguments="{extlist:namespace.GPArray(object:'{pagerCollection}' arguments:'page:{i}')}">{pageNumber}</extlist:link.action>
   
   Default
         ::
         
            Pager


.. container:: table-row

   Property
         pagerIdentifier
   
   Data type
         String
   
   Description
         Pager Identifier
         
         default / delta
   
   Default
         ::
         
            Default


.. container:: table-row

   Property
         pagerPartial
   
   Data type
         String
   
   Description
         Path to Pagerpartial
         
         - Pager/Default
         
         - Pager/Delta
   
   Default
         ::
         
            Pager/Default


.. container:: table-row

   Property
         linkMode
   
   Data type
         string
   
   Description
         Link mode [show\|link]
   
   Default
         ::
         
            show


.. container:: table-row

   Property
         linkTargetPageUid
   
   Data type
         integer
   
   Description
         The page uid of the target page
   
   Default


.. container:: table-row

   Property
         linkTargetPluginMode
   
   Data type
         string
   
   Description
         The plugin mode on the target page
   
   Default
         ::
         
            Album


.. container:: table-row

   Property
         Filter.random
   
   Data type
         Boolean
   
   Description
         Activates the random uid filter
   
   Default
         ::
         
            0


.. ###### END~OF~TABLE ######


plugin.tx\_yag.settings.themes.default.itemList.zipDownload
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:
   
   Default
         Default:


.. container:: table-row

   Property
         active
   
   Data type
         int
   
   Description
         Activate / Deactivate the zip download
   
   Default
         0


.. container:: table-row

   Property
         fileNameFormat
   
   Data type
         array
   
   Description
         Defines the zip file name. Currently available fields are gallery and
         album:
         
         fileNameFormat = TEXT
         
         fileNameFormat.dataWrap = {field:album}.zip
   
   Default
         {field:album}.zip


.. container:: table-row

   Property
         resolution
   
   Data type
         String
   
   Description
         Name of the resolution in which the images are packed.
   
   Default
         ::
         
            original


.. ###### END~OF~TABLE ######


plugin.tx\_yag.settings.themes.default.item
"""""""""""""""""""""""""""""""""""""""""""

Configuration of image single view of your theme.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:
   
   Default
         Default:


.. container:: table-row

   Property
         showItemMeta
   
   Data type
         bool
   
   Description
         If set to 1, metadata of image will be shown in single view.
   
   Default
         1


.. container:: table-row

   Property
         itemMetaPartial
   
   Data type
         path
   
   Description
         Path to partial used to render image meta data (EXIF etc.). This can
         be Extbase path (relative to EXT:yag/Resources/Private/Partials):
         
         ::
         
            Image/ImageMeta
         
         or common TS resource path to set offer paths:
         
         ::
         
            EXT:yag/Resources/Private/Partials/Image/ImageMeta.html
   
   Default
         ::
         
            Image/ImageMeta


.. container:: table-row

   Property
         showTitle
   
   Data type
         bool
   
   Description
         Show the item title beneath the image
   
   Default
         ::
         
            1


.. container:: table-row

   Property
         showDescription
   
   Data type
         bool
   
   Description
         Show the item description beneath the image
   
   Default
         ::
         
            1


.. container:: table-row

   Property
         showPager
   
   Data type
         Bool
   
   Description
         Show the back / forward pager
   
   Default
         ::
         
            1


.. container:: table-row

   Property
         showItemMeta
   
   Data type
         bool
   
   Description
         Show Meta information for an item (including title and description)
   
   Default
         ::
         
            1


.. container:: table-row

   Property
         showOriginalDownloadLink
   
   Data type
         bool
   
   Description
         Show download link to original item
   
   Default
         ::
         
            1


.. container:: table-row

   Property
         pagerPartial
   
   Data type
         string
   
   Description
         Path to pager partial
   
   Default
         ::
         
            Pager/SingleItem


.. container:: table-row

   Property
         itemMetaPartial
   
   Data type
         string
   
   Description
         Path to item meta partial
   
   Default
         ::
         
            Image/ImageMeta


.. ###### END~OF~TABLE ######


plugin.tx\_yag.settings.themes.default.item.interaction
"""""""""""""""""""""""""""""""""""""""""""""""""""""""

Configures optional visitor interaction services

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:
   
   Default
         Default:


.. container:: table-row

   Property
         socialSharePrivacy
   
   Data type
         array
   
   Description
         Configuration for the social share privacy widget:
   
   Default


.. container:: table-row

   Property
         disqus.path
   
   Data type
         string
   
   Description
         Path to the partial
   
   Default
         Interaction/SocialSharePrivacy


.. container:: table-row

   Property
         socialSharePrivacy.show
   
   Data type
         bool
   
   Description
         Activate the widget
   
   Default
         0


.. container:: table-row

   Property
         socialSharePrivacy.settings
   
   Data type
         array
   
   Description
         info\_link = http://panzi.github.com/SocialSharePrivacy/
         
         language = en
         
         services {
         
         buffer.status = false
         
         delicious.status = false
         
         disqus.status = false
         
         mail.status = false
         
         flattr.status = false
         
         linkedin.status = false
         
         pinterest.status = false
         
         reddit.status = false
         
         stumbleupon.status = false
         
         tumblr.status = false
         
         xing.status = false
         
         facebook.status = true
         
         twitter.status = true
         
         gplus.status = true
         
         }
   
   Default


.. container:: table-row

   Property
         socialSharePrivacy.path
   
   Data type
         string
   
   Description
         Path to the partial
   
   Default
         Interaction/SocialSharePrivacy


.. container:: table-row

   Property
         disqus.show
   
   Data type
         bool
   
   Description
         Activate the widget
   
   Default
         0


.. container:: table-row

   Property
         disqus.settings
   
   Data type
         array
   
   Description
         disqus\_shortname = YourDisQusName
   
   Default


.. ###### END~OF~TABLE ######


module.tx\_yag.settings
"""""""""""""""""""""""

Holds settings for the backend of YAG. The content of this setting is
the same as plugin.tx\_yag.settings.

