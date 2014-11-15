<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\File;

/**
 * Class FileType
 *
 * @package Nefarian\CmsBundle\Plugin\FieldFile\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description', 'textarea')

            ->add('filename', 'hidden')
            ->add('path', 'hidden')
            ->add('url', 'hidden')
            ->add('size', 'hidden')
            ->add('status', 'hidden')
        ;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'nefarian_plugin_file';
    }

} 
