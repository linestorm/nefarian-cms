<?php

namespace Nefarian\CmsBundle\Plugin\Exception;

class PluginNotFoundException extends \Exception
{
    public function __construct($pluginName, \Exception $previous = null)
    {
        $msg = sprintf("The plugin \"%s\" does not exist", $pluginName);
        parent::__construct($msg, null, $previous);
    }
} 