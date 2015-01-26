<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Asset;

use Nefarian\CmsBundle\Asset\AbstractAssetLibrary;

class TagAutoCompleteLibrary extends AbstractAssetLibrary
{
    public function getJavascripts()
    {
        return array(
            '@plugin_field_tag/node/tags.js',
        );
    }

}
