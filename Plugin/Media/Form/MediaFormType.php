<?php

namespace Nefarian\CmsBundle\Plugin\Media\Form;

use Nefarian\CmsBundle\Plugin\Media\Form\DataTransformer\MediaTransformer;
use Nefarian\CmsBundle\Plugin\Media\Media\MediaManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Class MediaFormType
 *
 * @package Nefarian\CmsBundle\Plugin\Media\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class MediaFormType extends AbstractType
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
        $defaultProvider = $this->mediaManager->getDefaultProviderInstance();
        $builder
            ->add('title', 'textarea')
            ->add('category', 'mediatreebrowser', array(
                'class'    => $defaultProvider->getCategoryEntityClass(),
                'property' => 'name',
                'constraints' => array(
                    new NotNull(),
                    new NotBlank(),
                )
            ))
            ->add('credits')
            ->add('alt')
            ->add('src', 'hidden')
            ->add('hash', 'hidden')
            ->add('name', 'hidden')
            ->add('nameOriginal', 'hidden')
            ->add('path', 'hidden')
        ;

        $transformer = new MediaTransformer($this->mediaManager);

        $builder->addModelTransformer($transformer);
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $defaultProvider = $this->mediaManager->getDefaultProviderInstance();
        $resolver->setDefaults(array(
            'label' => false,
            'data_class' => $defaultProvider->getEntityClass()
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'linestorm_cms_form_media';
    }
}
