<?php

namespace Nefarian\CmsBundle\Cache;

use Doctrine\Common\Cache\Cache;

class CacheManager
{
    protected $cacheBins = array();

    /**
     * @var CacheProviderInterface
     */
    protected $cacheProvider;

    function __construct(CacheProviderInterface $cacheProvider)
    {
        $this->cacheProvider = $cacheProvider;
    }

    public function hasCache($name)
    {
        return array_key_exists($name, $this->cacheBins);
    }

    /**
     * @param $name
     * @return Cache
     */
    public function get($name)
    {
        if(!$this->hasCache($name))
        {
            $this->cacheBins[$name] = $this->cacheProvider->create($name);
        }

        return $this->cacheBins[$name];
    }
} 
