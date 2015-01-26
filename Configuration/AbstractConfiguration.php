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
