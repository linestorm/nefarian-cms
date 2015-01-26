<?php

namespace Nefarian\CmsBundle\Plugin\FieldBody\Asset;

use Nefarian\CmsBundle\Asset\AbstractAssetLibrary;

class TextBodyLibrary extends AbstractAssetLibrary
{
    public function getJavascripts()
    {
        return array(
            '@plugin_field_body/node/body.js',
        );
    }

}
