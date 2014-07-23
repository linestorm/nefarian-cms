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

class NodeFieldForm extends AbstractType
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
     * @param ContentType         $contentType
     * @param FieldManager $fieldManager
     */
    function __construct(ContentType $contentType, FieldManager $fieldManager)
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

        $type = $this;
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($type) {
            // ... adding the name field if needed
            $entity = $event->getData();
            var_dump($entity);
            $form = $event->getForm();
            $type->contentType;


        });

        foreach($this->contentType->getTypeFields() as $typeField)
        {
            $fieldEntity = $typeField->getField();
            $field = $this->fieldManager->getField($fieldEntity->getName());
            if($field instanceof Field)
            {
                $formClass = $field->getForm();
                /** @var AbstractType $class */
                $class = new $formClass($this->contentType);
                $class->buildForm($builder, $options);
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
            //'data_class' => 'Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField'
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
