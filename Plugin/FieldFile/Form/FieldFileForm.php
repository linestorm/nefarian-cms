<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Form;

use Nefarian\CmsBundle\Configuration\Configuration;
use Nefarian\CmsBundle\Configuration\ConfigurationInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Field;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\FieldNodeFormInterface;
use Nefarian\CmsBundle\Plugin\FieldFile\Configuration\FieldFileConfiguration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FieldFileForm
 *
 * @package Nefarian\CmsBundle\Plugin\FieldFile\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldFileForm extends AbstractType implements FieldNodeFormInterface
{
    /**
     * @var Field
     */
    protected $field;

    /**
     * @var FieldFileConfiguration
     */
    protected $configuration;

    /**
     * @param Field                  $field
     * @param ConfigurationInterface $configuration
     */
    function __construct(Field $field, ConfigurationInterface $configuration)
    {
        $this->field         = $field;
        $this->configuration = $configuration;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $limit = $this->configuration->getLimit();
        $builder
            ->add('files', 'file_dropzone', array(
                'type' => new FileType(),
                'options' => array(
                    'data_class' => 'Nefarian\CmsBundle\Plugin\File\Entity\File',
                ),
                'config_name' => $this->configuration->getName(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'limit' => (int)$limit,
                'label' => $limit == 1 ? null : $limit,
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
