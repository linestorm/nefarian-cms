<?php

namespace Nefarian\CmsBundle\Twig\Loader;

use Nefarian\CmsBundle\Plugin\Plugin;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Templating\TemplateNameParserInterface;

class PluginLoader extends FilesystemLoader
{

    /**
     * @param FileLocatorInterface        $locator
     * @param TemplateNameParserInterface $parser
     */
    function __construct(FileLocatorInterface $locator, TemplateNameParserInterface $parser)
    {
        parent::__construct($locator, $parser);
    }

    /**
     * Add a plugin to the loader
     *
     * @param Plugin $plugin
     */
    public function addPlugin(Plugin $plugin)
    {
        $templateFolder = $plugin->getPath() . '/Resources/views';
        $templateNamespace = 'plugin_'.$plugin->getName();
        if(file_exists($templateFolder))
        {
            $this->addPath($templateFolder, $templateNamespace);
        }
    }

} 
