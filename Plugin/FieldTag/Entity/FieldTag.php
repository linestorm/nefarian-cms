<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\NodeContent;
use Nefarian\CmsBundle\Plugin\FieldTag\Model\NodeTag;

/**
 * Class FieldTag
 *
 * @package Nefarian\CmsBundle\Plugin\FieldTag\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldTag extends NodeContent
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
