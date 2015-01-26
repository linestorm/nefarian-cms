<?php

namespace Nefarian\CmsBundle\Plugin\FieldBody\Field\Configuration\Form;

use Nefarian\CmsBundle\Configuration\ConfigurationInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Field;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\FieldNodeFormInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FieldBodySettingsForm
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Field\Configuration\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldBodySettingsForm extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('limit', 'number');
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Nefarian\CmsBundle\Plugin\FieldBody\Field\Configuration\FieldBodyConfiguration',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nefarian_plugin_field_body_configuration';
    }
}
