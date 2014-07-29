<?php

namespace Nefarian\CmsBundle\Twig;

use Nefarian\CmsBundle\Assetic\NefarianAssetManager;

class PluginExtension extends \Twig_Extension
{
    /**
     * @var NefarianAssetManager
     */
    protected $assetManager;

    /**
     * @param NefarianAssetManager $assetManager
     */
    function __construct(NefarianAssetManager $assetManager)
    {
        $this->assetManager = $assetManager;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('require_asset', array($this, 'requireAsset')),
        );
    }

    /**
     * @param $asset
     *
     * @return mixed
     */
    public function requireAsset($asset)
    {
        if(strpos($asset, '@') === 0)
        {
            $asset = $this->assetManager->getAsset($asset);
        }

        if(strpos($asset, '/') === 0)
        {
            $asset = substr($asset, 1);
        }

        return str_replace('.js', '', $asset);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'nefarian_theme';
    }

} 
