<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile;

use Nefarian\CmsBundle\Plugin\Plugin;

/**
 * Class FieldFilePlugin
 *
 * @package Nefarian\CmsBundle\Plugin\FieldFile
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldFilePlugin extends Plugin
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'field_file';
    }

    public function dependencies()
    {
        return array(
            'content_management'
        );
    }

} 
