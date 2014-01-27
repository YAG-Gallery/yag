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


Screenshots
^^^^^^^^^^^


Frontend
""""""""

You can set up a list of galleries and use the as folders for your
albums. The galleries can be sorted and paged as a list:

|img-3|

Within each gallery you can have as many albums as you like.
These albums can be displayed as a list in the frontend:

|img-4|

Each album can be displayed as a list of images contained by this
album:

|img-5|

An image can be presented in many different ways, using different
templates and themes. Here is the standard template – showing the
image with some useful information:

|img-6|

If you like, you can also use a lightbox like here:

|img-7|

With version 1.4.0 we added a „random photo“ widget which shows a
random photo of a selected range of photos.

You can select from many different templates and plugins (like
JavaScript Lightboxes or Flash albums) to actually render your albums
on your site. It is one goal of YAG to enable you write your own
templates easily. Here is another example of a rendered album using
`SimpleViewer <http://typo3.org/extensions/repository/view/yag_theme_s
impleviewer/current/>`_ :

|img-8| To get an overview of currently available themes, please refer
to the demo section of our website: `http://www.yag-
gallery.de/examples/ <http://www.yag-gallery.de/examples/>`_


Backend
"""""""

YAG ships with a full-featured backend module that lets you
administrate your gallery easily. After installing YAG, you get a new
icon in the menu bar:

|img-9|

This will show an administration backend:

|img-10|

You can get a list of galleries, and for each gallery a list of albums
inside this gallery:

|img-11|

There is a administration view that lets you easily manipulate your
images in your albums. You can drag and drop images for sorting,
change titles and descriptions and set thumbnails for albums:

|img-12|

Several upload possibilities including Flash-Multifile-Uploader and
ZIP uploader make it easy to add images to your album:

|img-13|

Finally there is gallery maintenance module that gives you nice
statistics on the images in your gallery and lets you maintain the
resolution file cache:

|img-14| |img-15|


Inserting plugin via FlexForm
"""""""""""""""""""""""""""""

YAG comes with a very comfortable FlexForm that lets you select
albums, galleries and images easily:

|img-16|

After you inserted the plugin, you get some information about your
plugin in the page-module:

|img-17|

