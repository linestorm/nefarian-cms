<?php

namespace Nefarian\CmsBundle\Plugin\File\File\Optimiser\Optimisers;

use Nefarian\CmsBundle\Plugin\File\File\Optimiser\AbstractOptimiseProfile;
use Nefarian\CmsBundle\Plugin\File\File\Optimiser\OptimiseProfileInterface;
use Nefarian\CmsBundle\Plugin\File\Model\File;

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
     * Optimise a file image
     *
     * @param File $file
     *
     * @return mixed
     */
    public function optimise($file)
    {
        $info = getimagesize($file->getPath());

        switch($info['mime'])
        {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($file->getPath());
                break;
            case 'image/gif':
                $image = imagecreatefromgif($file->getPath());
                break;
            case 'image/png':
                $image = imagecreatefrompng($file->getPath());
                break;
            default:
                return $file;
                break;
        }

        //save file
        imagejpeg($image, $file->getPath(), $this->quality);

        //return destination file
        return $file;
    }

} 
