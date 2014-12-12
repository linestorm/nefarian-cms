<?php

namespace Nefarian\CmsBundle\Plugin\FieldCategory\Form;

use Nefarian\CmsBundle\Configuration\Configuration;
use Nefarian\CmsBundle\Configuration\ConfigurationInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Field;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\FieldNodeFormInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FieldCategoryForm
 *
 * @package Nefarian\CmsBundle\Plugin\FieldCategory\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldCategoryForm extends AbstractType implements FieldNodeFormInterface
{
    /**
     * @var ContentTypeField
     */
    protected $contentTypeField;

    /**
     * @param ContentTypeField $contentTypeField
     */
    function __construct(ContentTypeField $contentTypeField)
    {
        $this->contentTypeField = $contentTypeField;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $limit = $this->contentTypeField->getConfig()->getLimit();
        $builder
            ->add('category', 'entity', array(
                'label' => $limit == 1 ? null : $limit,
                'property' => 'name',
                'class' => 'Nefarian\CmsBundle\Plugin\FieldCategory\Entity\NodeCategory'
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
