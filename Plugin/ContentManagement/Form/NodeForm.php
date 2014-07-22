<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Form;

use Nefarian\CmsBundle\Content\Field\ContentFieldManager;
use Nefarian\CmsBundle\Content\Field\Field;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NodeForm extends AbstractType
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
     * @param ContentFieldManager $fieldManager
     * @param ContentType         $contentType
     */
    function __construct(ContentFieldManager $fieldManager, ContentType $contentType = null)
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
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $node = $event->getData();
            $form = $event->getForm();

            if($this->contentType instanceof ContentType)
            {
                $node->setContentType($this->contentType);
            }

            $typeFields = $node->getContentType()->getTypeFields();
            foreach($typeFields as $typeField)
            {
                $contentField = $typeField->getContentField();
                $field        = $this->fieldManager->getField($contentField->getName());
                if($field instanceof Field)
                {
                    $class = $field->getEntityClass();
                    $node->addContentField(new $class());
                }
            }

            $form->add('contentFields', 'field_collection', array(
                'label' => false,
                'content_type'  => $node->getContentType(),
            ));
        });

        $builder
            ->add('title', 'text')
            ->add('description', 'text', array(
                'required' => false
            ))
        ;
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Node',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nefarian_plugin_content_management_node';
    }
}
