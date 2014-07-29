<?php

namespace Nefarian\CmsBundle\Plugin\FieldCategory\Model;

/**
 * Class FieldCategory
 *
 * @package Nefarian\CmsBundle\Plugin\FieldCategory\Model
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldCategory
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
