<?php

namespace Nefarian\CmsBundle\Plugin\FieldBody\Field\Widget\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class WidgetBodySettingsForm
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Field\Widget\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class WidgetBodySettingsForm extends AbstractType
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
            'data_type' => 'Nefarian\CmsBundle\Plugin\FieldBody\Entity\FieldBody'
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
