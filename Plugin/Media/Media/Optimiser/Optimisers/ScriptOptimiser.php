<?php

namespace Nefarian\CmsBundle\Plugin\Media\Media\Optimiser\Optimisers;

use Nefarian\CmsBundle\Plugin\Media\Media\Optimiser\AbstractOptimiseProfile;
use Nefarian\CmsBundle\Plugin\Media\Media\Optimiser\OptimiseProfileInterface;
use Nefarian\CmsBundle\Plugin\Media\Model\Media;

/**
 * Use jpegoptim and optipng to optimise images
 *
 * Class ScriptOptimiser
 *
 * @package Nefarian\CmsBundle\Plugin\Media\Media\Optimiser\Optimisers
 */
class ScriptOptimiser extends AbstractOptimiseProfile implements OptimiseProfileInterface
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
        $info = getimagesize($media->getPath());

        switch($info['mime'])
        {
            case 'image/jpeg':
                exec("jpegoptim --strip-all \"{$media->getPath()}\"");
                break;
            case 'image/gif':
                $image = imagecreatefromgif($media->getPath());
                imagepng($image, $media->getPath());
                exec("optipng \"{$media->getPath()}\"");
                break;
            case 'image/png':
                exec("optipng \"{$media->getPath()}\"");
                break;
            default:
                return $media;
                break;
        }

        return $media;
    }

} 
