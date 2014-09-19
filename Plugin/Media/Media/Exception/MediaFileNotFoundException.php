<?php

namespace Nefarian\CmsBundle\Plugin\Media\Media\Exception;

use Nefarian\CmsBundle\Plugin\Media\Model\Media;

/**
 * Class MediaFileNotFoundException
 *
 * @package Nefarian\CmsBundle\Plugin\Media\Media\Exception
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class MediaFileNotFoundException extends \Exception
{
    /**
     * @param string     $path
     * @param \Exception $e
     */
    function __construct($path, \Exception $e = null)
    {
        parent::__construct("This media file not found: {$path}", null, $e);
    }
}
