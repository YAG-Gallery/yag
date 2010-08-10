<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');




$TCA['tx_yag_domain_model_gallery'] = array(
	'ctrl' => $TCA['tx_yag_domain_model_gallery']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name,description,date,albums'
	),
	'types' => array(
		'1' => array('showitem' => 'name,description,date,albums')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	),
	'columns' => array(

		'sys_language_uid' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table' => 'tt_news',
				'foreign_table_where' => 'AND tt_news.uid=###REC_FIELD_l18n_parent### AND tt_news.sys_language_uid IN (-1,0)', // TODO
			)
		),
		'l18n_diffsource' => array(
			'config'=>array(
				'type'=>'passthrough')
		),
		't3ver_label' => array (
			'displayCond' => 'FIELD:t3ver_label:REQ:true',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
			'config' => array (
				'type'=>'none',
				'cols' => 27
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		
		'name' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_gallery.name',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		
		'description' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_gallery.description',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		
		'date' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_gallery.date',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => '0',
				'default' => '0'
			)
		),
		
		'albums' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_gallery.albums',
			'config'  => array(
				'type' => 'select',
				'foreign_table' => 'tx_yag_domain_model_album',
				'foreign_class' => 'Tx_Yag_Domain_Model_Album',
		        'MM' => 'tx_yag_domain_model_gallery_album_mm',
		        'size' => 10,
				'minitems' => 0,
				'maxitems'      => 999999,
		        'autoSizeMax' => 30,
		        'multiple' => 1
			)
		),
		
		
	),
);

$TCA['tx_yag_domain_model_album'] = array(
	'ctrl' => $TCA['tx_yag_domain_model_album']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'title,description,date'
	),
	'types' => array(
		'1' => array('showitem' => 'title,description,date,images,cover,thumb_width,thumb_height,single_width,single_height')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	),
	'columns' => array(

		'sys_language_uid' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table' => 'tt_news',
				'foreign_table_where' => 'AND tt_news.uid=###REC_FIELD_l18n_parent### AND tt_news.sys_language_uid IN (-1,0)', // TODO
			)
		),
		'l18n_diffsource' => array(
			'config'=>array(
				'type'=>'passthrough')
		),
		't3ver_label' => array (
			'displayCond' => 'FIELD:t3ver_label:REQ:true',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
			'config' => array (
				'type'=>'none',
				'cols' => 27
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		
		'title' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_album.title',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		
		'description' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_album.description',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		
		'date' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_album.date',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => '0',
				'default' => '0'
			)
		),
        
        'single_width' => array(
            'exclude' => 0,
            'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_album.single_width',
            'config'  => array(
                'type' => 'input',
                'size' => 6,
                'max' => 6,
		        'eval' => 'int'
            )
        ),
        
        'single_height' => array(
            'exclude' => 0,
            'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_album.single_height',
            'config'  => array(
                'type' => 'input',
                'size' => 6,
                'max' => 6,
                'eval' => 'int'
            )
        ),
        
        'thumb_width' => array(
            'exclude' => 0,
            'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_album.thumb_width',
            'config'  => array(
                'type' => 'input',
                'size' => 6,
                'max' => 6,
                'eval' => 'int'
            )
        ),
        
        'thumb_height' => array(
            'exclude' => 0,
            'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_album.thumb_height',
            'config'  => array(
                'type' => 'input',
                'size' => 6,
                'max' => 6,
                'eval' => 'int'
            )
        ),
		
		'cover' => array(
            'exclude' => 0,
            'label'   => 'Cover',
            'config'  => array(
                'type'          => 'select',
                'foreign_table' => 'tx_yag_domain_model_image',
                'foreign_class' => 'Tx_Yag_Domain_Model_Image',
                'minitems' => 0,
                'maxitems' => 1
            )
        ),
		
		'images' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_album.images',
			'config'  => array(
				'type' => 'select',
				'size' => 10,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 30,
				'multiple' => 1,
				'foreign_class' => 'Tx_Yag_Domain_Model_Image',
				'foreign_table' => 'tx_yag_domain_model_image',
				'MM' => 'tx_yag_domain_model_album_image_mm',
			)
		),
		
		
	),
);

$TCA['tx_yag_domain_model_image'] = array(
	'ctrl' => $TCA['tx_yag_domain_model_image']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'title,description,thumb,single,orig'
	),
	'types' => array(
		'1' => array('showitem' => 'title,description,thumb,single,orig')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	),
	'columns' => array(

		'sys_language_uid' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table' => 'tt_news',
				'foreign_table_where' => 'AND tt_news.uid=###REC_FIELD_l18n_parent### AND tt_news.sys_language_uid IN (-1,0)', // TODO
			)
		),
		'l18n_diffsource' => array(
			'config'=>array(
				'type'=>'passthrough')
		),
		't3ver_label' => array (
			'displayCond' => 'FIELD:t3ver_label:REQ:true',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
			'config' => array (
				'type'=>'none',
				'cols' => 27
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		
		'title' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_image.title',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		
		'description' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_image.description',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'thumb' => array(
		    'exclude' => 0,
		    'label'   => 'Thumb',
		    'config'  => array(
		        'type'          => 'select',
		        'foreign_table' => 'tx_yag_domain_model_imagefile',
		        'foreign_class' => 'Tx_Yag_Domain_Model_ImageFile',
		        'minitems' => 0,
		        'maxitems' => 1
		    )
		),
		'single' => array(
            'exclude' => 0,
            'label'   => 'Single',
            'config'  => array(
                'type'          => 'select',
                'foreign_table' => 'tx_yag_domain_model_imagefile',
                'foreign_class' => 'Tx_Yag_Domain_Model_ImageFile',
                'minitems' => 0,
                'maxitems' => 1
            )
        ),
        'orig' => array(
            'exclude' => 0,
            'label'   => 'Original',
            'config'  => array(
                'type'          => 'select',
                'foreign_table' => 'tx_yag_domain_model_imagefile',
                'foreign_class' => 'Tx_Yag_Domain_Model_ImageFile',
                'minitems' => 0,
                'maxitems' => 1
            )
        )
		
	),
);

$TCA['tx_yag_domain_model_imagefile'] = array(
	'ctrl' => $TCA['tx_yag_domain_model_imagefile']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name,type,file_path'
	),
	'types' => array(
		'1' => array('showitem' => 'name,type,file_path')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	),
	'columns' => array(

		'sys_language_uid' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table' => 'tt_news',
				'foreign_table_where' => 'AND tt_news.uid=###REC_FIELD_l18n_parent### AND tt_news.sys_language_uid IN (-1,0)', // TODO
			)
		),
		'l18n_diffsource' => array(
			'config'=>array(
				'type'=>'passthrough')
		),
		't3ver_label' => array (
			'displayCond' => 'FIELD:t3ver_label:REQ:true',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
			'config' => array (
				'type'=>'none',
				'cols' => 27
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		
		'file_path' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:yag/Resources/Private/Language/locallang_db.xml:tx_yag_domain_model_imagefile.filepath',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		
		'name' => array(
            'exclude' => 0,
            'label'   => 'Name',
            'config'  => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            )
        ),
        
        'type' => array(
            'exclude' => 0,
            'label'   => 'Type',
            'config'  => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            )
        ),
		
		
	),
);

?>