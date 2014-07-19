<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContentTypeFieldForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('contentField', 'entity', array(
                'class' => 'Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentField',
                'property' => 'name',
            ))
            ->add('order', 'hidden')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nefarian_plugin_content_management_content_type_field';
    }
}
