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


Get feedback for your images
^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The default theme offers some easy to configure user-feedback and
social network widgets.


Add social share buttons
""""""""""""""""""""""""

YAG offers an easy to include lightwight privacy aware social widget.
All you have to do to add some social share buttons beneath your
images is to activate the widget using a line of typoscript:

plugin **.** tx\_yag **.** settings **.** themes **.** default **.**
item **.** interaction **.** socialSharePrivacy **.** show **=** 1

|img-68| Additional social networks can be configured, including
delicious, flattr, linkedin and many others. Visit the typoscript
reference for details.


Comments with Disqus
""""""""""""""""""""

With the disqus commets widget, you yan easily get feedback for your
images. To activate the widget, enable the widget vai typoscript:

plugin **.** tx\_yag **.** settings **.** themes **.** default **.**
item **.** interaction **.** disqus **{** settings **.**
disqus\_shortname **=** YorDisqusInstanceNameshow **=** 1 **}**

