<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Form;

use Nefarian\CmsBundle\Content\Field\ContentFieldManager;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
        $builder
            ->add('title', 'text')
            ->add('description', 'text', array(
                'required' => false
            ))
        ;

        $typeFields = $this->contentType->getTypeFields();
        foreach($typeFields as $typeField)
        {
            $type = $typeField->getContentType();
            $field = $this->fieldManager->getField($type);
        }
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType'
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
