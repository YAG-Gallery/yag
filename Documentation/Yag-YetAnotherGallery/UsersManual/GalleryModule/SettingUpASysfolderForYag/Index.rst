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


Setting up a sysfolder for YAG
""""""""""""""""""""""""""""""""""""""""""""""""""""

Since version 2.0 of YAG, you have to set up a sysfolder that contains
yag elements, e.g. galleries, albums and items. Without this
sysfolder, you won't be able to insert YAG plugins on your pages
later!

So first of all, create a new sysfolder and name it “yag sysfolder”
for example:

|img-18|

Now go to the page settings of this folder and mark the folder to
contain yag records:

|img-19|

After that, reload the page tree, the icon of the folder should change
to YAG icon:

|img-20|

You can now create your first gallery within this storage folder
following the instructions given below.

Whenever you select a page that is not marked as a YAG page, you get a
message like the following one:

|img-21|

Now you have to possibilities: either you select a page which is
already marked as a yag page using the select field or you use the
link “Mark this page as a yag sysfolder” if you want to mark the page
you currently opened as a yag page.

Without having a page marked as yag page, you won't be able to select
the yag records in your content element plugins. If you want to
upgrade from yag version 1.x.x where PIDs were not supported, refer to
section “ `Upgrading from YAG 1.x.x to 2.x.x
<#1.4.5.Upgrading%20from%20YAG%201.x.x%20to%202.x.x%20|outline>`_ ”.

