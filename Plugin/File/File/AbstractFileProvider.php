<?php

namespace Nefarian\CmsBundle\Plugin\File\File;

use LineStorm\SearchBundle\Search\SearchProviderInterface;

/**
 * Class AbstractFileProvider
 * @package Nefarian\CmsBundle\Plugin\File\File
 */
abstract class AbstractFileProvider
{
    /**
     * ID of the file provider
     *
     * @var string
     */
    protected $id;

    /**
     * The name of the form service
     *
     * @var string
     */
    protected $form;

    /**
     * @var SearchProviderInterface
     */
    protected $searchProvider;

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @inheritdoc
     */
    public function setSearchProvider(SearchProviderInterface $searchProvider)
    {
        $this->searchProvider = $searchProvider;
    }
} 
