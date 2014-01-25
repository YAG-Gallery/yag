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


Image Storage and Resolution File Cache
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

A problem for every gallery application is the storage of original and
resized images.


Storage of original images
""""""""""""""""""""""""""

Each image in YAG is stored as original image. This image is never
changed by YAG. You find those images in the folder you set in the
Extension Manager as 'origFilesRoot':

|img-102|

Whenever you use an original image in an album, an item object is
created. This item object has a UID and an albumUid as well as a
sourceUri pointing to the file inside the origFilesRoot where the
original file is stored. For each album there is an individual folder
in the origFilesRoot named like the UID of the album. Each item
(image) is stored, using its UID as filename:

|img-103|


Storage of resized (cached) images
""""""""""""""""""""""""""""""""""

Whenever you use an item in your albums, YAG will generate resized
versions of this item according to the resolution settings in your
theme. So for each item and for each resolution there will be a cached
version on your server. YAG stores those images in a chaos-filesystem.
Chaotic means, that YAG will automatically create a folder structure
so that no more than a hundred files are located in one folder. Many
files in the same folder will make the filesystem slow.

So here is how it works:

- Each item holds a  **Tx\_Yag\_Domain\_Model\_ResolutionFileCache**
  object for each resolution set in TypoScript.

- A cached image is written to the server for each resolution. A hashed
  string is used for the filename to prevent traversing access to the
  files.

- The resolution file cache object holds the resolution and the path to
  the cached file on the server.

The root folder of the hash filesystem root is set in your Extension
Manager:

|img-104|

The following diagram shows how the resolution file cache works:

|img-105|

