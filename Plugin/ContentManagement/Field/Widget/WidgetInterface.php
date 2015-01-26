<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget;

use Nefarian\CmsBundle\Asset\AssetLibraryInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\FieldInterface;
use Symfony\Component\Form\AbstractType;

/**
 * Interface WidgetInterface
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface WidgetInterface
{
    /**
     * Get the identifier name of the field widget. This must be a unique name and contain only alphanumeric,
     * underscores (_) and period (.) characters in the format field.widget.<plugin>.<type>
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
     * Get the description of the field widget
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get the entity class name
     *
     * @return string
     */
    public function getEntityClass();

    /**
     * Get the form type for this widget
     *
     * @return AbstractType
     */
    public function getForm();

    /**
     * Get the settings
     *
     * @return WidgetSettingsInterface
     */
    public function getSettings();

    /**
     * Get a list of asset libraries to use
     *
     * @return AssetLibraryInterface[]
     */
    public function getAssetLibraries();

    /**
     * Checks if this widget supports the given field
     *
     * @param FieldInterface $field
     *
     * @return string
     */
    public function supportsField(FieldInterface $field);
}
