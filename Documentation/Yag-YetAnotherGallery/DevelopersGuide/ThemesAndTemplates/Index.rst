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


Themes and Templates
^^^^^^^^^^^^^^^^^^^^

Themes are used to configure almost everything in YAG. This enables
you to change almost everything using your own themes. The theme
selector in your FlexForm lets you chose the theme you want to use for
showing your gallery widgets.


What is included by a theme
"""""""""""""""""""""""""""

A theme mainly consists of some TypoScript configuration and a set of
FLUID templates. There also might be some FLUID partials and third
party JavaScript libraries and CSS files. Take a look at the
filestructure to get an impression of what are the contents of a
theme:

|img-106|


How to overwrite templates used for Controller/Action pairs
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

We extended Extbase's default ActionController in such a way, that you
can overwrite each template for each controller / action pair using
TypoScript. Let's say, you have a controller called 'ItemList' and an
action 'list'. Then you can overwrite the template used for this
controller/action pair using the following TypoScript configuration:

::

   ##Overwriting template path for ItemList->listAction()
   plugin.tx_yag.settings.controller.ItemList.list.template = EXT:<ext_key>/<path_to_template>
   
   ## For example:
   plugin.tx_yag.settings.controller.ItemList.list.template = EXT:yag/Resources/Private/Template/ItemList/
      list.html

This feature enables you to set templtes for YAG controllers to html
files outside the extension itself, which is currently not possible
using Extbase.

So here is another example on how to set template paths for a theme to
template files that ship with the theme's extension:

::

   plugin.tx_yag.settings.themes.simpleViewer {
      controller {
         ItemList {
            list.template = EXT:yag_theme_simpleviewer/Resources/Private/Templates/ItemList/List.html
            xmlList.template = EXT:yag_theme_simpleviewer/Resources/Private/Templates/ItemList/XmlList.html
         }
      }
   }

You can see, that you can set the template paths to files included by
your theme-extension and not by YAG.


Which objects are available in your templates
"""""""""""""""""""""""""""""""""""""""""""""

After you know how to set templates for a controller / action pair,
the next question should be how you can access data from within your
templates. Therefore you have to know, how data is assigned to your
template. The easiest way to find this out, is to take a look in your
controller's code:

publicfunctionnewAction(

Tx\_Yag\_Domain\_Model\_Gallery$gallery=NULL,

Tx\_Yag\_Domain\_Model\_Album$newAlbum=NULL) {

$selectableGalleries=$this->objectManager->get(

'Tx\_Yag\_Domain\_Repository\_GalleryRepository')->findAll();

$this->view->assign('selectableGalleries',$selectableGalleries);

$this->view->assign('selectedGallery',$gallery);

$this->view->assign('newAlbum',$newAlbum);

}

So here you can see, that there are three objects passed to your
template: 'selectableGalleries', 'selectedGallery' and 'newAlbum'. You
can access those objects using FLUID's mechanism of accessing
properties:

<f:layoutname="Default"/>

<f:sectionname="main">

<h1><f:translatekey="tx\_yag\_controller\_album\_new.header"/></h1>

<f:renderpartial="FormErrors"arguments="{for: 'newGallery'}"/>

<f:formmethod="post"controller="Album"action="create"name="newAlbum"

object="{newAlbum}">

<f:renderpartial="Album/FormFields"arguments="{album:album,

selectableGalleries:selectableGalleries,
selectedGallery:selectedGallery}"/>

<f:form.submitclass="submit"value="{f:translate(key: 'general.save'

default:'Save')}"/>

</f:form>

<f:link.actioncontroller="Gallery"action="index">

<f:translatekey="tx\_yag\_controller\_gallery.backToGallery"/>

</f:link.action>

</f:section>

