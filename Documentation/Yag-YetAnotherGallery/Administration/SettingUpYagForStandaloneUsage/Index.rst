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


Setting up YAG for standalone usage
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

WARNING: The standalone theme of YAG is currently not maintained
anymore – so use this with care!

YAG ships with a TypoScript Template that lets you install YAG
standalone, without requiring a page hierarchy or anything. You only
have to set up a single page in backend and include the standalone TS-
Template. Here are the steps:

#. Create a new, empty page where you want to have YAG standalone
   installed.

#. |img-80| Create a new TypoScript Template using the template module on
   this page. Click “Create template for a new site”

#. |img-81| Within your new template, remove anything from “Setup” and
   open the tab “Includes”. Select “Standalon (yag)” from Include
   statics:

#. Save your TS template and you are done!

