<?php

namespace Nefarian\CmsBundle\Plugin\FieldCategory\Configuration;

use Nefarian\CmsBundle\Plugin\ContentManagement\Configuration\FieldConfiguration;

/**
 * Class FieldCategoryConfiguration
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldCategoryConfiguration extends FieldConfiguration
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.category';
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return null;
    }

} 
