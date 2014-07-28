<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Form;

use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Field;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FieldTagForm
 *
 * @package Nefarian\CmsBundle\Plugin\FieldTag\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldTagForm extends AbstractType
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
            /*->add('tags', 'tag', array(
                'tag_class' => 'Nefarian\CmsBundle\Plugin\FieldTag\Entity\NodeTag',
                'name'      => 'name',
            ))*/
            ->add('tags', 'entity', array(
                'multiple' => true,
                'class'    => 'Nefarian\CmsBundle\Plugin\FieldTag\Entity\NodeTag',
                'property' => 'name',
            ));
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nefarian\CmsBundle\Plugin\FieldTag\Entity\FieldTag'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nefarian_plugin_field_tag';
    }
}
