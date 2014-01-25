

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


Open Issues for version 1.x
^^^^^^^^^^^^^^^^^^^^^^^^^^^

- Ajax-updating problems: There are some widgets like pagers in the
  backend, that are not updated when an Ajax request is handled. For
  example the number of items in an album is not updated, if an album
  gets deleted.

- Role-Management: Although we have a role-management implemented in
  YAG, there is no administration view to set up users etc. that are
  equipped with roles. This will come with Frontend-Editing in a future
  version.

- Categories / Subalbums: We are working on this and are still waiting
  for donation. We hope to be able to relase categories with version 3.0

