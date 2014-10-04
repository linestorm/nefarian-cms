<?php

namespace Nefarian\CmsBundle\Cache\Cache;

use Doctrine\Common\Cache\PhpFileCache;

class SerializedPhpFileCache extends PhpFileCache
{
    public function fetch($id)
    {
        return unserialize(parent::fetch($id));
    }

    public function save($id, $data, $lifeTime = 0)
    {
        return parent::save($id, serialize($data), $lifeTime);
    }
} 