<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class FieldTag
 *
 * @package Nefarian\CmsBundle\Plugin\FieldTag\Model
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldTag
{
    /**
     * @var NodeTag[]
     */
    protected $tags;

    function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * @param NodeTag $tag
     */
    public function addTag(NodeTag $tag)
    {
        $this->tags[] = $tag;
    }

    /**
     * @param NodeTag $tag
     */
    public function removeTag(NodeTag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * @return NodeTag
     */
    public function getTags()
    {
        return $this->tags;
    }
} 
