<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Form;

use Nefarian\CmsBundle\Configuration\Configuration;
use Nefarian\CmsBundle\Configuration\ConfigurationInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Field;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\FieldNodeFormInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FieldTagForm
 *
 * @package Nefarian\CmsBundle\Plugin\FieldTag\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldTagForm extends AbstractType implements FieldNodeFormInterface
{
    /**
     * @var Field
     */
    protected $field;

    /**
     * @var ConfigurationInterface
     */
    protected $config;

    /**
     * @param Field         $field
     * @param ConfigurationInterface $configuration
     */
    function __construct(Field $field, ConfigurationInterface $configuration)
    {
        $this->field  = $field;
        $this->config = $configuration;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tags', 'tag', array(
                'tag_class' => 'Nefarian\CmsBundle\Plugin\FieldTag\Entity\NodeTag',
                'tag_base' => $this->config->getTag(),
                'name' => 'name',
                'label' => false,
                'attr' => array(
                    'class' => 'form-control content-tags'
                )
            ));
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nefarian\CmsBundle\Plugin\FieldTag\Entity\FieldTag'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nefarian_plugin_field_tag';
    }
}
