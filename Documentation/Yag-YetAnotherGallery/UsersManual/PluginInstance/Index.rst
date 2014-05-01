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


Plugin Instance
^^^^^^^^^^^^^^^^

|img-PluginInstance|

To add a new YAG plugin to your website, add a new content element, go to the tab plugins and select the YAG plugin.

Tab General
""""""""""""""""""""""""""""

|img-TabGeneral|

**Plugin Mode**

The plugin mode defines the entry point to your image library and behavior of the plugin in the frontend.

* *Gallery List* Shows all galleries of the selected sysfolder
* *Specific Gallery* Shows a list of albums of the selected gallery
* *Specific Album* Shows the images of the selected album
* *Specific Image* Shows a single, selected image
* *Generic Album List* A Typsoscript defined selection of your albums
* *Generic Image List* A Typsoscript defined selection of your items
* *Image List (Uncached)* A Typsoscript defined selection of your items which is uncached. For example for an random image display.

**Theme**

Defines the theme for this instance. Two themes are delivered with YAG. Others can added with additional extensions (e.g. yag_themepack_jquery) or you can define your own themes easily.

* *Default* Default Extension with a static HTML Gallery / Album / Image view.
* *Lightbox* Inherited from Default but uses a lightbox to display the full size images in the album view.

**Context**

The configurations of YAG are defined within a context. This feature makes it possible to place different instances of YAG on one page using different configurations.
If the context is empty, it is filled with the content uid of the plugin. You can set the context to fixed value if you want an interaction between two separate plugins.

**Reset Context**

If you need to place two plugins with the same context on the same page but it is necessary to parse the configuration for both plugins separately, you can check the reset context o

Tab Source
""""""""""""""""""""""""""""

|img-TabSource|

In this tab you can set the **filters** for this plugin. It depends on the selected plugin mode, which part of the selection is respected.

Tab Gallery List
""""""""""""""""""""""""""""

|img-TabGalleryList|

**Items per page**

Define how many galleries you want to see on one page. Without a value, this option is defined by the theme.

**Sorting**

Sort the items by different criteria ascending or descending.

Tab Album List
""""""""""""""""""""""""""""

|img-TabAlbumList|

**Items per page**

Define how many albums you want to see on one page. Without a value, this option is defined by the theme.

**Sorting**

Sort the items by different criteria ascending or descending.

Tab Item List
""""""""""""""""""""""""""""

|img-TabItemList|

**Items per page**

Define how many images you want to see on one page. Without a value, this option is defined by the theme.

**Sorting**

Sort the items by different criteria ascending or descending.

**Image Link**

The image link in the default theme has two different behaviors:

* **Show Image** The image is shown together with its meta data.
* **Detail Page** The user is redirected to a detail page. On the selected target page, the clicked image can be shown, the album which contains the image or the containing gallery. This target plugin mode can be selected with the *Plugin Mode on Target Page* select-box.
**NOTE:** To transfer the link data from the source to the target YAG instance, both instance have to have the same *context identifier* - so you have to set the context identifier in both plugins to the same value.


**Filter**

* **Pick random images** Randomly pick the amount of images you specified in the *Items per Page* field. To make that work, you have to chose the plugin mode *Image List (Uncached)*.