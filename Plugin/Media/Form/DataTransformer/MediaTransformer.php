<?php

namespace Nefarian\CmsBundle\Plugin\Media\Form\DataTransformer;

use Nefarian\CmsBundle\Plugin\Media\Media\MediaManager;
use Nefarian\CmsBundle\Plugin\Media\Model\Media;
use Symfony\Component\Form\DataTransformerInterface;

class MediaTransformer implements DataTransformerInterface
{
    /**
     * MediaManager
     *
     * @var MediaManager
     */
    private $mediaManager;

    /**
     * @param MediaManager $mediaManager
     */
    public function __construct(MediaManager $mediaManager)
    {
        $this->mediaManager = $mediaManager;
    }

    /**
     * Transforms the Document's value to a value for the form field
     */
    public function transform($data)
    {
        return $data;
    }

    /**
     * Transforms the value the users has typed to a value that suits the field in the Document
     */
    public function reverseTransform($data)
    {
        if($data instanceof Media)
        {
            return $data;
            if(!$data->getId() && $data->getHash())
            {
                $defaultProvider = $this->mediaManager->getDefaultProviderInstance();
                $fetched = $defaultProvider->findByHash($data->getHash());
                if($fetched instanceof Media)
                {
                    $fetched->setTitle($data->getTitle());
                    $fetched->setAlt($data->getAlt());
                    $fetched->setCredits($data->getCredits());

                    $data = $fetched;
                }
            }
        }

        return $data;
    }
}
