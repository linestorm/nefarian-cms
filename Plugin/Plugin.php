<?php

namespace Nefarian\CmsBundle\Plugin;

/**
 * Class Plugin
 *
 * @package Nefarian\CmsBundle\Plugin
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class Plugin
{

    private $path;

    private $metaClass;

    public function boot()
    {
        $this->metaClass = new \ReflectionClass($this);
        $this->path = pathinfo($this->metaClass->getFileName(), PATHINFO_DIRNAME);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }


} 
