<?php

namespace TYPO3\CMS\Yag\Fal\Driver;

/***************************************************************
*  Copyright notice
*
*  (c) 2010-2012 Daniel Lienert <typo3@lienert.cc>
*  All rights reserved
*
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/


class PathInfo
{
    const INFO_ROOT    = 1;
    const INFO_PID        = 2;
    const INFO_GALLERY    = 3;
    const INFO_ALBUM    = 4;
    const INFO_ITEM    = 5;


    /**
     * @var string
     */
    protected $falPath;

    /**
     * @var integer
     */
    protected $pid = 0;


    /**
     * @var Integer
     */
    protected $galleryUId = 0;


    /**
     * @var Integer
     */
    protected $albumUid = 0;


    /**
     * @var Integer
     */
    protected $itemUid = 0;


    /**
     * @var String
     */
    protected $pageName;


    /**
     * @var String
     */
    protected $galleryName;


    /**
     * @var string
     */
    protected $albumName;


    /**
     * @var string
     */
    protected $itemName;


    /**
     * @var string
     */
    protected $displayName;


    /**
     * @var string
     */
    protected $pathType;


    /**
     * @var string
     */
    protected $yagDirectoryPath;


    public function __construct($falPath = '')
    {
        if ($falPath) {
            $this->setFromFalPath($falPath);
        }
    }


    /**
     * Set from YAG Path Identifier
     *
     * @param $identifier
     * @return bool
     */
    public function setFromIdentifier($identifier)
    {
        error_log('=================== Parsing ' . base64_decode($identifier));

        $this->reset();

        $identifierArray = unserialize(base64_decode($identifier));

        if ($identifierArray === false) {
            return false;
        }

        foreach ($identifierArray as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }

        $this->debug();

        return true;
    }



    public function setFromFalPath($falPath)
    {
        error_log('=================== Parsing ' . $falPath);

        $this->reset();

        $this->falPath = $falPath;

        if ($falPath === '/') {
            $this->pathType = self::INFO_ROOT;
            return $this;
        }

        $falPath = trim($falPath, '/');
        $pathParts = explode('/', $falPath);

        if (isset($pathParts[0])) {
            list($name, $key) = explode('|', $pathParts[0]);
            $this->setPid((int) $key);
            $this->pathType = self::INFO_PID;
            $this->setPageName($name);
        }

        if (isset($pathParts[1])) {
            list($name, $key) = explode('|', $pathParts[1]);
            $this->setGalleryUId((int) $key);
            $this->pathType = self::INFO_GALLERY;
            $this->setGalleryName($name);
        }


        if (isset($pathParts[2])) {
            list($name, $key) = explode('|', $pathParts[2]);
            $this->setAlbumUid((int) $key);
            $this->pathType = self::INFO_ALBUM;
            $this->setAlbumName($name);
        }


        if (isset($pathParts[3])) {
            list($name, $key) = explode('|', $pathParts[3]);
            $this->setItemUid((int) $key);
            $this->pathType = self::INFO_ITEM;
            $this->setItemName($name);
        }

        $this->setDisplayName($name);

        $this->debug();

        return $this;
    }



    public function debug()
    {
        $infoArray = array(
            'pathType' => $this->pathType,
            'displayName' => $this->displayName,
            'falPath' => $this->falPath,
            'pid' => $this->pid,
            'galleryUid' => $this->galleryUId,
            'albumUid' => $this->albumUid,
            'itemUid' => $this->itemUid
        );

        foreach ($infoArray as $key => $value) {
            error_log($key . ':' . $value);
        }
    }


    public function getIdentifier()
    {
        $infoArray = array(
            'pathType' => $this->pathType,
            'displayName' => $this->displayName,
            'falPath' => $this->falPath,
            'pid' => $this->pid,
            'galleryUid' => $this->galleryUId,
            'albumUid' => $this->albumUid,
            'itemUid' => $this->itemUid,
            'yagDirectoryPath' => $this->getYagDirectoryPath()
        );

        return base64_encode(serialize(array_filter($infoArray)));
    }



    public function reset()
    {
        $this->displayName = '';
        $this->pathType = '';
        $this->falPath = '';

        $this->pid = 0;
        $this->galleryUId = 0;
        $this->albumUid = 0;
        $this->itemUid = 0;
    }


    public function getPagePath()
    {
        return  $this->pageName . '|' . $this->pid;
    }


    public function getGalleryPath()
    {
        return \Tx_Yag_Domain_FileSystem_Div::concatenatePaths(array($this->getPagePath(), $this->galleryName . '|' . $this->galleryUId));
    }


    public function getAlbumPath()
    {
        return \Tx_Yag_Domain_FileSystem_Div::concatenatePaths(array($this->getGalleryPath(), $this->albumName . '|' . $this->albumUid));
    }


    /**
     * @param int $albumUid
     * @return $this
     */
    public function setAlbumUid($albumUid)
    {
        $this->albumUid = $albumUid;
        return $this;
    }

    /**
     * @return int
     */
    public function getAlbumUid()
    {
        return $this->albumUid;
    }

    /**
     * @param int $galleryUId
     */
    public function setGalleryUId($galleryUId)
    {
        $this->galleryUId = $galleryUId;
        return $this;
    }

    /**
     * @return int
     */
    public function getGalleryUId()
    {
        return $this->galleryUId;
    }

    /**
     * @param int $itemUid
     */
    public function setItemUid($itemUid)
    {
        $this->itemUid = $itemUid;
        return $this;
    }

    /**
     * @return int
     */
    public function getItemUid()
    {
        return $this->itemUid;
    }

    /**
     * @param int $pid
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
        return $this;
    }

    /**
     * @return int
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @param string $falPath
     */
    public function setFalPath($falPath)
    {
        $this->falPath = $falPath;
    }


    /**
     * @return string
     */
    public function getFalPath()
    {
        return $this->falPath;
    }

    /**
     * @param string $infoName
     */
    public function setDisplayName($infoName)
    {
        $this->displayName = $infoName;
        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param string $pathType
     */
    public function setPathType($pathType)
    {
        $this->pathType = $pathType;
        return $this;
    }

    /**
     * @return string
     */
    public function getPathType()
    {
        return $this->pathType;
    }

    /**
     * @return string
     */
    public function getYagDirectoryPath()
    {
        $this->yagDirectoryPath = '';
        $pathParts = array();

        switch ($this->pathType) {
            case self::INFO_ITEM:
                $pathParts[] = $this->itemUid;
            case self::INFO_ALBUM:
                $pathParts[] = $this->albumUid;
            case self::INFO_GALLERY:
                $pathParts[] = $this->galleryUId;
            case self::INFO_PID:
                $pathParts[] = $this->pid;
        }

        $pathParts = array_reverse($pathParts);

        $this->yagDirectoryPath = '/' . implode('/', $pathParts);

        return $this->yagDirectoryPath;
    }

    /**
     * @param string $albumName
     */
    public function setAlbumName($albumName)
    {
        $this->albumName = $albumName;
    }

    /**
     * @return string
     */
    public function getAlbumName()
    {
        return $this->albumName;
    }

    /**
     * @param String $galleryName
     */
    public function setGalleryName($galleryName)
    {
        $this->galleryName = $galleryName;
    }

    /**
     * @return String
     */
    public function getGalleryName()
    {
        return $this->galleryName;
    }

    /**
     * @param string $itemName
     */
    public function setItemName($itemName)
    {
        $this->itemName = $itemName;
    }

    /**
     * @return string
     */
    public function getItemName()
    {
        return $this->itemName;
    }

    /**
     * @param String $pageName
     */
    public function setPageName($pageName)
    {
        $this->pageName = $pageName;
    }

    /**
     * @return String
     */
    public function getPageName()
    {
        return $this->pageName;
    }
}
