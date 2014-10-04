<?php

namespace Nefarian\CmsBundle\Cache\Provider;

use Doctrine\Common\Cache\PhpFileCache;
use Nefarian\CmsBundle\Cache\CacheProviderInterface;

class PhpFileCacheProvider implements CacheProviderInterface
{
    /**
     * @var string
     */
    protected $cacheDir;

    function __construct($cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    public function create($name)
    {
        return new PhpFileCache($this->cacheDir . '/' . $name);
    }
} 