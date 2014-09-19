<?php

namespace Nefarian\CmsBundle\Plugin\Media\Media\Optimiser\Optimisers;

use Nefarian\CmsBundle\Plugin\Media\Media\Optimiser\AbstractOptimiseProfile;
use Nefarian\CmsBundle\Plugin\Media\Media\Optimiser\OptimiseProfileInterface;
use Nefarian\CmsBundle\Plugin\Media\Model\Media;

class GDOptimiser extends AbstractOptimiseProfile implements OptimiseProfileInterface
{
    /**
     * The compression quality
     *
     * @var int
     */
    protected $quality = 75;

    /**
     * @return mixed
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @param mixed $quality
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;
    }

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
                $image = imagecreatefromjpeg($media->getPath());
                break;
            case 'image/gif':
                $image = imagecreatefromgif($media->getPath());
                break;
            case 'image/png':
                $image = imagecreatefrompng($media->getPath());
                break;
            default:
                return $media;
                break;
        }

        //save file
        imagejpeg($image, $media->getPath(), $this->quality);

        //return destination file
        return $media;
    }

} 
