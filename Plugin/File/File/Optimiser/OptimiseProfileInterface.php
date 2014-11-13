<?php

namespace Nefarian\CmsBundle\Plugin\File\File\Optimiser;

use Nefarian\CmsBundle\Plugin\File\Model\File;

interface OptimiseProfileInterface
{
    /**
     * Optimise a file image
     *
     * @param File $file
     *
     * @return mixed
     */
    public function optimise($file);
} 
