<?php

namespace Nefarian\CmsBundle\Plugin\Exception;

class PluginDependencyNotInstalledException extends \Exception
{
    public function __construct($plugin, $dependency, \Exception $previous = null)
    {
        $msg = sprintf("The Plugin \"%s\" requires \"%s\" to be installed first", $plugin, $dependency);
        parent::__construct($msg, null, $previous);
    }

} 