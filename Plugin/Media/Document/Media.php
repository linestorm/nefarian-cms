<?php

namespace Nefarian\CmsBundle\Plugin\Media\Document;

/**
 * Class Media
 *
 * @package Nefarian\CmsBundle\Plugin\Media\Document
 */
class Media
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
     * @param \Nefarian\CmsBundle\Plugin\Media\Model\Media $media
     * @param array                              $api
     */
    function __construct(\Nefarian\CmsBundle\Plugin\Media\Model\Media $media, array $api = array())
    {
        $this->alt          = $media->getAlt();
        $this->credits      = $media->getCredits();
        $this->hash         = $media->getHash();
        $this->id           = $media->getId();
        $this->name         = $media->getName();
        $this->nameOriginal = $media->getNameOriginal();
        $this->src          = $media->getSrc();
        $this->title        = $media->getTitle();
        $this->path         = $media->getPath();
        $this->category     = $media->getCategory();

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
