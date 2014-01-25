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


Setting up a random item list
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^


1. General Configuration
""""""""""""""""""""""""

First you select the Plugin Mode "ImageList (Uncached)". Hence the
name and unlike the other YAG modes, this mode is uncached and the
HTML is rendered on every reload. This is slower, than using the TYPO3
Cache, but necesarry to pick new random images on every reload.

For another new function described later in the article it is
necasarry to define a context. This can be every string you like, in
this example i choose yag.


2. Configure The ItemList
"""""""""""""""""""""""""

The Itemlist configuration received some new options in version 2.3.
For our purpose, the "Items per Page" option defines how many random
images are displayed.

There is also a new "Filter" selction at the bottom. Here i added a
filter to pick random images. Check this option.

That is all you have to do. With this configurartion, a set of 4
images is randomly picked from your images and displayed. A click on
the image opens a detail view of the image on the same page with the
default theme or renders a lightbox with the lightbox theme.

A comon use case is to use a list of random images as a teaser and
then jump to the containing album when clicked on an image. To
configure this behavior, you can use the new "Image Link" section. The
default "Image Link Mode" is to use the configuration from the theme.
When you set it to "Detail Page", the image links to a detail page
which can be chosen with the next option.

|img-85| The option "Plugin Mode on Target Page" defines whcih YAG
mode should be triggered on the target page. You have the option to
show the gallery or the album containing the image, or just show the
detail view of this image on the target page.

Here comes the context identifier into play. To make this work, you
have to set the context identifier of the YAG instance on the target
page to the same as in the random list.

