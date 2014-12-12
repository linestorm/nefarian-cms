<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\View;

use Nefarian\CmsBundle\Plugin\View\View\ViewForm;
use Nefarian\CmsBundle\Plugin\View\View\ViewInterface;

class NodeView implements ViewInterface
{
    /**
     * Get the name of the view
     *
     * @return string
     */
    public function getName()
    {
        return 'node';
    }

    public function getEntity()
    {
        return 'Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Node';
    }

    /**
     * @param ViewForm $viewForm
     *
     * @return mixed
     */
    public function buildViewForm(ViewForm $viewForm)
    {
        $viewForm
            ->addField('title', 'text')
            ->addField('description', 'text')
            ->addAssociation('contents', 'contents')
        ;
    }


} 
