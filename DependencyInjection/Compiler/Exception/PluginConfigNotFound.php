<?php

namespace Nefarian\CmsBundle\DependencyInjection\Compiler\Exception;

use Exception;

class PluginConfigNotFound extends \Exception
{
    public function __construct($module, Exception $previous = null)
    {
        parent::__construct("Module '{$module}' Not Found'", null, $previous);
    }
}
