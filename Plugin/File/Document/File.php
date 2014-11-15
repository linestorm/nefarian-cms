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
    protected $description;

    /**
     * @var string
     */
    protected $credits;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var int
     */
    protected $size;

    /**
     * @var int
     */
    protected $status;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var array Array of all api urls
     */
    protected $_api;

    /**
     * @param \Nefarian\CmsBundle\Plugin\File\Model\File $file
     * @param array                                      $api
     */
    function __construct(\Nefarian\CmsBundle\Plugin\File\Model\File $file, array $api = array())
    {
        $this->id          = $file->getId();
        $this->title       = $file->getTitle();
        $this->description = $file->getDescription();
        $this->path        = $file->getPath();
        $this->url         = $file->getUrl();
        $this->size        = $file->getSize();
        $this->status      = $file->getStatus();
        $this->filename    = $file->getFilename();
        $this->_api        = $api;

    }

    /**
     * @return array
     */
    public function getApi()
    {
        return $this->_api;
    }

    /**
     * @return string
     */
    public function getCredits()
    {
        return $this->credits;
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
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

} 
