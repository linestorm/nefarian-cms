<?php

namespace Nefarian\CmsBundle\Plugin\FieldCategory\Form;

use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Field;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class NodeCategoryForm
 *
 * @package Nefarian\CmsBundle\Plugin\FieldCategory\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeCategoryForm extends AbstractType
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
            'data_class' => 'Nefarian\CmsBundle\Plugin\FieldCategory\Entity\NodeCategory'
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
