<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Field\Configuration;

use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Configuration\FieldSettingsConfiguration;
use Nefarian\CmsBundle\Plugin\FieldTag\Field\Configuration\Form\FieldTagSettingsForm;

/**
 * Class FieldTagConfiguration
 *
 * @package Nefarian\CmsBundle\Plugin\FieldTag\Field\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldTagConfiguration extends FieldSettingsConfiguration
{
    protected $tag;

    protected $multiple = true;

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

    /**
     * @return boolean
     */
    public function isMultiple()
    {
        return $this->multiple;
    }

    /**
     * @param boolean $multiple
     */
    public function setMultiple($multiple)
    {
        $this->multiple = $multiple;
    }
} 
