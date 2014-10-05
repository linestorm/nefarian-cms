<?php

namespace Nefarian\CmsBundle\Plugin\FieldBody;

use Nefarian\CmsBundle\Plugin\Plugin;

/**
 * Class FieldBodyPlugin
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldBodyPlugin extends Plugin
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'field_body';
    }

    public function dependencies()
    {
        return array(
            'content_management'
        );
    }
} 
