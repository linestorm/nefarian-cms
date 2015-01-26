<?php

namespace Nefarian\CmsBundle\Plugin\FieldBody\Field\Widget\Form;

use Nefarian\CmsBundle\Configuration\Configuration;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\FieldNodeFormInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class WidgetBodyForm
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Field\Widget\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class WidgetBodyForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $limit = $options['content_type_field']->getConfig()->getLimit();
        $builder
            ->add('body', 'textarea', array(
                'label' => $limit == 1 ? null : $limit,
                'attr' => array(
                    'class' => 'form-control wysiwyg-editor',
                    'data-limit' => $limit,
                ),
            ));
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Nefarian\CmsBundle\Plugin\FieldBody\Entity\FieldBody',
            )
        );

        $resolver->setRequired(array('content_type_field'));
        $resolver->setAllowedTypes(array(
            'content_type_field' => 'Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nefarian_plugin_field_body';
    }
}
