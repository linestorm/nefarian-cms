<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Field\Configuration\Form;

use Nefarian\CmsBundle\Configuration\ConfigurationInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Field;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\FieldNodeFormInterface;
use Nefarian\CmsBundle\Plugin\FieldFile\Form\DataTransformer\DataTypeListDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * Class FieldFileSettingsForm
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldFileSettingsForm extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('limit', 'number')
            ->add(
                $builder->create('fileTypes', 'text', array(
                ))
                    ->addModelTransformer(new DataTypeListDataTransformer())
            )
        ;
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Nefarian\CmsBundle\Plugin\FieldFile\Field\Configuration\FieldFileConfiguration',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nefarian_plugin_field_file_configuration';
    }
}
