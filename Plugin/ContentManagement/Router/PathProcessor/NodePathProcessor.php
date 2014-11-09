<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Router\PathProcessor;

use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Node;

/**
 * Class NodePathProcessor
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Router\PathProcessor
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodePathProcessor implements PathProcessorInterface
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'node';
    }

    public function process($field, Node $node)
    {
        $meta = new \ReflectionClass($node);
        if($meta->hasProperty($field)){
            return call_user_func(array($node, 'get'.$field));
        }
    }
} 
