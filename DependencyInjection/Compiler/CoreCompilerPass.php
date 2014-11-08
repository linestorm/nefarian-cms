<?php

namespace Nefarian\CmsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
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
        $assetManagerDefinition  = $container->getDefinition('assetic.asset_manager');

        // tell asstic where the plugin assets are
        $assetNamespace = '@core/';
        $folder         = $this->bundle->getPath() . '/Resources/assets/js';
        if (is_dir($folder)) {
            $jsRoot   = '/js';
            $dir      = new \RecursiveDirectoryIterator($folder);
            $ite      = new \RecursiveIteratorIterator($dir);
            $fileList = new \RegexIterator($ite, '/.+\.js/', \RegexIterator::GET_MATCH);

            foreach ($fileList as $files) {
                foreach ($files as $file) {
                    $destination = str_replace($this->bundle->getPath() . '/Resources/assets/js/', '', $file);
                    $assetId     = 'nefarian_plugin_core_' . str_replace(
                            array('/', '.js'),
                            array('_', ''),
                            $destination
                        );
                    $assetPath   = '/cms/core/' . $destination;

                    $assetManagerDefinition->addMethodCall(
                        'setFormula',
                        array(
                            $assetId,
                            array(
                                $file,
                                array('?uglifyjs2'),
                                array(
                                    'output' => $jsRoot . $assetPath
                                ),
                            )
                        )
                    );
                }
            }
        }
    }
} 
