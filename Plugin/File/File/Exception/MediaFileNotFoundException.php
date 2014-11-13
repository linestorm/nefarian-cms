<?php

namespace Nefarian\CmsBundle\Plugin\File\File\Exception;

use Nefarian\CmsBundle\Plugin\File\Model\File;

/**
 * Class FileFileNotFoundException
 *
 * @package Nefarian\CmsBundle\Plugin\File\File\Exception
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileFileNotFoundException extends \Exception
{
    /**
     * @param string     $path
     * @param \Exception $e
     */
    function __construct($path, \Exception $e = null)
    {
        parent::__construct("This file file not found: {$path}", null, $e);
    }
}
