<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Configuration;

use Nefarian\CmsBundle\Plugin\ContentManagement\Configuration\FieldConfiguration;

/**
 * Class FieldTagConfiguration
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldTagConfiguration extends FieldConfiguration
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.tag';
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return null;
    }

} 
