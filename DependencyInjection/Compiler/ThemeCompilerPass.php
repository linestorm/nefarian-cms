<?php

namespace Nefarian\CmsBundle\DependencyInjection\Compiler;

use Nefarian\CmsBundle\Theme\Theme;
use Symfony\Bundle\AsseticBundle\DependencyInjection\DirectoryResourceDefinition;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ThemeCompilerPass
 *
 * @package Nefarian\CmsBundle\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ThemeCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $themes = $container->getParameter('nefarian_core.themes');

        $themeManagerDefinition = $container->getDefinition('nefarian_core.theme_manager');
        $themeManagerReference  = new Reference('nefarian_core.theme_manager');

        foreach($themes as $theme)
        {
            /** @var Theme $oTheme */
            $oTheme = new $theme();
            $meta   = new \ReflectionClass($theme);
            $path   = pathinfo($meta->getFileName(), PATHINFO_DIRNAME);

            $themeServiceId  = 'nefarian_core.theme.' . $oTheme->getName();
            $themeDefinition = $container->register($themeServiceId, $theme);
            $themeManagerDefinition->addMethodCall('addTheme', array(new Reference($themeServiceId)));

            $loader            = $container->findDefinition('twig.loader.theme_loader');
            $templateFolder    = $path . '/Resources/views';
            $templateNamespace = 'theme_' . $oTheme->getName();
            if(file_exists($templateFolder))
            {
                $loader->addMethodCall('addPath', array($templateFolder, $templateNamespace));
            }

            // register theme with assetic
            $assetManagerDefinition = $container->findDefinition('assetic.asset_manager');
            $engines                = $container->getParameter('templating.engines');
            foreach($engines as $engine)
            {
                $resourceDefinitionId = 'assetic.' . $engine . '_directory_resource.theme_' . $oTheme->getName();
                $container->setDefinition(
                          $resourceDefinitionId,
                              new DirectoryResourceDefinition('theme_' . $oTheme->getName(), $engine, array(
                                  $container->getParameter('kernel.root_dir') . '/Resources/plugin_' . $oTheme->getName() . '/views',
                                  $path . '/Resources/views',
                              ))
                );
                $assetManagerDefinition->addMethodCall('addResource', array(new Reference($resourceDefinitionId), $engine));
            }

            // add the theme manager into the asset factory
            $assetFactoryDefinition = $container->findDefinition('assetic.asset_factory');
            $assetFactoryDefinition->addMethodCall('setThemeManager', array($themeManagerReference));


            // tell asstic where the plugin assets are
            $jsAssets = @glob($path . '/Resources/assets/js/*.js');
            if(count($jsAssets))
            {
                foreach($jsAssets as $jsAsset)
                {
                    $destination = str_replace($path . '/Resources/assets/js/', '', $jsAsset);
                    $assetManagerDefinition->addMethodCall('setFormula', array('nefarian_theme_' . $oTheme->getName() . '_' . str_replace(array('/', '.js'), array('_', ''), $destination), array(
                        $jsAsset,
                        array('?uglifyjs2'),
                        array(
                            'output' => 'js/theme/' . $oTheme->getName() . '/' . $destination
                        ),
                    )));
                }
            }

            $maps = array(
                '.jpg'  => 'jpegoptim',
                '.jpeg' => 'jpegoptim',
                '.png'  => 'optipng',
                '.gif'  => null,
            );
            foreach($maps as $ext => $app)
            {
                // image assets
                $imgAssets = @glob($path . '/Resources/assets/img/*' . $ext);
                if(count($imgAssets))
                {
                    if($app)
                    {
                        $app = array('?' . $app);
                    }
                    else
                    {
                        $app = array();
                    }

                    foreach($imgAssets as $imgAsset)
                    {
                        $destination = str_replace($path . '/Resources/assets/img/', '', $imgAsset);
                        $assetManagerDefinition->addMethodCall('setFormula', array('nefarian_plugin_' . $oTheme->getName() . '_' . str_replace(array('/', $ext), array('_', ''), $destination), array(
                            $imgAsset,
                            $app,
                            array(
                                'output' => 'img/theme/' . $oTheme->getName() . '/' . $destination
                            ),
                        )));
                    }
                }
            }
        }

    }
} 
