<?php

namespace Nefarian\CmsBundle\DependencyInjection\Compiler;

use Nefarian\CmsBundle\Plugin\PluginCompiler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class CoreCompilerPass
 *
 * @package Nefarian\CmsBundle\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class CoreCompilerPass implements CompilerPassInterface
{
    /**
     * @var Bundle
     */
    protected $bundle;

    /**
     * @param Bundle $bundle
     */
    function __construct(Bundle $bundle)
    {
        $this->bundle = $bundle;
    }


    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $assetManagerDefinition = $container->getDefinition('assetic.asset_manager');

        // tell asstic where the core assets are
        $jsAssets = @glob($this->bundle->getPath() . '/Resources/assets/js/*.js');
        if(count($jsAssets))
        {
            foreach($jsAssets as $jsAsset)
            {
                $destination = str_replace($this->bundle->getPath() . '/Resources/assets/js/', '', $jsAsset);
                $assetManagerDefinition->addMethodCall('setFormula', array('nefarian_plugin_core_' . str_replace(array('/', '.js'), array('_', ''), $destination), array(
                    $jsAsset,
                    array('?uglifyjs2'),
                    array(
                        'output' => 'js/cms/core/' . $destination
                    ),
                )));
            }
        }
    }


} 
