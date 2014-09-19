<?php

namespace Nefarian\CmsBundle\Plugin\Media\Media\Exception;

/**
 * Class MediaFileDeniedException
 *
 * @package Nefarian\CmsBundle\Plugin\Media\Media\Exception
 */
class MediaFileDeniedException extends \Exception
{
    /**
     * @param string $mediaType
     */
    function __construct($mediaType)
    {
        parent::__construct("This media type is not allowed: {$mediaType}");
    }
}
