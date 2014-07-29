<?php

namespace Nefarian\CmsBundle\Assetic;

/**
 * Class NefarianAssetManager
 *
 * @package Nefarian\CmsBundle\Assetic
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NefarianAssetManager
{
    protected $assetMap = array();

    public function setAssets(array $assetMap = array())
    {
        $this->assetMap = $assetMap;
    }

    public function hasAsset($name)
    {
        return array_key_exists($name, $this->assetMap);
    }

    public function getAsset($name)
    {
        if($this->hasAsset($name))
        {
            return $this->assetMap[$name];
        }
        else
        {
            return null;
        }
    }
} 
