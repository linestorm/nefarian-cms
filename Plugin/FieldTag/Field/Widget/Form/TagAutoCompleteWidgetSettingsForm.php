<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Field\Widget\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TagAutoCompleteWidgetSettingsForm
 *
 * @package Nefarian\CmsBundle\Plugin\FieldTag\Field\Widget\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagAutoCompleteWidgetSettingsForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('useEditor', 'checkbox');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_type' => 'Nefarian\CmsBundle\Plugin\FieldTag\Entity\FieldTag'
        ));
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field_type_text_widget_editor_settings';
    }

}
