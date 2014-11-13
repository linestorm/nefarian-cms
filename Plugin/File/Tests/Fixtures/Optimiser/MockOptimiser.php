<?php

namespace Nefarian\CmsBundle\Plugin\File\Tests\Fixtures\Optimiser;

use Nefarian\CmsBundle\Plugin\File\File\Optimiser\OptimiseProfileInterface;
use Nefarian\CmsBundle\Plugin\File\Model\File;

class MockOptimiser implements OptimiseProfileInterface
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
        return $file;
        // TODO: Implement optimise() method.
    }

} 
