<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Form;

use Nefarian\CmsBundle\Content\Field\ContentFieldManager;
use Nefarian\CmsBundle\Content\Field\Field;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NodeContentTypeFieldForm extends AbstractType
{
    /**
     * @var ContentType
     */
    protected $contentType;

    /**
     * @var ContentFieldManager
     */
    protected $fieldManager;

    /**
     * @param ContentType         $contentType
     * @param ContentFieldManager $fieldManager
     */
    function __construct(ContentType $contentType, ContentFieldManager $fieldManager)
    {
        $this->contentType  = $contentType;
        $this->fieldManager = $fieldManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach($this->contentType->getTypeFields() as $typeField)
        {
            $fieldEntity = $typeField->getContentField();
            $field = $this->fieldManager->getField($fieldEntity->getName());
            if($field instanceof Field)
            {
                $formClass = $field->getForm();
                $builder->add('contentField', new $formClass($this->contentType), array(
                    'label' => false
                ));
            }
        }
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nefarian_plugin_content_management_content_type';
    }
}
