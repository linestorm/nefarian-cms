<?php

namespace Nefarian\CmsBundle\DependencyInjection\Compiler;

use Nefarian\CmsBundle\Plugin\PluginCompiler;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class PluginCompilerPass
 *
 * @package Nefarian\CmsBundle\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class PluginCompilerPass implements CompilerPassInterface
{

    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $plugins = $container->getParameter('nefarian_core.plugins');

        $pluginRouterDefinition = $container->getDefinition('nefarian_core.routing.plugin_loader');
        $fieldManagerDefinition = $container->getDefinition('nefarian_core.content_field_manager');
        $apiRouterDefinition    = $container->getDefinition('nefarian_core.routing.api_loader');
        $menuManagerDefinition  = $container->getDefinition('nefarian_core.menu_manager');
        $assetManagerDefinition = $container->getDefinition('assetic.asset_manager');
        $twigLoaderDefinition   = $container->findDefinition('twig.loader.plugin_loader');

        foreach($plugins as $pluginClass)
        {
            $plugin = new PluginCompiler($pluginClass);
            $plugin->compile();
            $path = $plugin->getPath();

            // configure the plugin service
            $pluginDefinitionId = 'nefarian.plugin.' . $plugin->getName();
            $pluginDefinition   = $container->register($pluginDefinitionId, $pluginClass);
            $pluginReference = new Reference($pluginDefinitionId);


            // register the plugins with the router
            $routingResource = $path . DIRECTORY_SEPARATOR . 'Resources/config/routing/routing.admin.yml';
            if(file_exists($routingResource))
            {
                $pluginRouterDefinition->addMethodCall('addPluginResource', array($pluginReference, $routingResource));
            }


            // register the plugins with the router
            $routingResource = $path . DIRECTORY_SEPARATOR . 'Resources/config/routing/routing.api.yml';
            if(file_exists($routingResource))
            {
                $apiRouterDefinition->addMethodCall('addPluginResource', array($pluginReference, $routingResource));
            }


            // Add the default plugin template path to the twig loader
            $twigLoaderDefinition->addMethodCall('addPlugin', array($pluginReference));


            // tell asstic where the plugin assets are
            $jsAssets = @glob($plugin->getPath() . '/Resources/assets/js/*.js');
            if(count($jsAssets))
            {
                foreach($jsAssets as $jsAsset)
                {
                    $destination = str_replace($plugin->getPath() . '/Resources/assets/js/', '', $jsAsset);
                    $assetManagerDefinition->addMethodCall('setFormula', array('nefarian_plugin_' . $plugin->getName() . '_' . str_replace(array('/', '.js'), array('_', ''), $destination), array(
                        $jsAsset,
                        array('?uglifyjs2'),
                        array(
                            'output' => 'js/cms/' . $plugin->getName() . '/' . $destination
                        ),
                    )));
                }
            }


            // TODO: Finish loading module menu
            $menus = $plugin->getConfig($plugin::CONFIG_MENU);
            foreach($menus as $menuName => $menu)
            {
                $menu['title'];

                $menuManagerDefinition->addMethodCall('addCategory', array(
                    $menuName,
                    $plugin,
                    $menu['title'],
                    $menu['icon'],
                    $menu['description'],
                    $menu['links'],
                ));

                foreach($menu['items'] as $item)
                {
                }
            }


            // load all the entity mappings, if they exist
            if(is_dir($modelPath = $path . DIRECTORY_SEPARATOR . 'Resources/config/model/doctrine'))
            {
                // set the validations mappings
                $mappings = array(
                    'xml'  => 'xml',
                    'yaml' => 'yml'
                );
                foreach($mappings as $mapping => $extension)
                {
                    if(!$container->hasParameter('validator.mapping.loader.' . $mapping . '_files_loader.mapping_files'))
                    {
                        continue;
                    }

                    $files          = $container->getParameter('validator.mapping.loader.' . $mapping . '_files_loader.mapping_files');
                    $validationPath = 'Resources/config/validation.orm.' . $extension;

                    $file = $path . DIRECTORY_SEPARATOR . $validationPath;
                    if(is_file($file))
                    {
                        $files[] = realpath($file);
                        $container->addResource(new FileResource($file));
                    }

                    $container->setParameter('validator.mapping.loader.' . $mapping . '_files_loader.mapping_files', $files);
                }

                $mappings    = array(
                    $modelPath => $plugin->getNamespace() . '\Model',
                );
                $doctinePass = DoctrineOrmMappingsPass::createXmlMappingDriver($mappings, array('nefarian_core.entity_manager'), 'nefarian_core.backend_type_orm');
                $doctinePass->process($container);

                if(is_dir($modelPath = $path . DIRECTORY_SEPARATOR . 'Resources/config/entity/doctrine'))
                {
                    $mappings    = array(
                        $modelPath => $plugin->getNamespace() . '\Entity',
                    );
                    $doctinePass = DoctrineOrmMappingsPass::createXmlMappingDriver($mappings, array('nefarian_core.entity_manager'), 'nefarian_core.backend_type_orm');
                    $doctinePass->process($container);
                }
            }

            // load in all the content fields
            $fieldsConfig = $plugin->getConfig($plugin::CONFIG_FIELDS);
            $class = 'Nefarian\CmsBundle\Content\Field\Field';
            foreach($fieldsConfig['fields'] as $fieldName => $fieldConfig)
            {
                $sId = 'nefarian_core.content_field.'.$fieldName;
                $fieldDefinition = $container->register($sId, $class);
                $fieldDefinition->setArguments(array($fieldName, $fieldConfig));
                $fieldManagerDefinition->addMethodCall('addField', array(new Reference($sId)));
            }

            /**
             * @TODO: dump cached
             * @see http://symfony.com/doc/current/components/dependency_injection/compilation.html#dumping-the-configuration-for-performance
             */
        }

    }


} 
