<?php

namespace Nefarian\CmsBundle\Plugin\FieldCategory\Entity;

use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\NodeContent;
use Nefarian\CmsBundle\Plugin\FieldCategory\Model\NodeCategory;

/**
 * Class FieldCategory
 *
 * @package Nefarian\CmsBundle\Plugin\FieldCategory\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldCategory extends NodeContent
{
    /**
     * @var NodeCategory
     */
    protected $category;

    /**
     * @param NodeCategory $category
     */
    public function setCategory(NodeCategory $category)
    {
        $this->category = $category;
    }

    /**
     * @return NodeCategory
     */
    public function getCategory()
    {
        return $this->category;
    }
} 
