<?php

namespace Nefarian\CmsBundle\Plugin\Media\Form;

use Nefarian\CmsBundle\Plugin\Media\Form\DataTransformer\MediaTransformer;
use Nefarian\CmsBundle\Plugin\Media\Media\MediaManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class MediaCategoryFormType
 *
 * @package Nefarian\CmsBundle\Plugin\Media\Form
 */
class MediaCategoryFormType extends AbstractType
{

    /**
     * MediaManager
     *
     * @var MediaManager
     */
    protected $mediaManager;

    /**
     * @param MediaManager $mediaManager
     */
    function __construct(MediaManager $mediaManager)
    {
        $this->mediaManager = $mediaManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('parent', 'mediatreebrowser')
            ->add('media', 'collection', array(
                'type' => new MediaFormType($this->mediaManager),
                'allow_add' => true,
                'allow_delete' => true
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $defaultProvider = $this->mediaManager->getDefaultProviderInstance();
        $resolver->setDefaults(array(
            'label' => false,
            'data_class' => $defaultProvider->getCategoryEntityClass()
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'linestorm_cms_form_media_category';
    }
}
