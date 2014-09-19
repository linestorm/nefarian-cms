<?php

namespace Nefarian\CmsBundle\Plugin\Media\Media;

use LineStorm\SearchBundle\Search\SearchProviderInterface;

/**
 * Class AbstractMediaProvider
 * @package Nefarian\CmsBundle\Plugin\Media\Media
 */
abstract class AbstractMediaProvider
{
    /**
     * ID of the media provider
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
