<?php

namespace Nefarian\CmsBundle\Plugin\Media\Media\Exception;

use Nefarian\CmsBundle\Plugin\Media\Model\Media;

/**
 * Class MediaFileAlreadyExistsException
 *
 * @package Nefarian\CmsBundle\Plugin\Media\Media\Exception
 */
class MediaFileAlreadyExistsException extends \Exception
{
    /**
     * @var Media|null
     */
    private $entity;

    /**
     * @param string $entity
     * @param string $message
     */
    function __construct($entity, $message = 'The media file is already uploaded')
    {
        $this->entity = $entity;
        parent::__construct($message);
    }

    /**
     * get the entity that already existed
     *
     * @return Media|null
     */
    public function getEntity()
    {
        return $this->entity;
    }


}
