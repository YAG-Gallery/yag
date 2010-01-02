<?php

class Tx_Yag_Tests_Mocks_ConfigurationMocks {
    
	public static function getBasicConfiguration() {
		$configuration = Array (
                'userFunc' => 'tx_extbase_dispatcher->dispatch',
                'pluginName' => 'Pi1',
                'extensionName' => 'Yag',
                'controller' => 'Gallery',
                'action' => 'index',
                'switchableControllerActions.' => Array
                    (
                        '1.' => Array
                            (
                                'controller' => 'Gallery',
                                'actions' => 'index,show,edit,new,create,delete,update,removeAlbum,addAlbum'
                            ),
            
                        '2.' => Array
                            (
                                'controller' => 'Album',
                                'actions' => 'index,show,new,create,delete,edit,update,editImages,updateImages,rss'
                            ),
            
                        '3.' => Array
                            (
                                'controller' => 'AlbumContent',
                                'actions' => 'index,addImagesByPath,addImagesByFile'
                            ),
            
                        '4.' => Array
                            (
                                'controller' => 'Image',
                                'actions' => 'single,delete,edit,update'
                            )
            
                    ),
                'settings' => array
                    (
                        'adminGroups' => 1,
                        'album' => array
                             (
                                'rssPid' => 5,
                                'itemsPerPage' => 12        
                             )
                    ),
                'persistence' => array
                    (
                        'storagePid' => 6
                    ),
                'view' => array
                    (
                        'templateRootPath' => 'EXT:yag/Resources/Private/Templates/',
                        'partialRootPath' => 'EXT:yag/Resources/Private/Partials/',
                        'layoutRootPath' => 'EXT:yag/Resources/Private/Layouts/'
                    )
            );
        return $configuration;
	}
	
}

?>
