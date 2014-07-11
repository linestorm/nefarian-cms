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
     */
    public function addLink($plugin, $title, $route, $description = '')
    {
        $this->links[$plugin][] = array(
            'title' => $title,
            'route' => $route,
            'description' => $description,
        );
    }

} 
