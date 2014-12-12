<?php

namespace Nefarian\CmsBundle\Plugin\View\View;

/**
 * Class ViewFormBuilder
 *
 * @package Nefarian\CmsBundle\Plugin\View\View
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ViewFormBuilder
{
    /**
     * @param ViewInterface $view
     *
     * @return ViewForm
     */
    public function build(ViewInterface $view)
    {
        $viewForm = new ViewForm();

        $view->buildViewForm($viewForm);

        return $viewForm;
    }
} 
