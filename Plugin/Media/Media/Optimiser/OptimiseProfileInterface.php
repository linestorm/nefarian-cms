<?php

namespace Nefarian\CmsBundle\Plugin\Media\Media\Optimiser;

use Nefarian\CmsBundle\Plugin\Media\Model\Media;

interface OptimiseProfileInterface
{
    /**
     * Optimise a media image
     *
     * @param Media $media
     *
     * @return mixed
     */
    public function optimise($media);
} 
