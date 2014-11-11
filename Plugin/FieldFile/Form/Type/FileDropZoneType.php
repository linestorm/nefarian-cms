<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Form\Type;

use Symfony\Component\Form\AbstractType;
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
            ))
            ->setAllowedTypes(array(
                'limit' => 'integer'
            ))
        ;
    }

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
