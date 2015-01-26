<?php

namespace Nefarian\CmsBundle\Plugin\FieldBody\Field\Configuration;

use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Configuration\FieldSettingsConfiguration;
use Nefarian\CmsBundle\Plugin\FieldBody\Field\Configuration\Form\FieldBodySettingsForm;

/**
 * Class FieldBodyConfiguration
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Field\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldBodyConfiguration extends FieldSettingsConfiguration
{

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'field.body';
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return new FieldBodySettingsForm();
    }
} 
