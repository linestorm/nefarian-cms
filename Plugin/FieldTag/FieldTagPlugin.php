<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag;

use Nefarian\CmsBundle\Plugin\Plugin;

/**
 * Class FieldBodyPlugin
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldTagPlugin extends Plugin
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'field_tag';
    }

    public function dependencies()
    {
        return array(
            'content_management'
        );
    }

} 
