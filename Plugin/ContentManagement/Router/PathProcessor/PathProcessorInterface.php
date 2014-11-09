<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Router\PathProcessor;

use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Node;

/**
 * Interface PathProcessorInterface
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Router\PathProcessor
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface PathProcessorInterface
{
    /**
     * @return string
     */
    public function getType();

    /**
     * Translate a field and node entity into a value
     *
     * @param string $field
     * @param Node   $node
     *
     * @return mixed
     */
    public function process($field, Node $node);
} 
