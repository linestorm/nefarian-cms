<?php

namespace Nefarian\CmsBundle\DependencyInjection;

use Nefarian\CmsBundle\Plugin\PluginCompiler;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class NefarianCmsExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $container->setParameter('nefarian_core.plugins', $config['plugins']);
        $container->setParameter('nefarian_core.themes', $config['themes']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter("nefarian_core.entity_manager", $config['entity_manager']);
        $container->setParameter("nefarian_core.backend_type_orm", $config['backend_type'] === 'orm');
    }

    /**
     * Allow an extension to prepend the extension configurations.
     *
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        $configs       = $container->getExtensionConfig('nefarian_cms');
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $doctrineConfig = array();

        foreach($config['plugins'] as $pluginClass)
        {
            $plugin = new PluginCompiler($pluginClass);
            $plugin->compile();

            if(is_dir($dir = $plugin->getPath() . '/Entity'))
            {
                $doctrineConfig[$plugin->getName()] = array(
                    'prefix'    => $plugin->getNamespace() . '\Entity',
                    'type'      => 'php',
                    'dir'       => $dir,
                    'alias'     => 'Plugin' . $plugin->getCamelName(),
                    'is_bundle' => false
                );
            }
        }

        $container->prependExtensionConfig('doctrine', array(
            'orm' => array(
                'mappings' => $doctrineConfig,
            )
        ));
    }


}
