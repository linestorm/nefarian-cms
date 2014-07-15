<?php

namespace Nefarian\CmsBundle\Twig;

use Nefarian\CmsBundle\Theme\ThemeManager;

class ThemeExtension extends \Twig_Extension
{
    /**
     * @var ThemeManager
     */
    private $themeManager;

    /**
     * @param ThemeManager $themeManager
     */
    function __construct(ThemeManager $themeManager)
    {
        $this->themeManager = $themeManager;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('nefarian_theme_admin', array($this, 'getAdminTheme'))
        );
    }

    /**
     * Get the admin theme namespace
     */
    public function getAdminTheme()
    {
        $this->themeManager->getAdminTheme();
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'nefarian_theme';
    }

} 
