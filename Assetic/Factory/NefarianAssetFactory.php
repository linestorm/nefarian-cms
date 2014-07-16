<?php

namespace Nefarian\CmsBundle\Assetic\Factory;

use Nefarian\CmsBundle\Theme\ThemeInterface;
use Nefarian\CmsBundle\Theme\ThemeManager;
use Symfony\Bundle\AsseticBundle\Factory\AssetFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class NefarianAssetFactory extends AssetFactory
{
    /**
     * @var ThemeManager
     */
    protected $themeManager;

    /**
     * @var ParameterBagInterface
     */
    private $parameterBag;

    /**
     * @param ThemeManager $themeManager
     */
    public function setThemeManager(ThemeManager $themeManager)
    {
        $this->themeManager = $themeManager;
    }

    /**
     * @param KernelInterface       $kernel
     * @param ContainerInterface    $container
     * @param ParameterBagInterface $parameterBag
     * @param string                $baseDir
     * @param bool                  $debug
     */
    public function __construct(KernelInterface $kernel, ContainerInterface $container, ParameterBagInterface $parameterBag, $baseDir, $debug = false)
    {
        $this->parameterBag = $parameterBag;
        parent::__construct($kernel, $container, $parameterBag, $baseDir, $debug);
    }

    /**
     * @inheritdoc
     */
    protected function parseInput($input, array $options = array())
    {
        $input = $this->parameterBag->resolveValue($input);

        if (strpos($input, '@theme_') === 0) {
            if(preg_match('/@theme_([^\/]+)(.+)/', $input, $matches))
            {
                list($fullTemplate, $themeName, $path) = $matches;
                $theme = $this->themeManager->getTheme($themeName);
                $meta = new \ReflectionClass($theme);
                if($theme instanceof ThemeInterface)
                {
                    $file = dirname($meta->getFileName()).$path;
                    return parent::parseInput($file, $options);
                }
            }
        }

        return parent::parseInput($input, $options);
    }

} 
