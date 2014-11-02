<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Form\Type;

use Nefarian\CmsBundle\Configuration\ConfigManager;
use Nefarian\CmsBundle\Content\Field\Field;
use Nefarian\CmsBundle\Content\Field\FieldManager;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Node;
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
     * @var ConfigManager
     */
    protected $configManager;

    /**
     * @param FieldManager $fieldManager
     * @param ConfigManager $configManager
     */
    function __construct(FieldManager $fieldManager, ConfigManager $configManager)
    {
        $this->fieldManager  = $fieldManager;
        $this->configManager = $configManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $i = 0;
        if ($options['node'] instanceof Node) {
            $node          = $options['node'];
            $contentType   = $node->getContentType();
            $contents      = $node->getContents();
            $fieldContents = array();

            /** @var NodeContent $content */
            foreach ($contents as $content) {
                $fieldContents[$content->getFieldType()->getName()] = $content;
            }

            foreach ($contentType->getTypeFields() as $typeField) {
                $fieldEntity     = $typeField->getField();
                $field           = $this->fieldManager->getField($fieldEntity->getName());
                $fieldConfigName = 'content_type.' . $contentType->getName() . '.' . $typeField->getName();
                $config          = $this->configManager->get($fieldConfigName);

                if ($field instanceof Field) {
                    $formClass = $field->getForm();
                    $dataClass = $field->getEntityClass();

                    /** @var NodeContent $entity */
                    if (array_key_exists($typeField->getName(), $fieldContents)) {
                        $entity = $fieldContents[$typeField->getName()];
                    } else {
                        $entity = new $dataClass();
                        $entity->setField($fieldEntity);
                        $entity->setFieldType($typeField);
                    }

                    $builder->add($i, new $formClass($fieldEntity, $config), array(
                        'label' => false,
                        'data' => $entity,
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
            'node'
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
