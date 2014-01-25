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


YAG Architecture
^^^^^^^^^^^^^^^^


Usage of other extensions
"""""""""""""""""""""""""

We mainly use 3 dependent extensions:

- **Extbase** as basic TYPO3 Extension Framework

- **pt\_extbase:** improvements to extbase. Custom controller,
  viewhelpers and utilities.

- **pt\_extlist** for rendering all sorts of lists like lists of
  galleries, albums or images. pt\_extlist does all the stuff like
  paging, filtering and sorting for us.


Domain Model
""""""""""""

The domain model of YAG is quite simple:

|img-99| We have the following domain objects:

- **Gallery** acts as a 'container' for everything. Inside a gallery,
  you can have multiple albums. Mind that an album can also belong to
  different galleries, what makes things a little more complicated...

- **Album** holds a set of images, which we call items in YAG (we call
  it items, because that could be other things except images, like
  videos etc.).

- **Item (Image)** holds all information of an image like its source
  path, filename and other data.

- **ItemMeta** holds meta-data information for an item. E.g. EXIF or
  IPTC.

- **ResolutionFileCache** holds caching information

We refer to the domain model of YAG as all objects that directly have
to do with the domain of our extension (remember – it's a gallery) and
have to be persisted in the database.


Further Domain Objects
""""""""""""""""""""""

Besides the model there are other domain objects used to handle
gallery related stuff. Those objects are not persisted and are
therefore not part of what we called the domain model above:

- **Configuration** keeps a set of configuration objects that implement
  an object oriented way to handle TypoScript configuration and
  validation.

- **Context** context is a container of other objects used to make it
  easier to set and access certain information. E.g. getting all images
  stored in an album is implemented via a list of images that is
  filtered by an album uid. Setting the album for the filter and
  accessing it afterwards is made quite simple using the context.

- **ImageProcessing** Where there are images, there has to be done
  different kinds of processing. E.g. resizing ofimages is done by the
  objects kept in this part of the domain.

- **Import** holds all objects and classes required for importing images
  to YAG.


Controllers
"""""""""""

As Extbase is implemented using the MVC paradigma, we have some
controllers handling all the requests coming from Browsers or other
applications from outside TYPO3.

|img-100| Our controllers each extend an abstract controller that
holds some functionality we require for YAG. This abstract controller
extends Extbase's ActionController. For a detailed explanation of how
controllers and actions are handled within TYPO3 and Extbase, refer to
the Extbase documentation.

