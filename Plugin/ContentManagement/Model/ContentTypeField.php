<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Model;

class ContentTypeField
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var ContentType
     */
    protected $contentType;

    /**
     * @var ContentField
     */
    protected $contentField;

    /**
     * @var int
     */
    protected $order;
} 
