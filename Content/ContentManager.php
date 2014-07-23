<?php

namespace Nefarian\CmsBundle\Content;

use Nefarian\CmsBundle\Content\Field\FieldManager;

class ContentManager
{
    /**
     * @var FieldManager
     */
    protected $fieldManager;

    /**
     * @param FieldManager $fieldManager
     */
    function __construct(FieldManager $fieldManager)
    {
        $this->fieldManager = $fieldManager;
    }


} 
