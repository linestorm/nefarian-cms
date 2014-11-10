<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Form;

use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Field;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class NodeFileForm
 *
 * @package Nefarian\CmsBundle\Plugin\FieldFile\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeFileForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description')
        ;
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nefarian\CmsBundle\Plugin\FieldFile\Entity\NodeCategory'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nefarian_plugin_node_category';
    }
}
