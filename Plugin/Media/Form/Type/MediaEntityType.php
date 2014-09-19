<?php

namespace Nefarian\CmsBundle\Plugin\Media\Form\Type;

use Nefarian\CmsBundle\Plugin\Media\Form\DataTransformer\MediaEntityTransformer;
use Nefarian\CmsBundle\Plugin\Media\Media\MediaManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class MediaEntityType
 * @package Nefarian\CmsBundle\Plugin\Media\Form\Type
 */
class MediaEntityType extends AbstractType
{
    /**
     * @var MediaManager
     */
    protected $mediaManager;

    /**
     * @var MediaEntityTransformer
     */
    protected $transformer;

    /**
     * @param MediaManager $mediaManager
     */
    function __construct(MediaManager $mediaManager)
    {
        $this->mediaManager = $mediaManager;
        $this->transformer = new MediaEntityTransformer($this->mediaManager);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this->transformer);
    }


    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $media = $this->transformer->reverseTransform($view->vars['value']);
        $view->vars['media'] = $media;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'class' => $this->mediaManager->getDefaultProviderInstance()->getEntityClass(),
            'property' => 'title',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'hidden';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'mediaentity';
    }
}
