<?php

namespace Nefarian\CmsBundle\Content;

use Nefarian\CmsBundle\Content\Field\ContentFieldManager;

class ContentManager
{
    /**
     * @var ContentFieldManager
     */
    protected $fieldManager;

    /**
     * @param ContentFieldManager $fieldManager
     */
    function __construct(ContentFieldManager $fieldManager)
    {
        $this->fieldManager = $fieldManager;
    }

} 
