<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Router;

use Nefarian\CmsBundle\Configuration\ConfigManager;
use Nefarian\CmsBundle\Plugin\ContentManagement\Configuration\RoutingConfiguration;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Node;
use Nefarian\CmsBundle\Plugin\ContentManagement\Router\PathProcessor\PathProcessorInterface;

/**
 * Class NodeRouterManager
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Router
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeRouterManager
{
    /**
     * @var PathProcessorInterface[]
     */
    protected $pathProcessors = array();

    /**
     * @var ConfigManager
     */
    protected $configManager;

    function __construct(ConfigManager $configManager)
    {
        $this->configManager = $configManager;
    }

    /**
     * @param PathProcessorInterface $pathProcessor
     */
    public function addPathProcessor(PathProcessorInterface $pathProcessor)
    {
        $this->pathProcessors[] = $pathProcessor;
    }

    /**
     * @param Node   $node
     * @param string $type
     * @param string $field
     *
     * @return mixed
     */
    public function process(Node $node, $type, $field)
    {
        $term = null;
        foreach ($this->pathProcessors as $pathProcessor) {
            if ($pathProcessor->getType() == $type) {
                $term = $pathProcessor->process($field, $node);
            }
        }

        if(!$term){
            $term = $field;
        }

        // process the result
        /** @var RoutingConfiguration $routingConfig */
        $routingConfig = $this->configManager->get('content_type.routing');
        $term = $routingConfig->processString($term);

        return $term;
    }

} 
