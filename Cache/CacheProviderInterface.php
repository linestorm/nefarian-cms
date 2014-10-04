<?php

namespace Nefarian\CmsBundle\Cache;

use Doctrine\Common\Cache\Cache;

interface CacheProviderInterface
{
    /**
     * @param $name
     * @return Cache
     */
    public function create($name);
} 