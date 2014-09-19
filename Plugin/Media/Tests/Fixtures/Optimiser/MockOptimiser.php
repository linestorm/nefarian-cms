<?php

namespace Nefarian\CmsBundle\Plugin\Media\Tests\Fixtures\Optimiser;

use Nefarian\CmsBundle\Plugin\Media\Media\Optimiser\OptimiseProfileInterface;
use Nefarian\CmsBundle\Plugin\Media\Model\Media;

class MockOptimiser implements OptimiseProfileInterface
{
    /**
     * Optimise a media image
     *
     * @param Media $media
     *
     * @return mixed
     */
    public function optimise($media)
    {
        return $media;
        // TODO: Implement optimise() method.
    }

} 
