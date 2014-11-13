<?php

namespace Nefarian\CmsBundle\Plugin\File\File\Exception;

use Nefarian\CmsBundle\Plugin\File\Model\File;

/**
 * Class FileFileAlreadyExistsException
 *
 * @package Nefarian\CmsBundle\Plugin\File\File\Exception
 */
class FileFileAlreadyExistsException extends \Exception
{
    /**
     * @var File|null
     */
    private $entity;

    /**
     * @param string $entity
     * @param string $message
     */
    function __construct($entity, $message = 'The file file is already uploaded')
    {
        $this->entity = $entity;
        parent::__construct($message);
    }

    /**
     * get the entity that already existed
     *
     * @return File|null
     */
    public function getEntity()
    {
        return $this->entity;
    }


}
