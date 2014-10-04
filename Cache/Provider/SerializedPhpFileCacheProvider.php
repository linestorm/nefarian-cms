<?php

namespace Nefarian\CmsBundle\Cache\Provider;

use Nefarian\CmsBundle\Cache\Cache\SerializedPhpFileCache;
use Nefarian\CmsBundle\Cache\CacheProviderInterface;

class SerializedPhpFileCacheProvider implements CacheProviderInterface
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
        return new SerializedPhpFileCache($this->cacheDir . '/' . $name);
    }
} 