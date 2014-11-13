<?php

namespace Nefarian\CmsBundle\Plugin\File\File\Exception;

/**
 * Class FileFileDeniedException
 *
 * @package Nefarian\CmsBundle\Plugin\File\File\Exception
 */
class FileFileDeniedException extends \Exception
{
    /**
     * @param string $fileType
     */
    function __construct($fileType)
    {
        parent::__construct("This file type is not allowed: {$fileType}");
    }
}
