<?php

namespace Nefarian\CmsBundle\Plugin\FieldCategory\Form;

use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Field;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FieldCategoryForm
 *
 * @package Nefarian\CmsBundle\Plugin\FieldCategory\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldCategoryForm extends AbstractType
{
    /**
     * @var Field
     */
    protected $field;

    /**
     * @param Field $field
     */
    function __construct(Field $field)
    {
        $this->field = $field;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', 'entity', array(
                'property' => 'name',
                'class'    => 'Nefarian\CmsBundle\Plugin\FieldCategory\Entity\NodeCategory'
            ));
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nefarian\CmsBundle\Plugin\FieldCategory\Entity\FieldCategory'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nefarian_plugin_field_category';
    }
}
