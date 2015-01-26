<?php

namespace Nefarian\CmsBundle\Configuration\Form;

use Nefarian\CmsBundle\Configuration\Configuration;
use Nefarian\CmsBundle\Configuration\ConfigurationInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ConfigSettingsForm
 *
 * @package Nefarian\CmsBundle\Configuration\Form
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ConfigurationSettingsForm extends AbstractType
{
    /**
     * @var ConfigurationInterface
     */
    protected $configuration;

    /**
     * @param ConfigurationInterface $configuration
     */
    function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($this->configuration->getAllSchemas() as $name => $config) {
            $builder->add($name, $config->type, (array)$config->options);
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

    /**
     * @return ConfigurationInterface
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
}
