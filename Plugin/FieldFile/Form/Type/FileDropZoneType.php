<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Form\Type;

use Nefarian\CmsBundle\Plugin\FieldFile\Form\DataTransformer\DropZoneDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FileDropZoneType
 *
 * @package Nefarian\CmsBundle\Plugin\FieldFile\Form\Type
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileDropZoneType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'limit' => 1,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'data_type' => 'Nefarian\CmsBundle\Plugin\File\Entity\File',
            ))
            ->setAllowedTypes(array(
                'limit' => 'integer'
            ))
        ;
    }

//    public function buildForm(FormBuilderInterface $builder, array $options)
//    {
//        $builder->addModelTransformer(new DropZoneDataTransformer());
//    }


    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['limit'] = $options['limit'];
    }


    public function getParent()
    {
        return 'collection';
    }

    public function getName()
    {
        return 'file_dropzone';
    }
}
