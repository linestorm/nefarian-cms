<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Model;

Abstract class BaseFieldEntity
{
    /**
     * @var ContentType
     */
    protected $contentType;

    /**
     * @param ContentType $contentType
     */
    public function setContentType(ContentType $contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * @return ContentType
     */
    public function getContentType()
    {
        return $this->contentType;
    }


} 
