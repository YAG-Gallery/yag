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


Importing YAG from TER
^^^^^^^^^^^^^^^^^^^^^^

Open up the Extension Manager and select 'Import Extension' from the
menu:

|img-69| Search for 'yag':

|img-70|

Click on the install button:

::

   |img-70| 
   

There will be a message informing you, that additional information has
to be given:

|img-71|

Click on 'Make updates' and you will get a form you have to submit:

|img-72|

There are two settings you have to make:

- **Path of directory where YAG should ...[hashFilesystemRoot]** : YAGwill create a hashed image for each image shown in different sizes. Those cached files need to be stored on your server. You have to determine here, which folder will be used to do that. Default is typo3temp/yag

- **Path of directory where YAG stores ...[origFilesRoot]** : YAG will store each original file on your server. You have to determine here, where YAG should store original files on your server. Default is fileadmin/yag

Click 'Update' to confirm those settings. A message will be shown
informing you about the state of the installation:

|img-73|

That's it. You have now successfully installed YAG on your server.

