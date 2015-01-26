<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Field;

use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Configuration\FieldSettingsConfiguration;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Display\DisplayInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget\WidgetInterface;

/**
 * Interface FieldInterface
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Field
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface FieldInterface
{
    /**
     * Get the identifier name of the field. This must be a unique name and contain only alphanumeric, underscores (_)
     * and period (.) characters in the format field.<plugin>.<type>
     *
     * @return string
     */
    public function getName();

    /**
     * A friendly text label for the field widget
     *
     * @return string
     */
    public function getLabel();

    /**
     * Get the description of the field
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get the entity class name for this field
     *
     * @return string
     */
    public function getEntityClass();

    /**
     * @return FieldSettingsConfiguration
     */
    public function getSettings();

    /**
     * @return WidgetInterface
     */
    public function getWidget();

    /**
     * @return DisplayInterface
     */
    public function getDisplay();
}
