<?php

namespace Nefarian\CmsBundle\Theme;

use Nefarian\CmsBundle\Theme\Exception\ThemeNotFoundException;

class ThemeManager
{
    /**
     * @var ThemeInterface[]
     */
    protected $themes = array();

    /**
     * @TODO: make this a setting
     *
     * @var string
     */
    protected $adminThemeName = 'nefarian_admin_dark';

    /**
     * @param ThemeInterface $theme
     */
    public function addTheme(ThemeInterface $theme)
    {
        $this->themes[$theme->getName()] = $theme;
    }

    /**
     * Get a list of all themes
     *
     * @return ThemeInterface[]
     */
    public function getThemes()
    {
        return $this->themes;
    }

    /**
     * Get a theme by name
     *
     * @param string $name
     *
     * @throws ThemeNotFoundException
     * @return ThemeInterface
     */
    public function getTheme($name)
    {
        if(!array_key_exists($name, $this->themes))
        {
            throw new ThemeNotFoundException($name);
        }

        return $this->themes[$name];
    }

    /**
     * Fetch the admin theme instance
     *
     * @return ThemeInterface
     */
    public function getAdminTheme()
    {
        return $this->themes[$this->adminThemeName];
    }
} 
