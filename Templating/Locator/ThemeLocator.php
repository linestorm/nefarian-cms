<?php

namespace Nefarian\CmsBundle\Templating\Locator;


use Nefarian\CmsBundle\Theme\ThemeInterface;
use Nefarian\CmsBundle\Theme\ThemeManager;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Templating\TemplateReference;

class ThemeLocator implements FileLocatorInterface
{
    /**
     * @var ThemeManager
     */
    protected $themeManager;

    /**
     * @param ThemeManager $themeManager
     */
    function __construct(ThemeManager $themeManager)
    {
        $this->themeManager = $themeManager;
    }

    /**
     * Returns a full path for a given file name.
     *
     * @param mixed  $name        The file name to locate
     * @param string $currentPath The current path
     * @param bool   $first       Whether to return the first occurrence or an array of filenames
     *
     * @return string|array The full path to the file|An array of file paths
     *
     * @throws \InvalidArgumentException When file is not found
     */
    public function locate($name, $currentPath = null, $first = true)
    {
        if(strpos($name->getPath(), '@theme_') === 0)
        {
            if(preg_match('/@theme_([^\/]+)(.+)/', $name->getPath(), $matches))
            {
                list($fullPath, $themeName, $path) = $matches;
                $theme = $this->themeManager->getTheme($themeName);
                if($theme instanceof ThemeInterface)
                {
                    $meta = new \ReflectionClass($theme);
                    $file = dirname($meta->getFileName()).$path;
                    return $file;
                }

            }
        }

        return false;
    }

} 
