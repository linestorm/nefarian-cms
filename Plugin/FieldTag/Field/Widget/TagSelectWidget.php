<?php
/**
 * Created by Andy Thorne
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */

namespace Nefarian\CmsBundle\Plugin\FieldTag\Field\Widget;


use Nefarian\CmsBundle\Plugin\ContentManagement\Field\FieldInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget\AbstractWidget;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget\WidgetSettingsInterface;
use Symfony\Component\Form\AbstractType;

class TagSelectWidget extends AbstractWidget
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.type.tag.widget.select';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Dropdown Box';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'Tags Using Dropdown Box';
    }

    public function getForm()
    {
        return 'nefarian_plugin_field_tag_widget_select';
    }

    public function getEntityClass()
    {
        return 'Nefarian\CmsBundle\Plugin\FieldTag\Entity\FieldTag';
    }

    /**
     * Checks if this widget supports the given field
     *
     * @param FieldInterface $field
     *
     * @return string
     */
    public function supportsField(FieldInterface $field)
    {
        return ($field->getName() === 'field.type.tag');
    }

}
