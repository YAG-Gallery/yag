

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


Extending via Signal/Slot
^^^^^^^^^^^^^^^^^^^^^^^^^


Provided Signals
""""""""""""""""

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Class
         Class
   
   Signal Name
         Signal Name
   
   Description
         Description
   
   Parameter
         Parameter


.. container:: table-row

   Class
         Tx\_Yag\_Domain\_Import\_MetaData\_ItemMetaFactory
   
   Signal Name
         processMetaData
   
   Description
         Can be used to further adjust the meta data after it is processed by
         the metaDataFactory
   
   Parameter
         **metaData** : Reference to the metaData array including the extracted
         raw meta Data.
         
         **fileName** : Path to the original image file name.


.. ###### END~OF~TABLE ######

