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


Configuration possibilities in FlexForm
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^


Tab “General”
"""""""""""""

|img-84|

- **Plugin type** lets you chose what you want the plugin to do:
  
  - **Gallery** list shows a list of galleries
  
  - **Specific gallery** shows a single gallery as defined in „Source“ Tab
  
  - **Specific album** shows a single album as defined in „Source“ Tab
  
  - **Specific image** shows a single image as defined in „Source“ Tab
  
  - **AlbumList** shows a list of albums.
  
  - **ImageList** shows a list of images.
  
  - **RandomSingle** shows a single random image from sources defined in
    „Source“ Tab.

- **Theme** lets you chose the theme you want to use to style your
  gallery

- **Context Identifier** whenever you want to put more than one gallery
  plugin on a single page, you have to set up a context to make them
  work independently.


Tab “Source”
""""""""""""

You can select a source for your content element here. Depending on
whether you want to show gallery list, gallery, album or single image,
you have to select gallery, album or image respectively. The first tab
show all sysfolders / pages that are marked as YAG pages. If no pages
are displayed in this column, refer to section “ `Setting up a
sysfolder for YAG
<#1.3.1.Setting%20up%20a%20sysfolder%20for%20YAG|outline>`_ ”.

|img-86|


Tab „Gallery List“
""""""""""""""""""

|img-87|

You can set up gallery lists within this tab:

- **Items per page** : You can define, how many galleries should be
  shown on a single page. If you have more galleries,a pager will be
  used to limit the results.

- **Sort gallery list by** : You can set up which field you want to use
  for sorting galleries on a gallery list:
  
  - **None (respect sorting from theme)** : In this mode, the sorting
    defined in the current theme will be taken to sort galleries.
  
  - **Custom sorting (Sorting of galleries in backend)** : Will use the
    sorting defined in backend module for sorting galleries.
  
  - **Title** : Will use the gallery title for sorting
  
  - **Date** : Sort galleries by date gallery has been created in backend.
  
  - **Description** : Sort galleries by its description field.


**Tab „Album List“**
""""""""""""""""""""

|img-88|

You can configure album lists in this tab. See section about gallery
tab for details.


Tab „Item List“
"""""""""""""""

|img-89|

You can configure item lists in this tab. See section about gallery
tab for details.


Tab „Other“
"""""""""""

|img-90|

The only setting currently available on this tab is a PID of a page to
jump to if you are in random image mode and want to set a page on
which you want to jump to, if a random image is clicked.

