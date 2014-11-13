<?php

namespace Nefarian\CmsBundle\Plugin\File;

use Nefarian\CmsBundle\Plugin\Plugin;

/**
 * Class FilePlugin
 *
 * @package Nefarian\CmsBundle\Plugin\File
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FilePlugin extends Plugin
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'file';
    }
} 
