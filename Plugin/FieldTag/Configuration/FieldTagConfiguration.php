<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Configuration;

use Nefarian\CmsBundle\Plugin\ContentManagement\Configuration\FieldConfiguration;
use Nefarian\CmsBundle\Plugin\FieldTag\Form\FieldTagSettingsForm;

/**
 * Class FieldTagConfiguration
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldTagConfiguration extends FieldConfiguration
{
    protected $tag;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'field.tag';
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return new FieldTagSettingsForm();
    }

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param mixed $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

} 
