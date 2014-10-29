<?php

namespace Nefarian\CmsBundle\Configuration\Form;

use Nefarian\CmsBundle\Configuration\Configuration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ConfigSettingsForm
 *
 * @package Nefarian\CmsBundle\Configuration\Form
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ConfigSettingsForm extends AbstractType
{
    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @param Configuration $configuration
     */
    function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($this->configuration->getAll() as $name => $value) {
            $builder->add($name, 'text');
        }
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nefarian_config_settings';
    }
}
