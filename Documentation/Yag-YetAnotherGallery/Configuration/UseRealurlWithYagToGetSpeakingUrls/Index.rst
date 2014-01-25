

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


Use realUrl with YAG to get speaking URLs
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

To be honest, it is not trivial to build a realURL config for YAG. But
we have good news for you - we have done the job and created a
realURL-hook to do the work.

So, to use YAG with speaking URLs, all you have to do is adding the
following hooks to your realURL config:

$GLOBALS['TYPO3\_CONF\_VARS']['EXTCONF']['realurl']= **array** (

'encodeSpURL\_postProc'=> **array** (

'yag'=>'EXT:yag/Classes/Hooks/RealUrlHook.php:user\_Tx\_Yag\_Hooks\_Re
alUrl->encodeSpURL\_postProc',

),

'decodeSpURL\_preProc'=> **array** (

'yag'=>'EXT:yag/Classes/Hooks/RealUrlHook.php:user\_Tx\_Yag\_Hooks\_Re
alUrl->decodeSpURL\_preProc',

),

...

)

