<?php

namespace Nefarian\CmsBundle\DependencyInjection\Compiler;

use Nefarian\CmsBundle\Plugin\PluginCompiler;
use Symfony\Component\Config\Definition\Processor;
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
        $plugins = $container->findTaggedServiceIds('nefarian.plugin');

        $pluginManagerDefinition = $container->getDefinition('nefarian_core.plugin_manager');
        $pluginRouterDefinition  = $container->getDefinition('nefarian_core.routing.plugin_loader');
        $fieldManagerDefinition  = $container->getDefinition('nefarian_core.content_field_manager');
        $apiRouterDefinition     = $container->getDefinition('nefarian_core.routing.api_loader');
        $webRouterDefinition     = $container->getDefinition('nefarian_core.routing.web_loader');
        $menuManagerDefinition   = $container->getDefinition('nefarian_core.menu_manager');
        $assetManagerDefinition  = $container->getDefinition('assetic.asset_manager');
        $twigLoaderDefinition    = $container->findDefinition('twig.loader.plugin_loader');

        $assetMap = array();

        foreach ($plugins as $sid => $attrs) {
            $pluginDefinition = $container->findDefinition($sid);
            $pluginReference  = new Reference($sid);
            $pluginManagerDefinition->addMethodCall('registerPlugin', array($pluginReference));

            $pluginClass = $pluginDefinition->getClass();
            $plugin      = new PluginCompiler($pluginClass);
            $plugin->compile();
            $path = $plugin->getPath();

            // register the plugins with the router
            $routingResource = $path . DIRECTORY_SEPARATOR . 'Resources/config/routing/routing.admin.yml';
            if (file_exists($routingResource)) {
                $pluginRouterDefinition->addMethodCall('addPluginResource', array($pluginReference, $routingResource));
            }

            // register the plugins with the router
            $routingResource = $path . DIRECTORY_SEPARATOR . 'Resources/config/routing/routing.api.yml';
            if (file_exists($routingResource)) {
                $apiRouterDefinition->addMethodCall('addPluginResource', array($pluginReference, $routingResource));
            }

            // register the plugins with the router
            $routingResource = $path . DIRECTORY_SEPARATOR . 'Resources/config/routing/routing.web.yml';
            if (file_exists($routingResource)) {
                $webRouterDefinition->addMethodCall('addPluginResource', array($pluginReference, $routingResource));
            }

            // Add the default plugin template path to the twig loader
            $twigLoaderDefinition->addMethodCall('addPlugin', array($pluginReference));

            // build an array of all assets, then inject the maps into the asset controller
            $assetNamespace = '@plugin_' . $plugin->getName() . '/';

            // tell asstic where the plugin assets are
            $folder = $path . '/Resources/assets/js';
            if (is_dir($folder)) {
                $jsRoot   = '/js';
                $dir      = new \RecursiveDirectoryIterator($folder);
                $ite      = new \RecursiveIteratorIterator($dir);
                $fileList = new \RegexIterator($ite, '/.+\.js/', \RegexIterator::GET_MATCH);

                foreach ($fileList as $files) {
                    foreach ($files as $file) {
                        $destination = str_replace($plugin->getPath() . '/Resources/assets/js/', '', $file);
                        $assetId     = 'nefarian_plugin_' . $plugin->getName() . '_' . str_replace(
                                array('/', '.js'),
                                array('_', ''),
                                $destination
                            );
                        $assetPath   = '/cms/' . $plugin->getName() . '/' . $destination;

                        $assetMap[$assetNamespace . $destination] = $assetPath;

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

            $folder = $path . '/Resources/assets/img';
            if (is_dir($folder)) {
                $imgRoot = '/img';
                $maps    = array(
                    '.jpg' => 'jpegoptim',
                    '.jpeg' => 'jpegoptim',
                    '.png' => 'optipng',
                    '.gif' => null,
                );
                foreach ($maps as $ext => $app) {
                    if ($app) {
                        $app = array('?' . $app);
                    } else {
                        $app = array();
                    }

                    $dir      = new \RecursiveDirectoryIterator($folder);
                    $ite      = new \RecursiveIteratorIterator($dir);
                    $fileList = new \RegexIterator($ite, '/.+\.' . $ext . '/', \RegexIterator::GET_MATCH);

                    foreach ($fileList as $files) {
                        foreach ($files as $file) {
                            $destination = str_replace($path . '/Resources/assets/img/', '', $file);
                            $assetPath   = '/theme/' . $plugin->getName() . '/' . $destination;

                            $assetMap[$assetNamespace . $destination] = $assetPath;

                            $assetManagerDefinition->addMethodCall(
                                'setFormula',
                                array(
                                    'nefarian_plugin_' . $plugin->getName() . '_' . str_replace(
                                        array('/', $ext),
                                        array('_', ''),
                                        $destination
                                    ),
                                    array(
                                        $file,
                                        $app,
                                        array(
                                            'output' => $imgRoot . $assetPath
                                        ),
                                    )
                                )
                            );
                        }
                    }
                }
            }

            // TODO: Finish loading module menu
            $menus = $plugin->getConfig($plugin::CONFIG_MENU);
            foreach ($menus as $menuName => $menu) {

                $menuManagerDefinition->addMethodCall(
                    'addCategory',
                    array(
                        $menuName,
                        $pluginReference,
                        $menu['title'],
                        $menu['icon'],
                        $menu['description'],
                        $menu['items'],
                    )
                );
            }

            // load all the entity mappings, if they exist
            if (is_dir($modelPath = $path . DIRECTORY_SEPARATOR . 'Resources/config/model/doctrine')) {
                // set the validations mappings
                $mappings = array(
                    'xml' => 'xml',
                    'yaml' => 'yml'
                );
                foreach ($mappings as $mapping => $extension) {
                    if (!$container->hasParameter(
                        'validator.mapping.loader.' . $mapping . '_files_loader.mapping_files'
                    )
                    ) {
                        continue;
                    }

                    $files          = $container->getParameter(
                        'validator.mapping.loader.' . $mapping . '_files_loader.mapping_files'
                    );
                    $validationPath = 'Resources/config/validation.orm.' . $extension;

                    $file = $path . DIRECTORY_SEPARATOR . $validationPath;
                    if (is_file($file)) {
                        $files[] = realpath($file);
                        $container->addResource(new FileResource($file));
                    }

                    $container->setParameter(
                        'validator.mapping.loader.' . $mapping . '_files_loader.mapping_files',
                        $files
                    );
                }

                $mappings    = array(
                    $modelPath => $plugin->getNamespace() . '\Model',
                );
                $doctinePass = DoctrineOrmMappingsPass::createXmlMappingDriver(
                    $mappings,
                    array('nefarian_core.entity_manager'),
                    'nefarian_core.backend_type_orm'
                );
                $doctinePass->process($container);
            }

            if (is_dir($modelPath = $path . DIRECTORY_SEPARATOR . 'Resources/config/entity/doctrine')) {
                $mappings    = array(
                    $modelPath => $plugin->getNamespace() . '\Entity',
                );
                $doctinePass = DoctrineOrmMappingsPass::createXmlMappingDriver(
                    $mappings,
                    array('nefarian_core.entity_manager'),
                    'nefarian_core.backend_type_orm'
                );
                $doctinePass->process($container);
            }

            // add the assetmap to the asset manager
            $nefarianAssetManagerDefinition = $container->getDefinition('nefarian_core.asset_manager');
            $nefarianAssetManagerDefinition->addMethodCall('setAssets', array($assetMap));

            // load in all the content fields

            $fieldsConfig = $plugin->getConfig($plugin::CONFIG_FIELDS);
            $class        = 'Nefarian\CmsBundle\Content\Field\Field';
            foreach ($fieldsConfig as $fieldName => $fieldConfig) {
                $sId             = 'nefarian_core.content_field.' . $fieldName;
                $fieldDefinition = $container->register($sId, $class);
                $fieldDefinition->setArguments(array($fieldName, $fieldConfig));
                $fieldManagerDefinition->addMethodCall('addField', array(new Reference($sId)));
            }

            // add the plugin forms to the form list
            $formResources = $container->getParameter('twig.form.resources');
            $templatingConfig = $plugin->getConfig($plugin::CONFIG_TEMPLATING);
            foreach($templatingConfig['forms'] as $tmplName => $template){
                $formResources[] = $template;
            }
            $container->setParameter('twig.form.resources', $formResources);

            // fire any plugin compiler passes
            $class = $plugin->getNamespace() . '\\DependencyInjection\\Compiler\\' . $plugin->getCamelName() . 'CompilerPass';
            if(class_exists($class)){
                /** @var CompilerPassInterface $pluginCompilerPass */
                $pluginCompilerPass = new $class();
                $pluginCompilerPass->process($container);
            }

            /**
             * @TODO: dump cached
             * @see http://symfony.com/doc/current/components/dependency_injection/compilation.html#dumping-the-configuration-for-performance
             */


        }

    }


} 
