<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Form;

use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\FieldNodeFormInterface;
use Nefarian\CmsBundle\Plugin\FieldTag\Configuration\FieldTagConfiguration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FieldTagForm
 *
 * @package Nefarian\CmsBundle\Plugin\FieldTag\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldTagForm extends AbstractType implements FieldNodeFormInterface
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
        /** @var FieldTagConfiguration $configuration */
        $configuration = $this->contentTypeField->getConfig();
        $limit         = $configuration->getLimit();
        $builder
            ->add('tags', 'tag', array(
                'tag_class' => 'Nefarian\CmsBundle\Plugin\FieldTag\Entity\NodeTag',
                'tag_base' => $configuration->getTag(),
                'name' => 'name',
                'label' => $limit == 1 ? null : $limit,
                'attr' => array(
                    'class' => 'form-control content-tags'
                )
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
