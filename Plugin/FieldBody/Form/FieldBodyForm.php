<?php

namespace Nefarian\CmsBundle\Plugin\FieldBody\Form;

use Nefarian\CmsBundle\Configuration\Configuration;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Field;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\FieldNodeFormInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class NodeForm
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldBodyForm extends AbstractType implements FieldNodeFormInterface
{
    /**
     * @var Field
     */
    protected $field;

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @param Field         $Field
     * @param Configuration $configuration
     */
    function __construct(Field $Field, Configuration $configuration)
    {
        $this->field         = $Field;
        $this->configuration = $configuration;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $limit = $this->configuration->get('limit');
        $builder
            ->add('body', 'textarea', array(
                'label' => false,
                'attr' => array(
                    'class' => 'form-control wysiwyg-editor',
                    'data-limit' => $limit,
                ),
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
                'data_class' => 'Nefarian\CmsBundle\Plugin\FieldBody\Entity\FieldBody',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nefarian_plugin_field_body';
    }
}
