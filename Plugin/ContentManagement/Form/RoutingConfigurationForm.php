<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class RoutingConfigurationForm
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class RoutingConfigurationForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('separator', 'text', array(
                'required' => true,
                'max_length' => 1,
            ))
            ->add('casing', 'choice', array(
                'choices' => array(
                    'Lower', 'Upper', 'Original'
                )
            ))
            ->add('maxLength', 'integer')
            ->add('removePunctuation', 'checkbox');
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nefarian\CmsBundle\Plugin\ContentManagement\Configuration\RoutingConfiguration'
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'nefarian_plugin_content_management_routing_configuration';
    }

} 
