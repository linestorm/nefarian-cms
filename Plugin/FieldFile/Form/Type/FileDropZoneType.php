<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Form\Type;

use Nefarian\CmsBundle\Plugin\File\Model\File;
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
            ->setRequired(array(
                'form_id'
            ))
            ->setDefaults(array(
                'limit' => 1,
                'allow_add' => true,
                'allow_delete' => true,
                'data_type' => 'Nefarian\CmsBundle\Plugin\File\Entity\File',
                'mime_types' => array(),
            ))
            ->setAllowedTypes(array(
                'form_id' => 'integer',
                'limit' => 'integer',
                'mime_types' => 'array',
            ));
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['files'] = array();
        if ($view->vars['value']) {
            foreach ($view->vars['value'] as $child) {
                if ($child instanceof File) {
                    $view->vars['files'][] = new \Nefarian\CmsBundle\Plugin\File\Document\File($child);
                }
            }
        }
        $view->vars['mimeTypes'] = $options['mime_types'];
        $view->vars['limit']     = $options['limit'];
        $view->vars['form_id']   = $options['form_id'];
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
