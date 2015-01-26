<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Field\Widget\Form;

use Doctrine\ORM\EntityManager;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField;
use Nefarian\CmsBundle\Plugin\FieldFile\AutoComplete\TagAutoCompleteHandler;
use Nefarian\CmsBundle\Plugin\FieldFile\Field\Configuration\FieldFileConfiguration;
use Nefarian\CmsBundle\Plugin\FieldFile\Form\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\File;

/**
 * Class FileDropzoneWidgetForm
 *
 * @package Nefarian\CmsBundle\Plugin\FieldFile\Field\Widget\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileDropzoneWidgetForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var FieldFileConfiguration $configuration */
        /** @var ContentTypeField $typeField */
        $typeField     = $options['content_type_field'];
        $configuration = $typeField->getConfig();
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
                'form_id' => $typeField->getId(),
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
        $resolver->setDefaults(
            array(
                'data_class' => 'Nefarian\CmsBundle\Plugin\FieldFile\Entity\FieldFile'
            )
        );

        $resolver->setRequired(array('content_type_field'));
        $resolver->setAllowedTypes(array(
            'content_type_field' => 'Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nefarian_plugin_field_file_widget_dropzone';
    }
}
