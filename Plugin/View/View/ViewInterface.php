<?php

namespace Nefarian\CmsBundle\Plugin\View\View;

interface ViewInterface
{
    /**
     * Get the name of the view
     *
     * @return string
     */
    public function getName();

    /**
     * Get the entity class for which this view provides
     *
     * @return string
     */
    public function getEntity();

    /**
     * @param ViewForm $viewForm
     *
     * @return mixed
     */
    public function buildViewForm(ViewForm $viewForm);
} 
