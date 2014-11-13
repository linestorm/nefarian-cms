<?php

namespace Nefarian\CmsBundle\Plugin\File\File\Optimiser\Optimisers;

use Nefarian\CmsBundle\Plugin\File\File\Optimiser\AbstractOptimiseProfile;
use Nefarian\CmsBundle\Plugin\File\File\Optimiser\OptimiseProfileInterface;
use Nefarian\CmsBundle\Plugin\File\Model\File;

/**
 * Use jpegoptim and optipng to optimise images
 *
 * Class ScriptOptimiser
 *
 * @package Nefarian\CmsBundle\Plugin\File\File\Optimiser\Optimisers
 */
class ScriptOptimiser extends AbstractOptimiseProfile implements OptimiseProfileInterface
{

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
                exec("jpegoptim --strip-all \"{$file->getPath()}\"");
                break;
            case 'image/gif':
                $image = imagecreatefromgif($file->getPath());
                imagepng($image, $file->getPath());
                exec("optipng \"{$file->getPath()}\"");
                break;
            case 'image/png':
                exec("optipng \"{$file->getPath()}\"");
                break;
            default:
                return $file;
                break;
        }

        return $file;
    }

} 
