<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\View;

use Nefarian\CmsBundle\Plugin\View\View\BaseViewInterface;

class NodeView implements BaseViewInterface
{
    public function getEntity()
    {
        return 'Nefarian\CmsBundle\Plugin\ContentManagement\Model\Node';
    }
} 
