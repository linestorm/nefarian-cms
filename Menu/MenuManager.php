<?php

namespace Nefarian\CmsBundle\Menu;

// TODO: decide what this should do!
class MenuManager
{

    /**
     * @var array
     */
    protected $links = array();

    /**
     * Add a link to the link stack
     *
     * @param string $plugin
     * @param string $title
     * @param string $route
     * @param string $description
     * @param null   $parent
     */
    public function addLink($plugin, $title, $route, $description = '', $parent = null)
    {
        $this->links[$plugin][] = array(
            'title' => $title,
            'route' => $route,
            'description' => $description,
        );
    }

    /**
     * Get all the links
     *
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

} 
