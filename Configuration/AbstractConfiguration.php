<?php

namespace Nefarian\CmsBundle\Configuration;

/**
 * Class AbstractConfiguration
 *
 * @package Nefarian\CmsBundle\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class AbstractConfiguration implements ConfigurationInterface
{
    protected $name;

    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * The name of the parent config
     *
     * @return string
     */
    public function getParent()
    {
        return 'root';
    }
} 
