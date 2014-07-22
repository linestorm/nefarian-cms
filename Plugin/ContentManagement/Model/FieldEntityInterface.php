<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Model;


interface FieldEntityInterface
{
    public function setContentType(ContentType $contentType);

    public function getContentType();
}
