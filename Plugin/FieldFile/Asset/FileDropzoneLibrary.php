<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Asset;

use Nefarian\CmsBundle\Asset\AbstractAssetLibrary;

class FileDropzoneLibrary extends AbstractAssetLibrary
{
    public function getJavascripts()
    {
        return array(
            '@plugin_field_file/file/dropzone.js',
        );
    }

}
