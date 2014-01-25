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


Upgrading from YAG 1.x.x to 2.x.x
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

YAG version 2.0 and above uses Sysfolders to store its records instead
of storing the data on PID 0. For that reason you have to do some
manual adjustments when upgrading from version 1.x to 2.x.

Before you proceed with the steps described below, make sure, you have
created a sysfolder for yag as described in section “ `Setting up a
sysfolder for YAG
<#1.3.1.Setting%20up%20a%20sysfolder%20for%20YAG|outline>`_ ”. Without
this sysfolder, YAG won't work properly anymore!

After installing the current YAG, pt\_extlist and pt\_extbase you
first have to create a Sysfolder to store the existing YAG records in.
Refer to the section Installation for further details.

Select the “Gallery” Module and select the Sysfolder from the
pagetree. The module shows the message “There are no galleries
available yet.“. Chnage to the Gallery Maintenance Module using the
module selector:

|img-78|

The Maintenance Module now shows the database update wizzard:

|img-79|

The wizzard again explains what to do. Simply enter the PID of the
created Sysfolder and all records are moved there.

The last step you have to do, is to manually open every YAG instance
on your pages, and select the PID the records are now stored on
(hopefully you have not too much ;) ).

