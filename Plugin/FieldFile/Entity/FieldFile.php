<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Entity;

use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\NodeContent;
use Nefarian\CmsBundle\Plugin\File\Entity\File;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class FieldFile
 *
 * @package Nefarian\CmsBundle\Plugin\FieldFile\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldFile extends NodeContent
{
    /**
     * @var File[]
     */
    protected $files;

    /**
     * @var int
     */
    protected $delta;

    function __construct()
    {
        $this->files = new ArrayCollection();
    }

    /**
     * @return File
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param File $file
     */
    public function addFile(File $file)
    {
        $this->files[] = $file;
    }

    /**
     * @param File $file
     */
    public function removeFile(File $file)
    {
        $this->files->removeElement($file);
    }

    /**
     * @return int
     */
    public function getDelta()
    {
        return $this->delta;
    }

    /**
     * @param int $delta
     */
    public function setDelta($delta)
    {
        $this->delta = $delta;
    }



} 
