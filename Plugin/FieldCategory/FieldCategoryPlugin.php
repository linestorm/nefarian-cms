<?php

namespace Nefarian\CmsBundle\Plugin\FieldCategory;

use Nefarian\CmsBundle\Plugin\Plugin;

/**
 * Class FieldBodyPlugin
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldCategoryPlugin extends Plugin
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'field_category';
    }

    public function dependencies()
    {
        return array(
            'content_management'
        );
    }

} 
