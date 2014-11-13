<?php

namespace Nefarian\CmsBundle\Plugin\File\Document;

/**
 * Class File
 *
 * @package Nefarian\CmsBundle\Plugin\File\Document
 */
class File
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $nameOriginal;

    /**
     * @var string
     */
    protected $hash;

    /**
     * @var string
     */
    protected $alt;

    /**
     * @var string
     */
    protected $credits;

    /**
     * @var string
     */
    protected $src;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var int
     */
    protected $category;

    /**
     * @var array Array of all api urls
     */
    protected $_api;

    /**
     * @param \Nefarian\CmsBundle\Plugin\File\Model\File $file
     * @param array                              $api
     */
    function __construct(\Nefarian\CmsBundle\Plugin\File\Model\File $file, array $api = array())
    {
        $this->id           = $file->getId();
        $this->title        = $file->getTitle();
        $this->path         = $file->getPath();

        $this->_api         = $api;
    }

    /**
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @return string
     */
    public function getCredits()
    {
        return $this->credits;
    }
    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getNameOriginal()
    {
        return $this->nameOriginal;
    }

    /**
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return array
     */
    public function getApi()
    {
        return $this->_api;
    }

} 
