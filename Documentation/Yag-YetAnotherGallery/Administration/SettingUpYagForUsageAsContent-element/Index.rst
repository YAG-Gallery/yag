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


Setting up YAG for usage as content-element
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

If you want to use YAG as content elements, here are the steps, you
have to follow:

#. Create a new page on which you want to include YAG.

#. |img-80| Create an extension template using Template module:

#. Edit the extension template and switch to the “Includes” tab. Include
   “Yet Another Gallery (yag)”:
   
   |img-82|

#. Save your TS template.

#. |img-83| Open the “Page” module and go to the page you just created.
   Insert a page content element. From the list of contents, chose
   “Plugins → YAG – Yet Another Gallery”:

#. Switch to the “Plugin” tab and you can configure your content element:

|img-84|

