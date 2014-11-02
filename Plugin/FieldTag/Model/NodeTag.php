<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Model;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class NodeTag
 *
 * @package Nefarian\CmsBundle\Plugin\FieldTag\Model
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeTag
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var NodeTag
     */
    protected $parentTag;

    /**
     * @var NodeTag[]
     */
    protected $childTags;

    function __construct()
    {
        $this->childTags = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return NodeTag
     */
    public function getParentTag()
    {
        return $this->parentTag;
    }

    /**
     * @param NodeTag $parentTag
     */
    public function setParentTag(NodeTag $parentTag)
    {
        $this->parentTag = $parentTag;
    }

    /**
     * @return NodeTag[]
     */
    public function getChildTags()
    {
        return $this->childTags;
    }

    /**
     * @param NodeTag $childTag
     */
    public function addChildTags(NodeTag $childTag)
    {
        $this->childTags[] = $childTag;
    }

    /**
     * @param NodeTag $childTag
     */
    public function removeChildTags(NodeTag $childTag)
    {
        $this->childTags->removeElement($childTag);
    }



} 
