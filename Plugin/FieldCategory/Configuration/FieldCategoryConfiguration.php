<?php

namespace Nefarian\CmsBundle\Plugin\FieldCategory\Configuration;

use Nefarian\CmsBundle\Plugin\ContentManagement\Configuration\FieldConfiguration;
use Nefarian\CmsBundle\Plugin\FieldCategory\Form\FieldCategorySettingsForm;

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
    public function getType()
    {
        return 'field.category';
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return new FieldCategorySettingsForm();
    }

} 
