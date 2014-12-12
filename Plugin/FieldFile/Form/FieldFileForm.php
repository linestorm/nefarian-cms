<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Form;

use Nefarian\CmsBundle\Configuration\Configuration;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\FieldNodeFormInterface;
use Nefarian\CmsBundle\Plugin\FieldFile\Configuration\FieldFileConfiguration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\File;

/**
 * Class FieldFileForm
 *
 * @package Nefarian\CmsBundle\Plugin\FieldFile\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldFileForm extends AbstractType implements FieldNodeFormInterface
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
        /** @var FieldFileConfiguration $configuration */
        $configuration = $this->contentTypeField->getConfig();
        $limit = $configuration->getLimit();
        $builder
            ->add('files', 'file_dropzone', array(
                'type' => new FileType(),
                'options' => array(
                    'data_class' => 'Nefarian\CmsBundle\Plugin\File\Entity\File',
                    'constraints' => array(
                        new File(array(
                            'mimeTypes' => $configuration->getFileTypes(),
                        ))
                    )
                ),
                'mime_types' => $configuration->getFileTypes(),
                'form_id' => $this->contentTypeField->getId(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'limit' => (int)$limit,
                'label' => null,
            ));
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nefarian\CmsBundle\Plugin\FieldFile\Entity\FieldFile'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nefarian_plugin_field_file';
    }
}
