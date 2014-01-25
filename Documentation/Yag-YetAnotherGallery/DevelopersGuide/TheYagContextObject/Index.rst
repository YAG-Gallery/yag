

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


The YAG context object
^^^^^^^^^^^^^^^^^^^^^^

Whenever YAG is used on a page (whether as content-element or in
standalone mode), there are many dependencies to be resolved and a lot
of environment to be set up. To make it easier for a developer to
handle all this stuff, we implemented what we call a  **context** . A
context is a container giving you a nice way to set and get
information gathered within a lifecycle of YAG. This might be
configuration as well as currently set parameters. To get an
impression of what is stored within the context container, here is a
little diagram again:

TODO: finish me!

