<?php

namespace Nefarian\CmsBundle\Plugin\FieldBody\Configuration;

use Nefarian\CmsBundle\Plugin\ContentManagement\Configuration\FieldConfiguration;
use Nefarian\CmsBundle\Plugin\FieldBody\Form\FieldBodySettingsForm;

/**
 * Class FieldBodyConfiguration
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldBodyConfiguration extends FieldConfiguration
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
