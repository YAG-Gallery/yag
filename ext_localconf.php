<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array(
		'Album' => 'index, show, new, create, edit, update, delete',
		'Gallery' => 'index, show, new, create, edit, update, delete',
		'ItemType' => 'index, show, new, create, edit, update, delete',
		'Item' => 'index, show, new, create, edit, update, delete',
		'ResolutionPreset' => 'index, show, new, create, edit, update, delete',
		'Resolution' => 'index, show, new, create, edit, update, delete',
		'ItemFile' => 'index, show, new, create, edit, update, delete',
		'ItemSourceType' => 'index, show, new, create, edit, update, delete',
		'ItemSource' => 'index, show, new, create, edit, update, delete',
		'ResolutionItemFileRelation' => 'index, show, new, create, edit, update, delete',
	),
	array(
		'Album' => 'create, update, delete',
		'Gallery' => 'create, update, delete',
		'ItemType' => 'create, update, delete',
		'Item' => 'create, update, delete',
		'ResolutionPreset' => 'create, update, delete',
		'Resolution' => 'create, update, delete',
		'ItemFile' => 'create, update, delete',
		'ItemSourceType' => 'create, update, delete',
		'ItemSource' => 'create, update, delete',
		'ResolutionItemFileRelation' => 'create, update, delete',
	)
);

?>