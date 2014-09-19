<?php

namespace Nefarian\CmsBundle\Plugin\View;

use Nefarian\CmsBundle\Plugin\Plugin;

/**
 * Class ViewPluginPlugin
 *
 * @package Nefarian\CmsBundle\Plugin\View
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ViewPlugin extends Plugin
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'view';
    }

} 
