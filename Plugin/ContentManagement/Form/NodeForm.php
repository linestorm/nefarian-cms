<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Form;

use Nefarian\CmsBundle\Content\Field\FieldManager;
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
     * @var FieldManager
     */
    protected $fieldManager;

    /**
     * @param FieldManager $fieldManager
     * @param ContentType         $contentType
     */
    function __construct(FieldManager $fieldManager, ContentType $contentType = null)
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

            /*
            if(!$node->getFields())
            {
                $typeFields = $node->getContentType()->getTypeFields();
                foreach($typeFields as $typeField)
                {
                    $Field = $typeField->getField();
                    $field        = $this->fieldManager->getField($Field->getName());
                    if($field instanceof Field)
                    {
                        $class = $field->getEntityClass();
                        $node->addField(new $class());
                    }
                }
            }
            */

            $form->add('contents', 'field_collection', array(
                'label' => false,
                'content_type'  => $node->getContentType(),
                'by_reference' => false,
            ));
        });

        $builder
            ->add('title', 'text')
            ->add('description', 'text', array(
                'required' => false
            ))
            ->add('path', 'text')
            ->add('published', 'checkbox')
            ->add('publishedOn', 'datetime', array(
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
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
