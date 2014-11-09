<?php

namespace Nefarian\CmsBundle\Plugin\FieldCategory\Router\PathProcessor;

use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Node;
use Nefarian\CmsBundle\Plugin\ContentManagement\Router\PathProcessor\PathProcessorInterface;
use Nefarian\CmsBundle\Plugin\FieldCategory\Entity\FieldCategory;

/**
 * Class CategoryPathProcessor
 *
 * @package Nefarian\CmsBundle\Plugin\FieldCategory\Router\PathProcessor
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class CategoryPathProcessor implements PathProcessorInterface
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'category';
    }

    public function process($field, Node $node)
    {
        $contents = $node->getContents();

        foreach($contents as $content)
        {
            if($content instanceof FieldCategory){
                $category = $content->getCategory();
                $meta = new \ReflectionClass($category);
                if($meta->hasProperty($field)){
                    return call_user_func(array($category, 'get'.$field));
                }
            }
        }
    }
} 
