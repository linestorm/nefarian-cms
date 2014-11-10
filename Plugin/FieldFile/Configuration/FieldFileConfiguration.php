<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Configuration;

use Nefarian\CmsBundle\Plugin\ContentManagement\Configuration\FieldConfiguration;
use Nefarian\CmsBundle\Plugin\FieldFile\Form\FieldFileSettingsForm;

/**
 * Class FieldFileConfiguration
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldFileConfiguration extends FieldConfiguration
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.file';
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return new FieldFileSettingsForm();
    }

} 
