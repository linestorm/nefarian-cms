<?php

namespace Nefarian\CmsBundle\Plugin\File\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Class FileCategory
 *
 * @package Nefarian\CmsBundle\Plugin\File\Model
 */
class FileCategory
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var File[]
     */
    protected $file;

    /**
     * @var FileCategory
     */
    protected $parent;

    /**
     * @var FileCategory[]
     */
    protected $children;

    /**
     *
     */
    function __construct()
    {
        $this->children = new ArrayCollection();
        $this->file    = new ArrayCollection();
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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param File $child
     */
    public function addChild(File $child)
    {
        $this->children[] = $child;
    }

    /**
     * @param File $child
     */
    public function removeChild(File $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * @return File[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return File
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param File $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * This is for doctrine as it can be retarded
     * TODO: override doctrine
     *
     * @param File $file
     */
    public function addMedion(File $file)
    {
        $this->file[] = $file;
        $file->setCategory($this);
    }

    /**
     * @param File $file
     */
    public function addFile(File $file)
    {
        $this->file[] = $file;
        $file->setCategory($this);
    }

    /**
     * @param File $file
     */
    public function removeMedion(File $file)
    {
        $this->file->removeElement($file);
    }

    /**
     * @return File[]
     */
    public function getFile()
    {
        return $this->file;
    }


}
