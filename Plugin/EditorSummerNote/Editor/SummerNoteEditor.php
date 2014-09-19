<?php

namespace Nefarian\CmsBundle\Plugin\EditorSummerNote\Editor;

use Nefarian\CmsBundle\Editor\EditorInterface;

/**
 * Class SummerNoteEditor
 *
 * @package Nefarian\CmsBundle\Plugin\EditorSummerNote\Editor
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class SummerNoteEditor implements EditorInterface
{
    public function getName()
    {
        return 'summernote';
    }

    public function getAssets()
    {
        return array(
            '@plugin_editor_summernote/summernote/editor.js',
        );
    }

} 
