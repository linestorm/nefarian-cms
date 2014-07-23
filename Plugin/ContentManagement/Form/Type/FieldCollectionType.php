<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Form\Type;

use Nefarian\CmsBundle\Content\Field\FieldManager;
use Nefarian\CmsBundle\Content\Field\Field;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\NodeContent;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\DataTransformer\FieldCollectionDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FieldCollectionType extends AbstractType
{
    /**
     * @var FieldManager
     */
    protected $fieldManager;

    /**
     * @param FieldManager $fieldManager
     */
    function __construct(FieldManager $fieldManager)
    {
        $this->fieldManager = $fieldManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $i = 0;
        if($options['content_type'] instanceof ContentType)
        {
            foreach($options['content_type']->getTypeFields() as $typeField)
            {
                $fieldEntity = $typeField->getField();
                $field = $this->fieldManager->getField($fieldEntity->getName());
                if($field instanceof Field)
                {
                    $formClass = $field->getForm();
                    $dataClass = $field->getEntityClass();
                    /** @var NodeContent $entity */
                    $entity = new $dataClass();
                    $entity->setField($fieldEntity);
                    $builder->add($typeField->getName(), new $formClass($fieldEntity), array(
                        'label' => false,
                        'data'  => $entity,
                        'by_reference' => false,
                    ));
                    ++$i;
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
