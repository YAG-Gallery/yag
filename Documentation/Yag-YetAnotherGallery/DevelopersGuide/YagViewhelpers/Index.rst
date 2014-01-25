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


YAG ViewHelpers
^^^^^^^^^^^^^^^

Here is a list of viewhelpers available from within YAG:

|img-107|

If you want to use YAG's viewhelpers in your templates, you have to
include them with the following line of code at the beginning of your
template:

{namespace yag=Tx\_Yag\_ViewHelpers}

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   ViewHelper
         ViewHelper:
   
   Parameters
         Parameters:
   
   Description
         Description:


.. container:: table-row

   ViewHelper
         BreadcrumbsViewHelper
   
   Parameters
         none
   
   Description
         Renders a root path menue from gallery to image.
         
         |img-108|
         
         Example:
         
         <yag:breadcrumbs/>


.. container:: table-row

   ViewHelper
         ImageViewHelper
   
   Parameters
         Item: item object
         
         resolutionName: The name of a defined resolution.
   
   Description
         Renders an image in the given resolution.
         
         Example:
         
         <yag:imageitem="{image}"resolutionName="thumb"/>


.. ###### END~OF~TABLE ######


CSS
"""

The followin viewhelpers are available for handling CSS related stuff:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   ViewHelper
         ViewHelper:
   
   Parameters
         Parameters:
   
   Description
         Description:


.. container:: table-row

   ViewHelper
         IncludeViewHelper
   
   Parameters
         Library: library name
         
         File: path to file
   
   Description
         Includes CSS Files to the header section. If library is given, the css
         files defined in the library are included (see:
         Typoscript/BaseConfig/HeaderInclusion/)
         
         Example:
         
         <yag:CSS.Includelibrary="jQueryShadowBox"/>


.. ###### END~OF~TABLE ######


Javascript
""""""""""

The followin viewhelpers are available for handling Javascript related
stuff:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   ViewHelper
         ViewHelper:
   
   Parameters
         Parameters:
   
   Description
         Description:


.. container:: table-row

   ViewHelper
         IncludeViewHelper
   
   Parameters
         Library: library name
         
         File: path to file
   
   Description
         Includes JS Files to the header section. If library is given, the js
         files defined in the library are included (see:
         Typoscript/BaseConfig/HeaderInclusion/)
         
         Example:
         
         <yag:Javascript.Includelibrary="jQuery"/>
         
         In order to make this work, you have to configure your libraries in
         TypoScript. You find a list of predefined libraries in
         Configuration/TypoScript/BaseConfig/HeaderInclusion/JQuery.ts:
         
         plugin.tx\_yag.settings.frontendLib {jQuery {include =
         {$config.yag.addjQuery}includeJS.jQuery =
         EXT:yag/Resources/Public/Js/JQuery/jquery-1.5.1.min.js#
         includeCSS.jQuery = EXT:yag/Resources/Public/CSS/JQuery/base.css}}


.. container:: table-row

   ViewHelper
         TemplateViewHelper
   
   Parameters
         TemplatePath: path to a jsTemplate
         
         Arguments: the arguments to replace in the template.
   
   Description
         This viewhelper is in some way a pragmatic approach to avoid the fluid
         restrictions with javscript inline markup in templates. All arguments
         given to the viewhelper are replaced in the Javascript template in the
         form ###argument### with the given value.
         
         There are some implicit defined markers:
         
         extPath: relative path to the extensionextKey: Extension
         KeypluginNamespace: Plugin Namespace for GET/POST parameters
         
         Example (usage of viewhelper):
         
         <yag:Javascript.TemplatetemplatePath="EXT:yag/Resources/Private/JSTemp
         lates/ItemAdminList.js"arguments="{ajaxBaseURL :
         '{f:uri.action(controller:\'Ajax\')}'}"/>
         
         Example (usage of template markers in JS templates – so it's
         JavaScript what you see here):
         
         vardel\_url
         ='###ajaxBaseURL###'+'&###pluginNamespace###[action]=deleteItem';


.. ###### END~OF~TABLE ######


Link
""""

The following viewhelpers are available for rendering links:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   ViewHelper
         ViewHelper:
   
   Parameters
         Parameters:
   
   Description
         Description:


.. container:: table-row

   ViewHelper
         AlbumViewHelper
   
   Parameters
         Album: album object
   
   Description
         Renders a link for an album


.. container:: table-row

   ViewHelper
         AlbumAdminViewHelper
   
   Parameters
         Album: album object
   
   Description
         Renders a link for administrating an album


.. container:: table-row

   ViewHelper
         GalleryViewHelper
   
   Parameters
         Gallery: gallery object
   
   Description
         Renders a link for a gallery


.. ###### END~OF~TABLE ######


Namespace
"""""""""

The followin viewhelpers are available for using namespaces:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   ViewHelper
         ViewHelper:
   
   Parameters
         Parameters:
   
   Description
         Description:


.. container:: table-row

   ViewHelper
         GPArrayViewHelper
   
   Parameters
         ###TODO daniel###
   
   Description
         ###TODO daniel###


.. ###### END~OF~TABLE ######


Resource
""""""""

The followin viewhelpers are available for getting URIs for resources:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   ViewHelper
         ViewHelper:
   
   Parameters
         Parameters:
   
   Description
         Description:


.. container:: table-row

   ViewHelper
         ImageViewHelper
   
   Parameters
         Item: item object
         
         resolutionName: The name of a defined resolution.
   
   Description
         Renders URI for an image. Used in XML view for example.
         
         Example:
         
         <yag:resource.imageitem="{listRow.image.value}"resolutionName="thumb"/
         >


.. ###### END~OF~TABLE ######

