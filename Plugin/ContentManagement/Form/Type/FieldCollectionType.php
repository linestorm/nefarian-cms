<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Form\Type;

use Nefarian\CmsBundle\Content\Field\ContentFieldManager;
use Nefarian\CmsBundle\Content\Field\Field;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\DataTransformer\FieldCollectionDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FieldCollectionType extends AbstractType
{
    /**
     * @var ContentFieldManager
     */
    protected $fieldManager;

    /**
     * @param ContentFieldManager $fieldManager
     */
    function __construct(ContentFieldManager $fieldManager)
    {
        $this->fieldManager = $fieldManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if($options['content_type'] instanceof ContentType)
        {
            foreach($options['content_type']->getTypeFields() as $typeField)
            {
                $fieldEntity = $typeField->getContentField();
                $field = $this->fieldManager->getField($fieldEntity->getName());
                if($field instanceof Field)
                {
                    $formClass = $field->getForm();
                    $builder->add($typeField->getName(), new $formClass($options['content_type']), array(
                        'label' => false
                    ));
                }
            }
        }
        $builder->addModelTransformer(new FieldCollectionDataTransformer());
    }


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'content_type'
        ));
        $resolver->setDefaults(array(
            'mapped' => true,
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'field_collection';
    }

    /**
     * @inheritdoc
     */
    public function getParent()
    {
        return 'form';
    }


} 
